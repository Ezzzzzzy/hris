<?php

namespace App\Classes;

use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class Paginate
{
    private static $paginate;

    /**
     * @param Illuminate\Support\Collection $result
     * @param int $page
     * @param int $limit
     */
    public function __construct(Collection $result, $page=1, $limit=10)
    {
        self::$paginate = new LengthAwarePaginator(
            $result->forPage($page, $limit),
            $result->count(),
            $limit,
            $page
        );
    }

    /**
     * Displays the pagination data as an array
     * This is a created based on toArray() of LengthAwarePaginator Class since it has bug.
     *
     * @param Illuminate\Pagination\LengthAwarePaginator $collection
     * @return array
     */
    public static function paginate()
    {
        $collection = self::$paginate;
        $data = [];
        if ($collection->currentPage() > 1) {
            $tempdata = $collection->getCollection()->toArray();
            foreach ($tempdata as $key => $value) {
                $data[] = $value;
            }
        } else {
            $data = $collection->getCollection()->toArray();
        }

        return [
            "data" => $data,
            "links" => [
                "first" => null,
                "last" => $collection->lastPage(),
                "next" => $collection->nextPageUrl(),
                "prev" => $collection->previousPageUrl(),
            ],
            "meta" => [
                "current_page" => $collection->currentPage(),
                "from" => $collection->firstItem(),
                "per_page" => (int) $collection->perPage(),
                "to" => $collection->lastItem(),
                "total" => $collection->total()
            ]
        ];
    }
}
