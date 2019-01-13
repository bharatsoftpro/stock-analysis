<?php

use Illuminate\Database\Seeder;

class StockConfigSeeder extends Seeder
{
    private $table = 'stock_configs';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table($this->table)->delete();
        DB::table($this->table)->insert([
            [
                'key' => 'investment_money',
                'value' => '1000000',//todo its currency type
            ],
            [
                'key' => 'max_stock_type',
                'value' => '3',
            ],
            [
                'key' => 'date_range',
                'value' => '4D:fourDay,3M:threeMonths,50D:fiftyDays',
            ]
            ,
            [
                'key' => 'sell_buy_time',
                'value' => 'bod:beginOfTheDay,eod:endOfTheDay,anyTime:anyTime',
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
