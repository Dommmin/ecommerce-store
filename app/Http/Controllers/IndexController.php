<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->when($request->input('color'), function ($query, $search) {
                $colors = explode(',', $search);
                $query->whereIn('color', $colors);
            })
            ->with('variants.solds')
            ->with('variants.favorites')
            ->where('is_public', true)
            ->paginate(10)
            ->through(function ($product) {
                $variants =
                    $product->variants
                        ->map(function ($result) {
                            $sumPcs = $result->solds->sum('pcs');

                            $result = $result->toArray();
                            $result['favorites'] = (bool)Arr::get($result, 'favorites');
                            $result['solds'] = $sumPcs;
                            collect($result);

                            return $result;
                        })->sortByDesc(function ($item) {
                            return $item['solds'];
                        });

                $variant = Arr::first($variants);

                return [
                    'id' => $product->id,
                    'variant_id' => Arr::get($variant, 'id'),
                    'name' => $product->name,
                    'price' => Arr::get($variant, 'price'),
                    'color' => Arr::get($variant, 'color'),
                    'url' => Arr::get($variant, 'url'),
                    'image' => Arr::get($variant, 'image'),
                    'description' => $product->description,
                    'created_at' => $product->created_at->diffForHumans(),
                    'sold' => Arr::get($variant, 'solds'),
                    'favorite' => Arr::get($variant, 'favorites'),
                ];
            })
            ->sortByDesc(function ($item) {
                return $item['sold'];
            });

        $filters = $request->only(['color']);

        return inertia('Index', compact('products', 'filters'));
    }

}
