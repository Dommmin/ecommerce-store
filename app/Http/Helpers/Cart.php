<?php

namespace App\Http\Helpers;

use App\Models\CartItem;

class Cart
{
    /**
     * @return int
     */
    public static function getCartItemsCount(): int
    {
        $request =\request();
        $user = $request->user();
        if ($user) {
            return CartItem::where('user_id', $user->id)->sum('quantity');
        } else {
            $cartItems = self::getCookieCartItems();

            return array_reduce(
                $cartItems,
                fn($carry, $item) => $carry + $item['quantity']
            );
        }
    }

    /**
     * @return mixed
     */
    public static function getCartItems(): mixed
    {
        $request = \request();
        $user = $request->user();
        if ($user) {
            return CartItem::where('user_id', $user->id)->get()->map(
                fn($item) => ['product_option_id' => $item->product_option_id, 'quantity' => $item->quantity]
            );
        } else {
            return self::getCookieCartItems();
        }
    }

    /**
     * @return mixed
     */
    public static function getCookieCartItems(): mixed
    {
        $request = \request();

        return json_decode($request->cookie('cart_items', '[]'), true);
    }

    /**
     * @param $cartItems
     * @return int
     */
    public static function getCountFromItems($cartItems): int
    {
        return array_reduce(
            $cartItems, fn($carry, $item) => $carry + $item['quantity'],
            0
        );
    }

    /**
     * @return void
     */
    public static function moveCartItemsIntoDb(): void
    {
        $request = \request();
        $cartItems = self::getCookieCartItems();

        $dbCartItems = CartItem::where(['user_id' => $request->user()->id])->get()->keyBy('product_option_id');
        $newCartItems = [];
        foreach ($cartItems as $cartItem) {
            if (isset($dbCartItems[$cartItem['product_option_id']])) {
                continue;
            }
            $newCartItems[] = [
                'user_id' => $request->user()->id,
                'product_option_id' => $cartItem['product_option_id'],
                'quantity' => $cartItem['quantity'],
            ];
        }

        if (!empty($newCartItems)) {
            CartItem::insert($newCartItems);
        }
    }
}
