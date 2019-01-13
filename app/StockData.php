<?php

namespace StockAnalysis;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StockData extends Model
{
    protected $table = 'stock_data';
    /**
     * Find one day data
     *
     * @param $stockTypeId
     * @param $date
     * @return \Illuminate\Support\Collection
     */
    public static function getOneDayData($stockTypeId, $date)
    {
        return DB::table('stock_data')
            ->join('stock_types', 'stock_types.id', '=', 'stock_data.stock_type_id')
            ->select('stock_data.timestamp', 'stock_data.value')
            ->where("stock_data.stock_type_id", $stockTypeId)
            ->whereBetween("stock_data.created_at", [$date . ' 00:00:00', $date . ' 23:59:59'])
            ->orderBy('stock_data.created_at')
            ->get();
    }

    /**
     * Filter by type id
     *
     * @param $stockTypeId
     * @return Model|null|object|static
     */
    public static function getEarliestDayData($stockTypeId)
    {
        return DB::table('stock_data')
            ->join('stock_types', 'stock_types.id', '=', 'stock_data.stock_type_id')
            ->select('company_name', DB::raw('date(stock_data.created_at) as created_at'))
            ->where("stock_data.stock_type_id", $stockTypeId)
            ->orderByDesc('stock_data.created_at')
            ->first();
    }
}
