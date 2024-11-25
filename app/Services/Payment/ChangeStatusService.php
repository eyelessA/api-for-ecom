<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChangeStatusService
{
    public function changeStatus(string $paymentMethod): void
    {
        Auth::setUser(User::query()->first());
        PaymentMethod::query()->where('name', '=', $paymentMethod);
        $paymentMethodId = PaymentMethod::query()->where('name', '=', $paymentMethod)->first()->id;
        $order = Order::query()
            ->where('user_id', '=', Auth::user()->id)
            ->where('payment_method_id', '=', $paymentMethodId)
            ->where('status', '=', 'На оплату')
            ->first();

        $order->update([
            'status' => 'Оплачен'
        ]);
    }
}
