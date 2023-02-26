<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

class ProductController extends Controller
{
    /**
     * @param $url
     * @return Response|ResponseFactory
     */
    public function show($url)
    {
        $product = Product::query()
            ->join('product_variants', 'product_variants.product_id', '=', 'products.id')
            ->where('url', '=', $url)
            ->select('*', 'product_variants.id as variant_id')
            ->first()
            ->toArray();

        $variants  = ProductVariant::where('product_id', $product['product_id'])->get();
        $options = ProductOption::where('product_variant_id', $product['variant_id'])->get()->toArray();
        $product['options'] = $options;

        return Inertia('Product/Show', compact('product', 'variants'));
    }

    /**
     * @param ProductVariant $variant
     * @return RedirectResponse
     */
    public function addFavorite(ProductVariant $variant)
    {
        $favorite = new Favorite();
        $favorite->user_id = Auth::id();
        $favorite->product_variant_id = $variant->id;
        $favorite->save();

        return redirect()->route('index');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function removeFavorite(Request $request)
    {
        $favorite = Favorite::where('user_id', Auth::id())
            ->where('product_variant_id', $request['variant'])
            ->first();

        $favorite->delete();

        return redirect()->route('index');
    }

    /**
     * @return Response
     */
    public function showMyFavorites()
    {
        $favorites = Favorite::where('user_id', Auth::id())->pluck('product_id')->toArray();
        $favoriteProducts = Product::whereIn('id', $favorites)->get();

        return Inertia::render('Profile/MyFavorites', compact('favoriteProducts'));
    }
}
