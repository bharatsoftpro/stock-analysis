@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Company Earning - {{ $companyEarning->company_name }}
                        ${{ $companyEarning->value }} </div>

                    <div class="card-body">
                        <ul>
                            @foreach ($stockDetails as $stockDetail)
                                <li style="float: left; padding-left: 5px; margin-left: 5px; list-style-type: none"> {{ $stockDetail->created_at }}
                                    ${{ $stockDetail->value }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">All Stock | Max stock type
                        ({{$stockConfig->firstWhere('key', 'max_stock_type')->value}})
                    </div>

                    <div class="card-body">
                        <ul>
                            @foreach ($stockTypes as $stockType)
                                <li>
                                    <a href="{{ route('stock', [$stockType->stock_type_id]) }}"> {{ $stockType->company_name }}
                                        ${{ $stockType->value }} </a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Stock Detail - {{ $companyDetail->company_name }}
                        ${{ $companyDetail->value }}

                        <input type="" value="{{ $stockConfig->firstWhere('key', 'investment_money')->value }}">

                    </div>

                    <div class="card-body">
                        <div>Today's Action item</div>
                        <ul>
                            @foreach ($bestTimeToBuySell as $bestTime)
                                @foreach ($bestTime as $k => $buySell)
                                    <li>
                                        {{  date('Y-m-d H:i:s', substr($buySell['time'], 0, 10)) }}
                                        ${{ $buySell['value'] }} - {{ $k }}
                                    </li>
                                @endforeach
                            @endforeach
                        </ul>
                        <div>Grown Money are based on above buy/sell {{$grownMoney}}</div>

                    </div>
                    <div>
                        <select>
                            @foreach ( explode(',', $stockConfig->firstWhere('key', 'date_range')->value) as $v)
                                @php
                                    $options = explode(':', $v);
                                @endphp
                                <option value="{{$options[0]}}">{{__($options[1])}}</option>
                            @endforeach
                        </select>

                        <select>
                            @foreach ( explode(',', $stockConfig->firstWhere('key', 'sell_buy_time')->value) as $v)
                                @php
                                    $options = explode(':', $v);
                                @endphp
                                <option value="{{$options[0]}}">{{__($options[1])}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
