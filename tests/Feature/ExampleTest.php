<?php

namespace Tests\Feature;

use StockAnalysis\Services\StockBuySell;
use StockAnalysis\StockConfig;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        // Tested the following data:

//        $stockPrice = [
//            [1546840800000,98],
//            [1546844400000,181],
//            [1546848000000,250],
//            [1546851600000,299],
//            [1546855200000,39],
//            [1546858800000,445],
//            [1546862400000,507]
//        ];
//        $stockPrice = [
//            [1546840800000,100],
//            [1546844400000,180],
//            [1546848000000,260],
//            [1546851600000,310],
//            [1546855200000,40],
//            [1546858800000,535],
//            [1546862400000,695]
//        ];
//        $stockPrice = [
//            [1546840800000,40],
//            [1546844400000,100],
//            [1546848000000,180],
//            [1546851600000,260],
//            [1546855200000,310],
//            [1546858800000,535],
//            [1546862400000,695]
//        ];
//        $stockPrice = [
//            [1546840800000,695],
//            [1546844400000,100],
//            [1546848000000,180],
//            [1546851600000,260],
//            [1546855200000,310],
//            [1546858800000,535],
//            [1546862400000,40]
//        ];
//        $stockPrice = [
//            [1546840800000,40],
//            [1546844400000,100],
//            [1546848000000,180],
//            [1546851600000,260],
//            [1546855200000,310],
//            [1546858800000,535],
//            [1546862400000,40]
//        ];
        $stockPrice = [
            [1546840800000,45],
            [1546844400000,24],
            [1546848000000,35],
            [1546851600000,31],
            [1546855200000,40],
            [1546858800000,38],
            [1546862400000,11]
        ];


        $stockBuySell = new StockBuySell();
        $stockConfig = StockConfig::all();
        $investmentMoney = $money = $stockConfig->firstWhere('key', 'investment_money')->value;
        $this->assertTrue(1000000 == $investmentMoney);

        dump($stockBuySell->findMaxProfitableBuySellForMostRecentDate(1, $investmentMoney, $investmentMoney), $investmentMoney);
        $this->assertTrue($money <= $investmentMoney);

        $investmentMoney = $money = 2000;
        dump($stockBuySell->findMaxProfitableBuySellForOneDay(1, "2019-01-11", $investmentMoney, $investmentMoney), "After suggest buy sell", $investmentMoney);
        $this->assertTrue($money <= $investmentMoney);

        $investmentMoney = $money = 1000;
        dump($stockBuySell->findMaxProfitableBuySellPeriod($stockPrice, $investmentMoney, true), $investmentMoney);
        $this->assertTrue($money <= $investmentMoney);
    }
}
