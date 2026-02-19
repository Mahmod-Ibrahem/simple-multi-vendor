<?php

namespace App\Models;

use App\Traits\HasModelHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory, HasModelHelpers;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
    ];

    /**
     * Get all letters for this category.
     *
     * @return HasMany
     */
    public function letters(): HasMany
    {
        return $this->hasMany(Letter::class);
    }

    /**
     * Define default relations to eager load.
     *
     * @return array
     */
    public function defaultRelations(): array
    {
        return [];
    }
}
