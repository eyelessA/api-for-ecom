<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}

/*
 *    'id' => $this->id,
            'user_id' => $this->user_id,
            'payment_method_id' => $this->payment_method_id,
            'status' => $this->status,
 */
