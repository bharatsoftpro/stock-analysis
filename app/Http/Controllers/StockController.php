<?php

namespace StockAnalysis\Http\Controllers;

use Illuminate\Http\Request;

use StockAnalysis\Services\StockBuySell;
use StockAnalysis\Services\StockService;
use StockAnalysis\StockConfig;
use StockAnalysis\StockType;

class StockController extends Controller
{

    /**
     * StockController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $stockTypes = StockType::getStockTypes();
        $stockType = $stockTypes->firstWhere('stock_type_id', $request->id);
        if (!$stockType) {
            $stockType = $stockTypes[0];
        }
        $stockConfig = StockConfig::all();
        $stockDetails = StockType::find($stockType->stock_type_id)->stockData;
        $stockBuySell = new StockBuySell();
        $investmentMoney = $stockConfig->firstWhere('key', 'investment_money')->value;
        $bestTimeToBuy = $stockBuySell->findMaxProfitableBuySellForMostRecentDate($stockType->stock_type_id, $investmentMoney, true);

        return view('home', [
            'stockTypes' => $stockTypes,
            'companyEarning' => $stockType,
            'companyDetail' => $stockType,
            'stockConfig' => $stockConfig,
            'bestTimeToBuySell' => $bestTimeToBuy,
            'grownMoney' => $investmentMoney,
            'stockDetails' => $stockDetails,
        ]);
    }


}
