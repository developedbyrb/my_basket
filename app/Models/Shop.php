<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shop extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'image', 'created_by'];

    public function skus(): BelongsToMany
    {
        return $this->belongsToMany(Sku::class, 'shop_products');
    }

    /**
     * Get the comments for the blog post.
     */
    public function address(): HasMany
    {
        return $this->hasMany(ShopAddress::class);
    }

    /**
     * Get the comments for the blog post.
     */
    public function product(): HasMany
    {
        return $this->hasMany(ShopProduct::class);
    }
}
