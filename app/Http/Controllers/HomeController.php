<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application landing page with published products.
     */
    public function index(Request $request)
    {
        $query = Product::with('category', 'user')->where('published', true);

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'low-price':
                    $query->orderBy('price', 'asc');
                    break;
                case 'high-price':
                    $query->orderBy('price', 'desc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(15)->withQueryString();
        $categories = Category::all();

        return view('admin.index', compact('products', 'categories'));
    }

    /**
     * Show a single product details page.
     */
    public function show(Product $product)
    {
        // Increment visits count
        $product->increment('visits_count');

        $product->load('category', 'user');

        return view('admin.product-details', compact('product'));
    }

    /**
     * Track a WhatsApp click and redirect to the WhatsApp link.
     */
    public function trackWhatsapp(Product $product)
    {
        // Increment Whatsapp clicks
        $product->increment('whatsapp_clicks_count');

        if ($product->user && $product->user->phone) {
            $text = urlencode('سلام عليكم ، شاهدت لك اعلان متجر اركان الأسرة (' . $product->title . ') وحاب اطلب من عندك');
            $url = 'https://wa.me/' . $product->user->phone . '?text=' . $text;
            return redirect()->away($url);
        }

        return redirect()->back()->with('error', 'رقم الهاتف غير متاح للتواصل.');
    }
}
