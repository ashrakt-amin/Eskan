<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\LengthAwarePaginator;
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


    // في ملف PaginationTrait.php
    public function paginateData($data, $request, $perPage = 10)
    {
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $perPage;

        return new LengthAwarePaginator(
            array_slice($data, $offset, $perPage),
            count($data),
            $perPage,
            $page,
            ['path' => $request->url()]
        );
    }
}
