<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;

class Helper
{
    /**
     * Sum with optional date range
     *
     * @param string $model   
     * @param string $column  
     * @param string $dateColumn
     * @param string|null $from
     * @param string|null $to
     * @return float|int
     */
    public static function sum($model, $column, $dateColumn = 'date', $from = null, $to = null)
    {
        return $model::when($from && $to, function (Builder $query) use ($from, $to, $dateColumn) {
                $query->whereBetween($dateColumn, [$from, $to]);
            })->sum($column);
    }
}
