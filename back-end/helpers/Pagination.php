<?php

class Pagination {
    public static function PaginationValues($page = 0, $limit = 100){
        $offset = (($page+1) * $limit)-$limit;
        return [
            "offset" => $offset,
            "limit" => $limit
        ];
    }

    // Add this helper function at the end of the file
    private const DEFAULT_LIMIT = 100;
    private const NO_LIMIT_VALUE = 1000;

    public static function getPageLimit(?string $limit): int {
        if ($limit === null) return self::DEFAULT_LIMIT;
        if ($limit === "no_limit") return self::NO_LIMIT_VALUE;
        $intLimit = (int)$limit;
        return ($intLimit > 0 && $intLimit <= self::DEFAULT_LIMIT) ? $intLimit : self::DEFAULT_LIMIT;
    }

}