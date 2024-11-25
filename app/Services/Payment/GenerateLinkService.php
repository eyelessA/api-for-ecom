<?php

namespace App\Services\Payment;

use App\Models\Cart;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GenerateLinkService
{
    public function generateLink(array $data): string
    {
        Auth::setUser(User::query()->first());
        $cart = Cart::query()->where('user_id', Auth::user()->id);
        $paymentLink = 'http://127.0.0.1:8000/api/orders/pay/';

        if ($cart->exists()) {
            $paymentMethod = PaymentMethod::query()->where('id', '=', $data['payment_method'])->first();

            if (preg_match('/^http(s)?:\/\//', $paymentLink)) {
                $paymentLink .= $paymentMethod->name;
            }

            try {
                DB::beginTransaction();

                $order = Order::query()->create([
                    'user_id' => Auth::user()->id,
                    'payment_method_id' => $data['payment_method'],
                ]);

                $cart = Cart::query()
                    ->where('user_id', '=', Auth::user()->id)
                    ->delete();

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
            }
        }
        if ($paymentLink === '') {
            return 'Пустая корзина';
        }else {
            return $paymentLink;
        }
    }
}
