<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // ------------------------------
    // Store
    // ------------------------------
    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $cart = Cart::getOrNew();

        $cart->add($product);

        return back();
    }

    // ------------------------------
    // Reduce
    // ------------------------------
    public function reduce(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $cart = Cart::getOrNew();

        $cart->reduce($product);

        return back();
    }

    // ------------------------------
    // Destroy
    // ------------------------------
    public function destroy(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $cart = Cart::getOrNew();

        $cart->remove($product);

        return back();
    }

    // ------------------------------
    // Clear
    // ------------------------------
    public function clear()
    {
        $cart = Cart::getOrNew();

        $cart->items()->delete();

        return back();
    }
}
