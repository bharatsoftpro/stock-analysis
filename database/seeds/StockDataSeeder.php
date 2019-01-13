<?php
use Illuminate\Database\Seeder;
use StockAnalysis\StockType;

class StockDataSeeder extends Seeder
{
    private $table = 'stock_data';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table($this->table)->delete();
        $stockTypes = StockType::all();
        foreach($stockTypes as $stockType) {
            //TODO need to ask this data will be seed through CLI or HTTP and also need to manage via its param ans maintain its state?
            // Yearly (1y) data seed
            $apiEndPoint = "https://portal-widgets-v3.foreks.com/periodic-tabs/data?id=graph1&code={$stockType->code}.E.BIST&period=1Y&intraday=60&delay=15&linecolor=%23ffd355";
            Log::info(sprintf("Getting Data for code: %s, %s", $stockType->code, $apiEndPoint));
            $client = new \GuzzleHttp\Client();
            $response = $client->post($apiEndPoint);
            if (!$response->getStatusCode() == 200) {//TODO validate content type
                Log::error(sprintf("Response code: %d : %s", $response->getStatusCode(), $stockType->code));
                return;
            }
            $responseBody = json_decode($response->getBody(), true);
            $seedData = [];
            Log::info(sprintf("Total size: %d ", sizeof($responseBody['data'])));
            foreach($responseBody['data'] as $data) {
                $seedData[] = ['stock_type_id' => $stockType->id, 'value' => $data[1], 'timestamp' => $data[0], 'created_at' => date('Y-m-d H:i:s', substr($data[0], 0, 10))];
            }

            DB::table($this->table)->insert($seedData);
        }
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
