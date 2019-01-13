<?php

use Illuminate\Database\Seeder;

class StockTypeSeeder extends Seeder
{
    private $table = 'stock_types';
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
                'code' => 'FENER',
                'company_name' => 'FENER co ltd',
                'index' => '',
            ],
            [
                'code' => 'AEFES',
                'company_name' => 'Anadolu Efes',
                'index' => 'XU050',
            ],
            [
                'code' => 'OPIUM',
                'company_name' => 'Afyon Cement',
                'index' => 'XU100',
            ],
            [
                'code' => 'AKBNK',
                'company_name' => 'Akbank',
                'index' => 'XU030',
            ],
            [
                'code' => 'ALGYO',
                'company_name' => 'Alarko Gmyo',
                'index' => 'XU050',
            ],
            [
                'code' => 'AKENR',
                'company_name' => 'Ak Energy',
                'index' => 'XU050',
            ],
            [
                'code' => 'AKFEN',
                'company_name' => 'Akfen Holding',
                'index' => 'XU050',
            ],
            [
                'code' => 'PARTS',
                'company_name' => 'Aqsa',
                'index' => 'XU050',
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
