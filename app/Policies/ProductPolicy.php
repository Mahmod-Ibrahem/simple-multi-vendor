<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Super admin bypasses all checks.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('مدير النظام') || $user->id === 1) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     * عميل: allowed — but the controller scopes to own products.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('products.view-any');
    }

    /**
     * Determine whether the user can view the model.
     * Public visitors may view published products.
     * عميل: can only view their own products in dashboard.
     */
    public function view(?User $user, Product $product): bool
    {
        // Public can view published products
        if ($product->published) {
            return true;
        }

        // Authenticated owner can view their own unpublished products
        return $user && $user->id === $product->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('products.create');
    }

    /**
     * Determine whether the user can update the model.
     * عميل: only own products.
     */
    public function update(User $user, Product $product): bool
    {
        return $user->id === $product->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     * عميل: only own products.
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->id === $product->user_id;
    }
}
