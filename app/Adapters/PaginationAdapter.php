<?php

namespace App\Adapters;

use App\Http\Resources\DefaultResource;
use App\Repositories\Contracts\PaginationInterface;

class PaginationAdapter{
    public static function toJson(PaginationInterface $data){
        return [
            'meta' => [
                'total' => $data->total(),
                'per_page'=> $data->getNumberPerPage(),
                'current_page' => $data->currentPage(),
                'is_first_page' => $data->isFirstPage(),
                'is_last_page' => $data->isLastPage(),
                'next_page' => $data->getNumberNextPage(),
                'previous_page' => $data->getNumberPreviousPage(),
                'next_page_url'=> $data->getNextPageUrl(),
                'previous_page_url'=> $data->getPreviousPageUrl(),
            ],
            'data'=> $data->items()
        ];
    }
}
