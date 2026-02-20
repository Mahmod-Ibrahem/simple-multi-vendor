<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Traits\ImagesUtility;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    use ImagesUtility, AuthorizesRequests;

    /**
     * Display a listing of the resource.
     * مدير النظام: sees all products.
     * عميل: sees only his own products.
     */
    public function index()
    {
        $this->authorize('viewAny', Product::class);

        $user = Auth::user();

        if ($user->hasRole('مدير النظام') || $user->id === 1) {
            $products = Product::with('category', 'user')->latest()->paginate(15);
        } else {
            $products = Product::with('category', 'user')
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(15);
        }

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Product::class);

        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * user_id is always set to auth user for clients.
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        $this->authorize('create', Product::class);

        $data = $request->validated();
        $data['user_id'] = auth()->id();

        // Handle Main Image
        if ($request->hasFile('main_image')) {
            $data['main_image'] = $this->storeImage($request->file('main_image'), 'products');
        }

        // Handle Gallery Images
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $this->storeImage($image, 'products');
                $images[] = ['url' => $path];
            }
            $data['images'] = $images;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'تم إضافة المنتج بنجاح.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $this->authorize('update', $product);

        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $this->authorize('update', $product);

        $data = $request->validated();

        // Handle Main Image Update
        if ($request->hasFile('main_image')) {
            $data['main_image'] = $this->storeImage($request->file('main_image'), 'products');
        }

        // Handle Gallery Images Update
        if ($request->hasFile('images')) {
            $newImages = [];
            foreach ($request->file('images') as $image) {
                $path = $this->storeImage($image, 'products');
                $newImages[] = ['url' => $path];
            }
            $data['images'] = $newImages;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'تم تحديث المنتج بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->authorize('delete', $product);

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'تم حذف المنتج بنجاح.');
    }
}
