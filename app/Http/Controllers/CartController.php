<?php

namespace App\Http\Controllers;

use App\Product;
// use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Product $product)
    {
        // dd($product);

        // add the pruduct to cart

        \Cart::session(auth() -> id())->add(array(
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 4,
            'attributes' => array(),
            'associateModel' => $product
        ));

        return redirect()->route('cart.index');

    }

    public function index()
    {
        # code...
        $cartItems = \Cart::session(auth()->id())->getContent();
        return view('cart.index', compact('cartItems'));
    }

    public function destroy($itemId)
    {
         $cartItems = \Cart::session(auth()->id())->remove($itemId);
         return back();
    }

    public function update($rowId)
    {
        $cartItems = \Cart::session(auth()->id())->update($rowId, [
            'quantity' => array(
                'relative' => false,
                'value' => request('quantity')
            )
        ]);
        return back();
   }
}
