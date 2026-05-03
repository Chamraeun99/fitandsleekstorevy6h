<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Support\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryAdminController extends Controller
{
    private function mapCategory(Category $c): array
    {
        return [
            'id'               => $c->id,
            'name'             => $c->name,
            'slug'             => $c->slug,
            'type'             => $c->type,
            'sort_order'       => (int)($c->sort_order ?? 0),
            'is_active'        => (bool)$c->is_active,
            'image_url'        => $c->image_url ?: Media::url($c->image_path),
            'image_path'       => $c->image_path,
            'description'      => $c->description,
            'details'          => $c->details,
            'price'            => $c->price,
            'compare_at_price' => $c->compare_at_price,
            'label_color'      => $c->label_color,
            'gallery'          => $c->gallery,
            'sku'              => $c->sku,
            'cost'             => $c->cost,
            'unit'                     => $c->unit,
            'brand_id'                 => $c->brand_id,
            'category_id'              => $c->label_category_id,
            'manage_stock'             => (bool)($c->manage_stock ?? false),
            'stock'                    => $c->stock,
            'min_stock'                => $c->min_stock,
            'has_variation'            => (bool)($c->has_variation ?? false),
            'variation_product_type'   => $c->variation_product_type,
            'variation_colors'         => $c->variation_colors,
            'variation_sizes'          => $c->variation_sizes ?? [],
        ];
    }

    public function index()
    {
        $items = Category::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->map(fn($c) => $this->mapCategory($c));

        return response()->json(['data' => $items]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => ['required','string','max:255'],
            'slug'             => ['nullable','string','max:255','unique:categories,slug'],
            'type'             => ['nullable','string','max:50'],
            'sort_order'       => ['nullable','integer','min:0'],
            'is_active'        => ['nullable','boolean'],
            'image'            => ['nullable','image','mimes:jpg,jpeg,png,webp,svg','max:5120'],
            'description'      => ['nullable','string'],
            'details'          => ['nullable','string'],
            'price'            => ['nullable','numeric','min:0'],
            'compare_at_price' => ['nullable','numeric','min:0'],
            'label_color'      => ['nullable','string','max:30'],
            'image_url'        => ['nullable','string'],
            'gallery'          => ['nullable','string'],
            'sku'              => ['nullable','string','max:100'],
            'cost'             => ['nullable','numeric','min:0'],
            'unit'             => ['nullable','string','max:50'],
            'brand_id'                 => ['nullable','integer','exists:brands,id'],
            'category_id'              => ['nullable','integer','exists:categories,id'],
            'manage_stock'             => ['nullable','boolean'],
            'stock'                    => ['nullable','integer','min:0'],
            'min_stock'                => ['nullable','integer','min:0'],
            'has_variation'            => ['nullable','boolean'],
            'variation_product_type' => ['nullable','string','max:50'],
            'variation_colors'       => ['nullable','string'],
            'variation_sizes'        => ['nullable','array'],
            'variation_sizes.*'      => ['string','max:50'],
        ]);

        $slug = $validated['slug'] ?? Str::slug($validated['name']);
        $base = $slug; $i = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
        }

        $c = Category::create([
            'name'             => $validated['name'],
            'slug'             => $slug,
            'type'             => $validated['type'] ?? null,
            'sort_order'       => $validated['sort_order'] ?? 0,
            'is_active'        => $validated['is_active'] ?? true,
            'image_path'       => $path,
            'description'      => $validated['description'] ?? null,
            'details'          => $validated['details'] ?? null,
            'price'            => $validated['price'] ?? null,
            'compare_at_price' => $validated['compare_at_price'] ?? null,
            'label_color'      => $validated['label_color'] ?? null,
            'image_url'        => $validated['image_url'] ?? null,
            'gallery'          => $validated['gallery'] ?? null,
            'sku'              => $validated['sku'] ?? null,
            'cost'             => $validated['cost'] ?? null,
            'unit'             => $validated['unit'] ?? null,
            'brand_id'                 => $validated['brand_id'] ?? null,
            'label_category_id'        => $validated['category_id'] ?? null,
            'manage_stock'             => (bool)($validated['manage_stock'] ?? false),
            'stock'                    => $validated['stock'] ?? null,
            'min_stock'                => $validated['min_stock'] ?? null,
            'has_variation'            => (bool)($validated['has_variation'] ?? false),
            'variation_product_type'   => $validated['variation_product_type'] ?? null,
            'variation_colors'         => $validated['variation_colors'] ?? null,
            'variation_sizes'        => $validated['variation_sizes'] ?? null,
        ]);

        return response()->json(['data' => $this->mapCategory($c)], 201);
    }

    public function show(Category $category)
    {
        return response()->json(['data' => $this->mapCategory($category)]);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'             => ['required','string','max:255'],
            'slug'             => ['nullable','string','max:255','unique:categories,slug,' . $category->id],
            'type'             => ['nullable','string','max:50'],
            'sort_order'       => ['nullable','integer','min:0'],
            'is_active'        => ['nullable','boolean'],
            'image'            => ['nullable','image','mimes:jpg,jpeg,png,webp,svg','max:5120'],
            'description'      => ['nullable','string'],
            'details'          => ['nullable','string'],
            'price'            => ['nullable','numeric','min:0'],
            'compare_at_price' => ['nullable','numeric','min:0'],
            'label_color'      => ['nullable','string','max:30'],
            'image_url'        => ['nullable','string'],
            'gallery'          => ['nullable','string'],
            'sku'              => ['nullable','string','max:100'],
            'cost'             => ['nullable','numeric','min:0'],
            'unit'             => ['nullable','string','max:50'],
            'brand_id'                 => ['nullable','integer','exists:brands,id'],
            'category_id'              => ['nullable','integer','exists:categories,id'],
            'manage_stock'             => ['nullable','boolean'],
            'stock'                    => ['nullable','integer','min:0'],
            'min_stock'                => ['nullable','integer','min:0'],
            'has_variation'            => ['nullable','boolean'],
            'variation_product_type' => ['nullable','string','max:50'],
            'variation_colors'       => ['nullable','string'],
            'variation_sizes'        => ['nullable','array'],
            'variation_sizes.*'      => ['string','max:50'],
        ]);

        $slug = $validated['slug'] ?? Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            if ($category->image_path) Storage::disk('public')->delete($category->image_path);
            $category->image_path = $request->file('image')->store('categories', 'public');
        }

        $category->fill([
            'name'             => $validated['name'],
            'slug'             => $slug,
            'type'             => $validated['type'] ?? $category->type,
            'sort_order'       => $validated['sort_order'] ?? ($category->sort_order ?? 0),
            'is_active'        => $validated['is_active'] ?? $category->is_active,
            'description'      => array_key_exists('description', $validated) ? $validated['description'] : $category->description,
            'details'          => array_key_exists('details', $validated) ? $validated['details'] : $category->details,
            'price'            => array_key_exists('price', $validated) ? $validated['price'] : $category->price,
            'compare_at_price' => array_key_exists('compare_at_price', $validated) ? $validated['compare_at_price'] : $category->compare_at_price,
            'label_color'      => array_key_exists('label_color', $validated) ? $validated['label_color'] : $category->label_color,
            'image_url'        => array_key_exists('image_url', $validated) ? $validated['image_url'] : $category->image_url,
            'gallery'          => array_key_exists('gallery', $validated) ? $validated['gallery'] : $category->gallery,
            'sku'              => array_key_exists('sku', $validated) ? $validated['sku'] : $category->sku,
            'cost'             => array_key_exists('cost', $validated) ? $validated['cost'] : $category->cost,
            'unit'             => array_key_exists('unit', $validated) ? $validated['unit'] : $category->unit,
            'brand_id'                 => array_key_exists('brand_id', $validated) ? $validated['brand_id'] : $category->brand_id,
            'label_category_id'        => array_key_exists('category_id', $validated) ? $validated['category_id'] : $category->label_category_id,
            'manage_stock'             => array_key_exists('manage_stock', $validated) ? (bool)$validated['manage_stock'] : $category->manage_stock,
            'stock'                    => array_key_exists('stock', $validated) ? $validated['stock'] : $category->stock,
            'min_stock'                => array_key_exists('min_stock', $validated) ? $validated['min_stock'] : $category->min_stock,
            'has_variation'            => array_key_exists('has_variation', $validated) ? (bool)$validated['has_variation'] : $category->has_variation,
            'variation_product_type' => array_key_exists('variation_product_type', $validated) ? $validated['variation_product_type'] : $category->variation_product_type,
            'variation_colors'         => array_key_exists('variation_colors', $validated) ? $validated['variation_colors'] : $category->variation_colors,
            'variation_sizes'        => array_key_exists('variation_sizes', $validated) ? $validated['variation_sizes'] : $category->variation_sizes,
        ]);
        $category->save();

        return response()->json(['data' => $this->mapCategory($category)]);
    }

    public function destroy(Category $category)
    {
        if ($category->image_path) Storage::disk('public')->delete($category->image_path);
        $category->delete();
        return response()->json(['ok' => true]);
    }
}
