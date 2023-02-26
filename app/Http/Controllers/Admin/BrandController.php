<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandStoreRequest;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response|ResponseFactory
     */
    public function index(Request $request)
    {
        $brands = Brand::query()
            ->when($request->input('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(5)
            ->withQueryString()
            ->through(fn($brand) => [
                'id' => $brand->id,
                'name' => $brand->name,
                'created_at' => $brand->created_at->toDate()->format('d-m-Y'),
//                'user' => $brand->user ? $brand->user->name : 'system',
            ]);

        $filters = $request->only(['search']);

        return inertia('Admin/Brand/Index', compact( 'brands', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response|ResponseFactory
     */
    public function create()
    {
        return inertia('Admin/Brand/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BrandStoreRequest $request
     * @return RedirectResponse
     */
    public function store(BrandStoreRequest $request)
    {
        Brand::create($request->validated());

        return redirect()->route('admin.brand.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Brand $brand
     * @return RedirectResponse
     */
    public function destroy(Brand $brand)
    {
        $brand->products()->delete();
        $brand->delete();

        return redirect()->route('admin.brand.index');
    }
}
