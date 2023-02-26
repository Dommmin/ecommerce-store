<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Str;

class ProductVariantObserver
{
    /**
     * Handle the post "saving" event.
     *
     * @param ProductVariant $variant
     * @return void
     */
    public function saving(ProductVariant $variant): void
    {
        $product = Product::find($variant->product_id)->first();
        $variant->url = Str::slug(Str::slug($product->name . '-' . $variant->color));
    }

    /**
     * Handle the ProductVariant "created" event.
     */
    public function created(ProductVariant $productVariant): void
    {
        //
    }

    /**
     * Handle the ProductVariant "updated" event.
     */
    public function updated(ProductVariant $productVariant): void
    {
        //
    }

    /**
     * Handle the ProductVariant "deleted" event.
     */
    public function deleted(ProductVariant $productVariant): void
    {
        //
    }

    /**
     * Handle the ProductVariant "restored" event.
     */
    public function restored(ProductVariant $productVariant): void
    {
        //
    }

    /**
     * Handle the ProductVariant "force deleted" event.
     */
    public function forceDeleted(ProductVariant $productVariant): void
    {
        //
    }
}
