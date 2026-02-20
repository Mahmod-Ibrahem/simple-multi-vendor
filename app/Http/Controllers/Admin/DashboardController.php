<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard with statistics.
     * مدير النظام: global stats across all products.
     * عميل: stats scoped to own products only.
     */
    public function index()
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole('مدير النظام') || $user->id === 1;

        $productQuery = Product::query();

        if (!$isAdmin) {
            $productQuery->where('user_id', $user->id);
        }

        $stats = [
            'products_count' => (clone $productQuery)->count(),
            'published_count' => (clone $productQuery)->where('published', true)->count(),
            'total_visits' => (clone $productQuery)->sum('visits_count'),
            'total_whatsapp_clicks' => (clone $productQuery)->sum('whatsapp_clicks_count'),
        ];

        // Admin-only global stats
        if ($isAdmin) {
            $stats['categories_count'] = Category::count();
            $stats['users_count'] = User::count();
        }

        $latestProducts = (clone $productQuery)->with('category')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'latestProducts', 'isAdmin'));
    }
}
