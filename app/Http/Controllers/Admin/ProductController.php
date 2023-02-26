<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response|ResponseFactory
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage') ?: 5;

        $products = Product::query()
            ->when($request->input('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->when($request->has('column'), function ($query) use ($request) {
//                if ($request->input('column') === 'brand') {
//                    $query->join('brands', 'products.brand_id', '=', 'brands.id')->orderBy('brands.name', $request->input('direction'));
//                } elseif ($request->input('column') === 'category') {
//                    $query
//                        ->join('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
//                        ->join('categories', 'categories.id', '=', 'subcategories.category_id')
//                        ->orderBy('categories.name', $request->input('direction')
//                    );
//                } else {
                $query->orderBy($request->input('column'), $request->input('direction'));
//                }
            })
            ->paginate($perPage)
            ->withQueryString()
            ->through( fn ($product) => [
                'id' => $product->id,
                'name' => $product->name,
                'category' => Category::find(1)->pluck('name')->first(), // TODO
                'brand' => $product->brand->name,
                'is_public' => $product->is_public ? 'YES' : 'NO',
                'description' => $product->description,
                'created_at' => $product->created_at->toDate()->format('d-m-Y'),
                'user' => $product->user ? $product->user->name : 'system',
            ]);

        $filters = $request->only(['search', 'perPage', 'column', 'direction']);

        return inertia('Admin/Product/Index', compact( 'products', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response|ResponseFactory
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::get(['id', 'name']);

        return inertia('Admin/Product/Create', compact('brands', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ProductStoreRequest $request)
    {
        Product::create($request->validated());

        return redirect()->route('admin.product.index');
    }

    /**
     * @param Product $product
     * @return Response|ResponseFactory
     */
    public function show(Product $product)
    {
        $productId = $product->id;
        $variants = ProductVariant::where('product_id', $productId)->get();

        return inertia('Admin/Product/Show', compact( 'variants', 'productId'));
    }
}
