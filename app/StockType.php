<?php

namespace StockAnalysis;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StockType extends Model
{
    /**
     * Get the stockData for the specific stock.
     */
    public function stockData()
    {
        return $this->hasMany(StockData::class);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getStockTypes()
    {
        return DB::table('stock_data')
            ->join('stock_types', 'stock_types.id', '=', 'stock_data.stock_type_id')
            ->select('stock_data.stock_type_id', 'stock_types.code', 'stock_types.company_name', 'stock_data.value')
            ->groupBy('stock_data.stock_type_id')
            ->orderByDesc('stock_data.created_at')
            ->get();
    }


}
