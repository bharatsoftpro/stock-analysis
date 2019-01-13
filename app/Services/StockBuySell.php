<?php
/**
 * Created by PhpStorm.
 * User: bharat.bhushan
 * Date: 1/12/19
 * Time: 7:00 PM
 */

namespace StockAnalysis\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use StockAnalysis\StockData;
use StockAnalysis\StockType;

class StockBuySell
{

    public function buy(StockService $stockService)
    {
        return $stockService->buy();
    }

    public function sell(StockService $stockService)
    {
        return $stockService->sell();
    }

    /**
     * Generic method to find the buy sell most profitable outcome
     *
     * @param array $stockTimePrices
     * @param float $investmentMoney
     * @param bool $withTimeValueKey
     * @return array|void
     */
    public function findMaxProfitableBuySellPeriod($stockTimePrices = [], &$investmentMoney = 0.0, $withTimeValueKey = false)
    {
        $solutions = [];
        if (empty($stockTimePrices) || ($numberOfElements = sizeof($stockTimePrices)) < 2) {
            return $solutions;
        }

        $i = 0;
        while ($i < $numberOfElements - 1) {

            // Find the local min and its limit is (n-2) and comparing present element to the next element.
            while (($i < $numberOfElements - 1) && ($stockTimePrices[$i + 1][1] <= $stockTimePrices[$i][1])) {
                $i++;
            }
            // If we reached the end then no further solution possible
            if ($i == $numberOfElements - 1) {
                break;
            }

            // Store the index of min|max and its value
            $sol = [];
            $buyDay = $i++;
            if ($withTimeValueKey) {
                $sol['buy']['time'] = $stockTimePrices[$buyDay][0];
                $sol['buy']['value'] = $stockTimePrices[$buyDay][1];
            } else {
                $sol['buy'] = $stockTimePrices[$buyDay];
            }

            // Find the local max and its limit is (n-1) and comparing to previous element
            while (($i < $numberOfElements) && ($stockTimePrices[$i][1] >= $stockTimePrices[$i - 1][1])) {
                $i++;
            }
            $sellDay = $i - 1;
            if ($withTimeValueKey) {
                $sol['sell']['time'] = $stockTimePrices[$sellDay][0];
                $sol['sell']['value'] = $stockTimePrices[$sellDay][1];
            } else {
                $sol['sell'] = $stockTimePrices[$sellDay];
            }

            $solutions[] = $sol;// Store the in new index
        }

        Log::info("Processing stock pricess: ", $stockTimePrices);
        if (count($solutions) == 0) {
            Log::info("There is no day when buying the stock will make profit!");
        } else {
            //Calculate the profit on invested money as per $solutions algorithm
            $quantity = 0;
            foreach ($solutions as $k) {
                foreach ($k as $type => $dayValue) {
                    if ($type == 'buy' && $investmentMoney > 0) {
                        $quantity = $investmentMoney / $dayValue['value'];
                        $investmentMoney = 0;
                    } else {
                        $investmentMoney = $quantity * $dayValue['value'];
                        //TODO net profit
                    }
                    Log::info(sprintf("%s on", $type), $dayValue);
                }
            }
        }

        return $solutions;
    }


    /**
     * Wrapper method for find the buy sell schedule for maximum profit
     *
     * @param $stockTypeId
     * @param $date
     * @param float $investmentMoney
     * @param bool $withTimeValueKey
     * @return mixed
     */
    public function findMaxProfitableBuySellForOneDay($stockTypeId, $date, &$investmentMoney = 0.0, $withTimeValueKey = false)
    {
        $lists = StockData::getOneDayData($stockTypeId, $date);
        $stockTimePrices = [];
        foreach ($lists as $list) {
            $stockTimePrices[] = [$list->timestamp, $list->value];
        }

        return $this->findMaxProfitableBuySellPeriod($stockTimePrices, $investmentMoney, $withTimeValueKey);
    }

    /**
     * Get most recent date
     *
     * @param $stockTypeId
     * @param float $investmentMoney
     * @param bool $withTimeValueKey
     * @return mixed
     */
    public function findMaxProfitableBuySellForMostRecentDate($stockTypeId, &$investmentMoney = 0.0, $withTimeValueKey = false)
    {
        $stockType = StockData::getEarliestDayData($stockTypeId);
        return $this->findMaxProfitableBuySellForOneDay($stockTypeId, $stockType->created_at, $investmentMoney, $withTimeValueKey);
    }

    /**
     * Find the maximum profit value
     *
     * @param array $stockPrices
     * @return int
     */
    public function maximizeProfit($stockPrices = [])
    {
        $solutions = 0;
        if (empty($stockPrices) || ($numberOfDays = sizeof($stockPrices)) < 2) {
            return $solutions;
        }
        $lowestStockPriceTillNow = $stockPrices[0];
        $maxProfitTillNow = 0;
        for ($i = 0; $i < $numberOfDays; $i++) {
            if ($stockPrices[$i] < $lowestStockPriceTillNow) {
                $lowestStockPriceTillNow = $stockPrices[$i];
            } else {
                if ($stockPrices[$i] - $lowestStockPriceTillNow > $maxProfitTillNow) {
                    $maxProfitTillNow = $stockPrices[$i] - $lowestStockPriceTillNow;
                }
            }
        }

        return $maxProfitTillNow;
    }

}