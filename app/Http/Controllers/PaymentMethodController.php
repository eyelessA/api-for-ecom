<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\OrderRequest;
use App\Http\Requests\Payment\PaymentRequest;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use App\Services\Order\SortingByOrderCreationDateService;
use App\Services\Payment\ChangeStatusService;
use App\Services\Payment\GenerateLinkService;

class PaymentMethodController extends Controller
{
    private GenerateLinkService $generateLinkService;
    private ChangeStatusService $changeStatusService;
    private SortingByOrderCreationDateService $sortingByOrderCreationDate;

    public function __construct(
        GenerateLinkService $generateLinkService,
        ChangeStatusService $changeStatusService,
        SortingByOrderCreationDateService $sortingByOrderCreationDate
    )
    {
        $this->generateLinkService = $generateLinkService;
        $this->changeStatusService = $changeStatusService;
        $this->sortingByOrderCreationDate = $sortingByOrderCreationDate;
    }

    public function pay(PaymentRequest $paymentRequest): string
    {
        $data = $paymentRequest->validated();
        return $this->generateLinkService->generateLink($data);
    }

    public function changeStatus(string $paymentMethod): void
    {
        $this->changeStatusService->changeStatus($paymentMethod);
    }

    public function orders(OrderRequest $orderRequest)
    {
        $data = $orderRequest->validated();
        $orders = Order::all();
        $sortedOrders = $this->sortingByOrderCreationDate->sortingByOrderCreationDate($data, $orders);
        return OrderResource::collection($sortedOrders)->resolve();
    }
}
