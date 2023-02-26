<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductOptionStoreRequest;
use App\Models\ProductOption;
use Inertia\Response;
use Inertia\ResponseFactory;

class ProductOptionController extends Controller
{
    /**
     * @return Response|ResponseFactory
     */
    public function create(int $productId, int $variantId)
    {
        return inertia('Admin/Product/Variant/Option/Create', compact( 'productId', 'variantId'));
    }

    public function store(ProductOptionStoreRequest $request)
    {
        ProductOption::create($request->validated());

        return redirect()->route('admin.variant.show', [
            'product' => $request->get('product_id'),
            'variant' => $request->get('variant_id')
        ]);
    }
}
