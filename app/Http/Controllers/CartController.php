<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Varient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $session_id = $request->session()->getId();

        if (Auth::check()) {
            $userId = $request->user()->id;
            
            $cart = Cart::where('user_id', $userId)->firstOrCreate();

            $cartItems = $cart->cartProducts->map(function ($cartProduct) {
                return [
                    'id' => $cartProduct->id,
                    'name' => $cartProduct->product->name,
                    'image' => $cartProduct->product->image,
                    'quantity' => $cartProduct->quantity,
                    'price' => $cartProduct->price,
                ];
            });

        } else {

            $cart = Cart::where('session_id', $session_id)->firstOrCreate();
            $cartItems = $cart->cartProducts->map(function ($cartProduct) {
                return [
                    'id' => $cartProduct->id,
                    'name' => $cartProduct->product->name,
                    'image' => $cartProduct->product->image,
                    'quantity' => $cartProduct->quantity,
                    'price' => $cartProduct->price,
                ];
            });

        }

        return Inertia::render('Cart', ['cartItems' => $cartItems]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $session_id = $request->session()->getId();
        $productId = $request->input('id');
        $product = Varient::findOrFail($productId);
        $quantity = $request->input('quantity');

        if (Auth::check()) {

            $userId = $request->user()->id;

            $userCart = Cart::where('user_id', $userId)->firstOrCreate(['user_id' => $userId]);

            CartProduct::create([
                'cart_id' => $userCart->id,
                'product_id' => $product->id,
                "quantity" => $quantity,
                "price" => $product->price * $quantity,
            ]);
        } else {

            $userCart = Cart::where('session_id', $session_id)->firstOrCreate(['session_id' => $session_id]);

            CartProduct::create([
                'cart_id' => $userCart->id,
                'product_id' => $product->id,
                "quantity" => $quantity,
                "price" => $product->price,
            ]);

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        $id = $request->input('id');
        $operator = $request->input('operator');
        $cartProduct = CartProduct::findOrFail($id);

        switch ($operator) {
            case "add":
                $cartProduct->quantity++;
                break;
            case "minus":
                $cartProduct->quantity--;
                break;
        }

        $cartProduct->save();

        return redirect()->route('cart.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,Cart $cart)
    {
        $id = $request->input('id');
        CartProduct::findOrFail($id)->delete();

        return redirect()->route('cart.index');
    }
}
