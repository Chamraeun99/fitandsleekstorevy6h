<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'type',
        'image_path',
        'sort_order',
        'is_active',
        'description',
        'details',
        'price',
        'compare_at_price',
        'label_color',
        'image_url',
        'gallery',
        'sku',
        'cost',
        'unit',
        'brand_id',
        'label_category_id',
        'manage_stock',
        'stock',
        'min_stock',
        'has_variation',
        'variation_product_type',
        'variation_colors',
        'variation_sizes',
    ];

    protected $casts = [
        'is_active'        => 'boolean',
        'sort_order'       => 'integer',
        'price'            => 'float',
        'compare_at_price' => 'float',
        'cost'             => 'float',
        'manage_stock'     => 'boolean',
        'has_variation'    => 'boolean',
        'stock'            => 'integer',
        'min_stock'        => 'integer',
        'variation_sizes'  => 'array',
    ];

    // Relationships
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
