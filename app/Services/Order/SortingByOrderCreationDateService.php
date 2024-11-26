<?php

namespace App\Services\Order;

use Illuminate\Database\Eloquent\Collection;

class SortingByOrderCreationDateService
{
    public function sortingByOrderCreationDate(array $data, Collection $orders)
    {
        $sortBy = $data['sort_by'] ?? null;

        switch ($sortBy) {
            case 'old_to_new':
                $orders = $orders->sortByDesc('created_at');
                break;
            case 'new_to_old':
                $orders = $orders->sortBy('created_at');
                break;
            default:
                break;
        }

        return $orders;
    }
}
