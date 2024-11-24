<?php

namespace App\Services\Product;

use Illuminate\Database\Eloquent\Collection;

class SortingByPrice
{
    public function sortingByPrice(Collection $products, array $data): Collection
    {
        $sortBy = $data['sort_by'] ?? null;

        switch ($sortBy) {
            case 'desc':
                $products = $products->sortByDesc('price');
                break;
            case 'asc':
                $products = $products->sortBy('price');
                break;
            default:
                break;
        }

        return $products;
    }
}
