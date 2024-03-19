<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

trait PaginationTrait
{
    public function generatePaginationUrls($currentPage, $totalPages, $request)
    {
        $nextPage = $currentPage + 1;
        $hasNextPage = $nextPage <= $totalPages;
        $nextPageUrl = $hasNextPage
            ? URL::current() . '?paginate=' . $request['paginate'] . '&page=' . $nextPage
            : null;

        $previousPage = $currentPage - 1;
        $hasPreviousPage = $previousPage > 0;
        $previousPageUrl = $hasPreviousPage
            ? URL::current() . '?paginate=' . $request['paginate'] . '&page=' . $previousPage
            : null;

        return [
            'next_page_url' => $nextPageUrl,
            'prev_page_url' => $previousPageUrl,
        ];
    }
}
