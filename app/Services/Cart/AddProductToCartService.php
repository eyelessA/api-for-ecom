<?php

namespace App\Services\Cart;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddProductToCartService
{
    public function addProductToCart(array $data): void
    {
        Auth::setUser(User::query()->first());
        $cart = Cart::query()->where('user_id', '=', Auth::user()->id)->first();

        if ($cart === null) {
            $cart = Cart::query()->create([
                'user_id' => Auth::user()->id,
            ]);
        }

        try {
            DB::beginTransaction();
            $product = Product::query()->where('id', '=', $data['product_id'])->first();
            if ($product->quantity > 0) {
                $product->quantity -= $data['quantity'];
                $product->save();

                $cartProduct = CartProduct::query()
                    ->where('cart_id', '=', $cart->id)
                    ->where('product_id', '=', $data['product_id'])
                    ->first();

                if ($cartProduct !== null) {
                    $cartProduct->quantity += $data['quantity'];
                    $cartProduct->save();
                } else {
                    CartProduct::query()->create([
                        'cart_id' => $cart->id,
                        'product_id' => $data['product_id'],
                        'quantity' => $data['quantity'],
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            logger()->error($exception->getMessage());
        }
    }
}
