<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryService
{
    /**
     * Get all categories (paginated or all).
     *
     * @param bool $paginate
     * @param int $perPage
     * @return LengthAwarePaginator|Collection
     */
    public function getAllCategories(bool $paginate = true, int $perPage = 15): LengthAwarePaginator|Collection
    {
        $query = Category::query()->latest();

        return $paginate ? $query->paginate($perPage) : $query->get();
    }

    /**
     * Get a single category by ID.
     *
     * @param int $id
     * @return Model
     */
    public function getCategoryById(int $id): Model
    {
        return Category::findOrFail($id);
    }

    /**
     * Create a new category.
     *
     * @param array $data
     * @return Category
     */
    public function createCategory(array $data): Category
    {
        try {
            DB::beginTransaction();

            $category = Category::create($data);

            DB::commit();

            Log::info('Category created successfully', ['category_id' => $category->id]);

            return $category;
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('فشل إنشاء التصنيف', [
                'error' => $e->getMessage(),
                'data' => $data,
            ]);

            throw $e;
        }
    }

    /**
     * Update an existing category.
     *
     * @param Category $category
     * @param array $data
     * @return Category
     */
    public function updateCategory(Category $category, array $data): Category
    {
        try {
            DB::beginTransaction();

            $category->update($data);

            DB::commit();

            Log::info('Category updated successfully', ['category_id' => $category->id]);

            return $category;
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('فشل تحديث التصنيف', [
                'category_id' => $category->id,
                'error' => $e->getMessage(),
                'data' => $data,
            ]);

            throw $e;
        }
    }

    /**
     * Delete a category.
     *
     * @param Category $category
     * @return bool
     */
    public function deleteCategory(Category $category): bool
    {
        try {
            DB::beginTransaction();

            // Check if category has products
            if ($category->products()->exists()) {
                throw new \Exception('لا يمكن حذف التصنيف لارتباطه بمنتجات موجودة.');
            }

            $deleted = $category->delete();

            DB::commit();

            Log::info('Category deleted successfully', ['category_id' => $category->id]);

            return $deleted;
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('فشل حذف التصنيف', [
                'category_id' => $category->id,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
