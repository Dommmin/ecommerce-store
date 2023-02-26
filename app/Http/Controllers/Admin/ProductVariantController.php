<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductVariant;
use App\Models\VariantImages;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Inertia\Response;
use Inertia\ResponseFactory;

class ProductVariantController extends Controller
{
    /**
     * @param int $productId
     * @param ProductVariant $variant
     * @return Response|ResponseFactory
     */
    public function show(int $productId, ProductVariant $variant)
    {
        $variantId = $variant->id;
        $options = ProductOption::where('variant_id', $variantId)->get();

        return inertia('Admin/Product/Variant/Show', compact( 'options', 'productId', 'variantId'));
    }

    /**
     * @return Response|ResponseFactory
     */
    public function create(int $id)
    {
        return inertia('Admin/Product/Variant/Create', compact('id'));
    }

    public function store(Request $request)
    {
        $form = $request->get('form');

        $rules = [
            'product_id' => 'required',
            'color' => 'required',
            'price' => 'required|numeric',
            'user_id' => 'nullable',
        ];

        $validated = Validator::make($form, $rules)->validate();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = date('YmdHi') . '_' . $image->getClientOriginalName();
            $storage = $image->move(public_path('/uploads/product/' . $form['product_id'] . '/main'), $filename);
            $image_path = $storage->getFilename();
            $image_path = json_encode($image_path);
            $validated['image'] = $image_path;
        }

        $variant = ProductVariant::create($validated);
        // TODO gallery images
//        $this->processImage($request, $variant);

        return redirect()->route('admin.product.show', $form['product_id']);
    }

    /**
     * @param Request $request
     * @param Product|null $product
     * @return void
     */
    protected function processImage(Request $request, Product $product = null)
    {
        $images = [];

        if (Arr::get($request->get('form'), 'images')) {
            $images = $request->get('form')['images'];
        }

        foreach($images as $image)
        {
            $imagePath     = Arr::get($image, 'serverId');
            $productImages = $product->images()->get()->toArray();

            $imagesPaths = [];

            foreach ($productImages as $productImage) {
                $imagesPaths[] = $productImage['serverId'];
            }

            $imagesPaths = implode(', ', $imagesPaths);

            if (!str_contains($imagesPaths, $imagePath)) {
                $path = storage_path('app/public/' . $imagePath);
                if (file_exists($path)) {
                    copy($path, public_path($imagePath));
                    unlink($path);
                }
            }
        }

        $currentImages = VariantImages::where('product_id', $product->id)->pluck('serverId')->toArray();

        $uploadImages = [];

        foreach ($images as $image) {
            $uploadImages[] = $image['serverId'];
            if (!in_array($image['serverId'], $currentImages)) {
                $product->images()->create(
                    [
                        'product_id' => $product->id,
                        'originalFilename' => $image['originalFilename'],
                        'serverId' => $image['serverId'],
                        'fileExtension' => $image['fileExtension'],
                        'size' => $image['size'],
                        'created_by' => auth()->id() ?: 0,
                        'expires_at' => Carbon::now()->addDays(30),
                    ]);
            }
        }

        $toDelete = array_diff($currentImages, $uploadImages);

        foreach ($toDelete as $path) {
            VariantImages::where('serverId', $path)->first()->delete();

            if (file_exists(public_path($path))) {
                unlink(public_path($path));
            }
        }
    }
}
