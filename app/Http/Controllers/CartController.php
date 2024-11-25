<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\CartRequest;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Services\Cart\AddProductToCartService;
use App\Services\Cart\DeleteProductFromCartService;
use App\Services\Product\SortingByPrice;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    private AddProductToCartService $addProductToCartService;
    private DeleteProductFromCartService $deleteProductFromCartService;
    private SortingByPrice $sortingByPrice;

    public function __construct(
        AddProductToCartService      $addProductToCartService,
        DeleteProductFromCartService $deleteProductFromCartService,
        SortingByPrice               $sortingByPrice
    )
    {
        $this->addProductToCartService = $addProductToCartService;
        $this->deleteProductFromCartService = $deleteProductFromCartService;
        $this->sortingByPrice = $sortingByPrice;
    }

    public function addProductToCart(CartRequest $cartRequest): JsonResponse
    {
        $data = $cartRequest->validated();
        $this->addProductToCartService->addProductToCart($data);

        return response()->json('Товар успешно добавлен');
    }

    public function deleteProductFromCart(CartRequest $cartRequest): JsonResponse
    {
        $data = $cartRequest->validated();
        $this->deleteProductFromCartService->deleteProductFromCart($data);

        return response()->json('Товар успешно удален');
    }

    public function getProduct(int $id): array
    {
        $product = Product::query()->find($id);
        return ProductResource::make($product)->resolve();
    }

    public function getProducts(ProductRequest $productRequest): array
    {
        $data = $productRequest->validated();
        $products = Product::all();

        $sortedProduct = $this->sortingByPrice->sortingByPrice($products, $data);
        return ProductResource::collection($sortedProduct)->resolve();
    }
}
