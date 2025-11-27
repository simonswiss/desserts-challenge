<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    public function store(Product $product)
    {
        $cart = Cart::getOrCreate();

        $cart->add($product);

        return back();
    }

    public function reduce(Product $product)
    {
        $cart = Cart::getOrCreate();

        $cart->reduce($product);

        return back();
    }

    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();

        return back();
    }

    public function clear()
    {
        $cart = Cart::getOrCreate();

        $cart->items()->delete();

        return back();
    }
}
