<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Cart;
use App\Models\CartItem;
use App\Models\ProductOption;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Inertia\Response;
use Inertia\ResponseFactory;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response|ResponseFactory
     */
    public function index()
    {
        $cartItems = Cart::getCartItems();

        $ids = Arr::pluck($cartItems, 'product_option_id');
        $products = ProductOption::whereIn('id', $ids)->with('variant.product')->get()->map(function ($option) {
            $variant = $option->variant;
            $product = $option->variant->product;

            return collect([
                'product_id' => $product->id,
                'product_variant_id' => $variant->id,
                'product_option_id'  => $option->id,
                'price' => $option->price ?: $variant->price,
                'url' => $variant->url,
                'name' => $product->name,
                'color' => $variant->color,
                'size' => $option->size,
                'in_stock' => $option->in_stock,
                'image' => $variant->image,
            ]);
        });

        $cartItems = Arr::keyBy($cartItems, 'product_option_id');
        $total = 0;

        foreach ($products as $product) {
            $product['quantity'] = $cartItems[$product['product_option_id']]['quantity'];
            $total += $product['price'] * $cartItems[$product['product_option_id']]['quantity'];
        }

        $cartItems = $cartItems ?: null;

        return inertia('Cart/Index', compact('cartItems', 'products', 'total'));
    }

    /**
     * @param Request $request
     * @param ProductOption $option
     * @return RedirectResponse
     */
    public function add(Request $request, ProductOption $option)
    {
        $variant = ProductVariant::where('id', $option->product_variant_id)->first();

        $quantity = $request->post('quantity', 1);
        $user     = $request->user();

        if ($user) {
            $cartItem = CartItem::where(['user_id' => $user->id, 'product_option_id' => $option->id])->first();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->update();
            } else {
                $data = [
                    'user_id' => $request->user()->id,
                    'product_option_id' => $option->id,
                    'quantity' => $quantity,
                ];
                CartItem::create($data);
            }
        } else {
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
            $productFound = false;
            foreach ($cartItems as $item) {
                if ($item['product_option_id'] === $option->id) {
                    $item['quantity'] += $quantity;
                    $productFound = true;
                    break;
                }
            }
            if (!$productFound) {
                $cartItems[] = [
                    'user_id' => null,
                    'product_option_id' => $option->id,
                    'quantity' => $quantity,
                    'price' => $option->price
                ];
            }
            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);
        }


        return redirect()->route('product.show', $variant->url);
    }

    /**
     * Display a listing of the resource.
     *
     * @return RedirectResponse
     */
    public function remove(Request $request, ProductOption $option)
    {
        $user = $request->user();
        if ($user) {
            $cartItem = CartItem::query()->where(['user_id' => $user->id, 'product_option_id' => $option->id])->first();
            $cartItem?->delete();
            return redirect()->route('cart.index');
        } else {
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
            foreach ($cartItems as $i => $item) {
                if ($item['product_option_id'] === $option->id) {
                    array_splice($cartItems, $i, 1);
                    break;
                }
            }
            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);

            return redirect()->route('cart.index');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return RedirectResponse
     */
    public function updateQuantity(Request $request, ProductOption $option)
    {
        $quantity = (int)$request->post('quantity');
        $user = $request->user();
        if ($user) {
            CartItem::where(['user_id' => $request->user()->id, 'product_option_id' => $option->id])->update(['quantity' => $quantity]);
        } else {
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);

            $cartItems = Arr::map($cartItems, function ($item) use ($option, $quantity) {
                if ($item['product_option_id'] === $option->id) {
                    $item['quantity'] = $quantity;
                }

                return $item;
            });
            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);
        }

        return redirect()->route('cart.index');
    }
}
