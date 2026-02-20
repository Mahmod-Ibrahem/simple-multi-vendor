<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class CategoryController extends Controller
{
    /**
     * Display all products belonging to a specific user (frontend).
     */
    public function userProducts(User $user)
    {
        $products = $user->products()
            ->where('published', true)
            ->latest()
            ->paginate(12);

        return view('frontend.user-products', compact('user', 'products'));
    }
}
