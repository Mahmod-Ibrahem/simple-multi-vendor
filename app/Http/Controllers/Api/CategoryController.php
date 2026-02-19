<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use AuthorizesRequests;

    /**
     * CategoryController constructor.
     *
     * @param CategoryService $categoryService
     */
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    /**
     * Display a listing of categories.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Category::class);

        $paginate = $request->boolean('paginate', true);
        $perPage = $request->input('per_page', 15);

        $categories = $this->categoryService->getAllCategories($paginate, $perPage);

        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created category.
     *
     * @param CategoryRequest $request
     * @return JsonResponse
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        $this->authorize('create', Category::class);

        $category = $this->categoryService->createCategory($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'تم إنشاء التصنيف بنجاح',
            'data' => new CategoryResource($category),
        ], 201);
    }

    /**
     * Display the specified category.
     *
     * @param Category $category
     * @return CategoryResource
     */
    public function show(Category $category): CategoryResource
    {
        $this->authorize('view', $category);

        return new CategoryResource($category);
    }

    /**
     * Update the specified category.
     *
     * @param CategoryRequest $request
     * @param Category $category
     * @return JsonResponse
     */
    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        $this->authorize('update', $category);

        $updatedCategory = $this->categoryService->updateCategory($category, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث التصنيف بنجاح',
            'data' => new CategoryResource($updatedCategory),
        ]);
    }

    /**
     * Remove the specified category.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function destroy(Category $category): JsonResponse
    {
        $this->authorize('delete', $category);

        try {
            $this->categoryService->deleteCategory($category);

            return response()->json([
                'success' => true,
                'message' => 'تم حذف التصنيف بنجاح',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشل في حذف التصنيف: ' . $e->getMessage(),
            ], 422);
        }
    }
}
