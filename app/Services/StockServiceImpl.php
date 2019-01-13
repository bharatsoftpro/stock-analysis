<?php

namespace StockAnalysis\Services;


use Illuminate\Http\Request;
use Validator;

class StockServiceImpl implements StockService
{

    private $request;

    /**
     * StockServiceImpl constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function buy()
    {
        $this->validate();

        //$this->store()
        return $this->request->toArray();
        // TODO: Implement buy() method.
    }

    public function sell()
    {
        $this->validate();
        //$this->store()
        return $this->request->toArray();
        // TODO: Implement sell() method.
    }

    public function validate() {
        $validator = Validator::make($this->request->all(), [
            //TODO
        ]);
        if ($validator->fails()) {
            return redirect("/")
                ->withErrors($validator)
                ->withInput();
        }
    }
}