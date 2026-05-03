<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BarcodeScanStockService
{
    /**
     * Build ordered unique strings to try (raw scan, URL path segments, /category/x, query params, etc.).
     *
     * @return list<string>
     */
    public static function collectScanCandidates(string $raw): array
    {
        $raw = trim($raw);
        $seen = [];
        $ordered = [];

        $add = function (string $s) use (&$seen, &$ordered): void {
            $s = trim($s);
            if ($s === '') {
                return;
            }
            $key = strtolower($s);
            if (isset($seen[$key])) {
                return;
            }
            $seen[$key] = true;
            $ordered[] = $s;
        };

        $add($raw);

        if (preg_match('~/category/([^/?#]+)~i', $raw, $m)) {
            $add(rawurldecode($m[1]));
        }

        if (preg_match('~/p/([^/?#]+)~i', $raw, $m)) {
            $add(rawurldecode($m[1]));
        }

        if (str_contains($raw, '://') || str_starts_with($raw, '//')) {
            $parsed = parse_url(str_starts_with($raw, '//') ? 'https:' . $raw : $raw);
            $path = isset($parsed['path']) ? trim((string) $parsed['path'], '/') : '';
            if ($path !== '') {
                $segments = array_values(array_filter(explode('/', $path), fn ($x) => $x !== ''));
                foreach ($segments as $seg) {
                    $add(rawurldecode($seg));
                }
            }
            if (! empty($parsed['query'])) {
                parse_str((string) $parsed['query'], $q);
                foreach (['code', 'slug', 'sku', 'id'] as $k) {
                    if (! empty($q[$k])) {
                        $add((string) $q[$k]);
                    }
                }
            }
        }

        if (str_contains($raw, '/') && ! str_contains($raw, '://')) {
            $add(rawurldecode(basename(rtrim($raw, '/'))));
        }

        return $ordered;
    }

    public static function findBundleByScanCode(string $raw): ?Category
    {
        return self::findBundleAmongCandidates(self::collectScanCandidates($raw));
    }

    /**
     * First matching barcode_qr category by slug, sku, or numeric id.
     */
    public static function findBundleAmongCandidates(array $candidates): ?Category
    {
        foreach ($candidates as $code) {
            $code = trim((string) $code);
            if ($code === '') {
                continue;
            }

            $bySlugOrSku = Category::query()
                ->where('type', PaidOrderInventory::BARCODE_CATEGORY_TYPE)
                ->where(function ($q) use ($code) {
                    $q->whereRaw('LOWER(slug) = LOWER(?)', [$code])
                        ->orWhere(function ($q2) use ($code) {
                            $q2->whereNotNull('sku')
                                ->where('sku', '!=', '')
                                ->whereRaw('LOWER(sku) = LOWER(?)', [$code]);
                        });
                })
                ->first();

            if ($bySlugOrSku) {
                return $bySlugOrSku;
            }

            if (ctype_digit($code)) {
                $byId = Category::query()
                    ->where('type', PaidOrderInventory::BARCODE_CATEGORY_TYPE)
                    ->where('id', (int) $code)
                    ->first();
                if ($byId) {
                    return $byId;
                }
            }
        }

        return null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, Product>
     */
    public static function findLinkedProducts(string $canonicalSlug)
    {
        $canonicalSlug = trim((string) $canonicalSlug);
        if ($canonicalSlug === '') {
            return Product::query()->whereRaw('1 = 0')->get();
        }

        return Product::query()
            ->whereNotNull('barcode_code')
            ->where('barcode_code', '!=', '')
            ->whereRaw('LOWER(barcode_code) = LOWER(?)', [$canonicalSlug])
            ->get();
    }

    /**
     * Products linked to any candidate slug/code (deduped by id).
     */
    public static function findLinkedProductsAmongCandidates(array $candidates): Collection
    {
        $byId = [];
        $list = collect();
        foreach ($candidates as $c) {
            foreach (self::findLinkedProducts((string) $c) as $p) {
                if (! isset($byId[$p->id])) {
                    $byId[$p->id] = true;
                    $list->push($p);
                }
            }
        }

        return $list;
    }

    /**
     * Maximum units sellable in one scan (same rules as {@see applyScanDeduction}).
     * Null means no numeric stock caps (unlimited).
     */
    public static function maxSellableQty(?Category $bundle, Collection $products): ?int
    {
        $mins = [];
        if ($bundle && ($bundle->manage_stock ?? false) && $bundle->stock !== null) {
            $mins[] = (int) $bundle->stock;
        }
        foreach ($products as $p) {
            if ($p->stock !== null && is_numeric($p->stock)) {
                $mins[] = (int) $p->stock;
            }
        }

        if ($mins === []) {
            return null;
        }

        return min($mins);
    }

    /**
     * Resolve scan for POS display (no stock change).
     *
     * @return array{code: string, name: string, price: float, image_url: ?string, has_label: bool, label_stock: mixed, manage_label_stock: bool, max_sellable_qty: int|null}|null
     */
    public static function lookupDisplay(string $raw): ?array
    {
        $candidates = self::collectScanCandidates($raw);
        $bundle = self::findBundleAmongCandidates($candidates);
        $canonical = $bundle?->slug ?? ($candidates[0] ?? null);
        if ($canonical === null || trim((string) $canonical) === '') {
            $canonical = trim($raw);
        }
        $products = self::findLinkedProductsAmongCandidates($candidates);

        if (! $bundle && $products->isEmpty()) {
            return null;
        }

        $name = (string) ($bundle?->name ?? $products->first()?->name ?? 'Item');

        $price = 0.0;
        if ($bundle && $bundle->price !== null && (float) $bundle->price > 0) {
            $price = (float) $bundle->price;
        } elseif ($products->isNotEmpty()) {
            $p = $products->first();
            $p->loadMissing('activeSale');
            $price = (float) ($p->final_price ?? $p->price ?? 0);
        }

        $imageUrl = $bundle?->image_url ?? ($products->isNotEmpty() ? $products->first()->image_url : null);
        $maxSellable = self::maxSellableQty($bundle, $products);

        return [
            'code' => (string) ($bundle?->slug ?? $canonical),
            'name' => $name,
            'price' => round($price, 2),
            'image_url' => $imageUrl ? (string) $imageUrl : null,
            'has_label' => (bool) $bundle,
            'label_stock' => $bundle?->stock,
            'manage_label_stock' => (bool) ($bundle?->manage_stock ?? false),
            'max_sellable_qty' => $maxSellable,
        ];
    }

    /**
     * POS-style scan: reduce label bundle stock (if tracked) and all linked product stocks.
     *
     * @return array{slug: string, qty: int, label: ?array, products: array<int, array<string, mixed>>}
     */
    public static function applyScanDeduction(string $rawCode, int $qty): array
    {
        $qty = max(1, min(9999, $qty));
        $trimmed = trim($rawCode);
        if ($trimmed === '') {
            throw ValidationException::withMessages([
                'code' => ['Scan or enter a code.'],
            ]);
        }

        $candidates = self::collectScanCandidates($rawCode);
        $bundle = self::findBundleAmongCandidates($candidates);
        $canonical = $bundle?->slug ?? ($candidates[0] ?? $trimmed);
        $products = self::findLinkedProductsAmongCandidates($candidates);

        if (! $bundle && $products->isEmpty()) {
            throw ValidationException::withMessages([
                'code' => ['No Barcode & QR label or linked product matches this code. Use the label slug, store URL from the QR (/category/…), or a product barcode code.'],
            ]);
        }

        if ($bundle && ($bundle->manage_stock ?? false) && $bundle->stock !== null) {
            if ((int) $bundle->stock < $qty) {
                throw ValidationException::withMessages([
                    'code' => ['Not enough stock on this label.'],
                ]);
            }
        }

        foreach ($products as $p) {
            if ($p->stock !== null && is_numeric($p->stock) && (int) $p->stock < $qty) {
                throw ValidationException::withMessages([
                    'code' => ['Not enough stock for product: ' . $p->name],
                ]);
            }
        }

        DB::transaction(function () use ($bundle, $products, $qty) {
            if ($bundle && ($bundle->manage_stock ?? false) && $bundle->stock !== null) {
                $bundle->refresh();
                $bundle->update([
                    'stock' => max(0, (int) $bundle->stock - $qty),
                ]);
            }

            foreach ($products as $p) {
                if ($p->stock !== null && is_numeric($p->stock)) {
                    $p->refresh();
                    $p->update([
                        'stock' => max(0, (int) $p->stock - $qty),
                    ]);
                }
            }
        });

        $freshBundle = $bundle?->fresh();
        $slugOut = (string) ($freshBundle?->slug ?? $canonical);

        $freshProducts = self::findLinkedProductsAmongCandidates(
            array_values(array_unique(array_merge([$slugOut], $candidates)))
        );

        return [
            'slug' => $slugOut,
            'qty' => $qty,
            'label' => $freshBundle ? [
                'id' => $freshBundle->id,
                'name' => $freshBundle->name,
                'slug' => $freshBundle->slug,
                'manage_stock' => (bool) ($freshBundle->manage_stock ?? false),
                'stock' => $freshBundle->stock,
            ] : null,
            'products' => $freshProducts->map(fn (Product $p) => [
                'id' => $p->id,
                'name' => $p->name,
                'stock' => $p->stock,
            ])->values()->all(),
        ];
    }
}
