<?php

class Pagination {
    // Add this helper function at the end of the file
    private const DEFAULT_LIMIT = 50;
    private const NO_LIMIT_VALUE = 1000;

    public static function PaginationValues($page = 0, $limit = self::DEFAULT_LIMIT){
        $offset = (($page+1) * $limit)-$limit;
        return [
            "offset" => $offset,
            "limit" => $limit
        ];
    }


    public static function getPageLimit(?string $limit): int {
        if ($limit === null) return self::DEFAULT_LIMIT;
        if ($limit === "no_limit") return self::NO_LIMIT_VALUE;
        $intLimit = (int)$limit;
        return ($intLimit > 0 && $intLimit <= self::DEFAULT_LIMIT) ? $intLimit : self::DEFAULT_LIMIT;
    }

}