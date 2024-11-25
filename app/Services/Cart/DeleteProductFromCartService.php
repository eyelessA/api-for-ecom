<?php

namespace App\Services\Cart;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DeleteProductFromCartService
{
    public function deleteProductFromCart(array $data): void
    {
        Auth::setUser(User::query()->first());
        $cart = Cart::query()->where('user_id', '=', Auth::user()->id)->first();
        $cartProduct = CartProduct::query()->where('cart_id', '=', $cart->id)->first();

        if ($cart !== null && $cartProduct->quantity === 1) {
            CartProduct::query()
                ->where('cart_id', '=', $cart->id)
                ->where('product_id', '=', $data['product_id'])
                ->delete();
        } elseif ($cart !== null && $cartProduct->quantity > 1) {
            $cartProduct = CartProduct::query()
                ->where('cart_id', '=', $cart->id)
                ->where('product_id', '=', $data['product_id'])
                ->first();

            $cartProduct->quantity -= $data['quantity'];
            $cartProduct->save();

            if ($cartProduct->quantity < 1) {
                $cartProduct->delete();
            }
        }
    }
}
