<?php

namespace App\Http\Controllers;

use App\LotteryPrice;
use Illuminate\Http\Request;

class LotteryPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lotteryPrice()
    {
        $price = lotteryPrice::first()->pluck('total_amount');
        if($price){
            $ResponseCode = \Config::get('constants.response.ResponseCode_success');
            $ResponseMessage = __('lottery.lottery_price');
        }else{
            $price = '';
            $ResponseCode = \Config::get('constants.response.ResponseCode_fail');
            $ResponseMessage = __('lottery.lottery_price_not_set');
            
        }
        return responseMsg($ResponseCode, $ResponseMessage, $price);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LotteryPrice  $lotteryPrice
     * @return \Illuminate\Http\Response
     */
    public function show(LotteryPrice $lotteryPrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LotteryPrice  $lotteryPrice
     * @return \Illuminate\Http\Response
     */
    public function edit(LotteryPrice $lotteryPrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LotteryPrice  $lotteryPrice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LotteryPrice $lotteryPrice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LotteryPrice  $lotteryPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(LotteryPrice $lotteryPrice)
    {
        //
    }
}
