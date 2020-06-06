<?php

namespace App\Http\Controllers;

use App\UserLotteryNumber;
use App\UserTransaction;
use Illuminate\Http\Request;
use App\Http\Requests\LotteryRequest;
use Auth;

class UserLotteryNumberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bookLotteryNumbers(LotteryRequest $request)
    {
        $input = $request->all();
        $user_id = Auth::id();
        $ref_ids = [];
        foreach($input['lottery_numbers'] as $lottery_number){
            $book_lottery = UserLotteryNumber::create([
                'lottery_number' => $lottery_number['number'],
                'user_id' => $user_id
            ]);
            array_push($ref_ids, $book_lottery->id);
        }
        // return $ref_ids;
        if(!empty($ref_ids)){
            $transactions = UserTransaction::create([
                'transaction_id' => $input['transaction_id'],
                'ref_id' => json_encode($ref_ids),
                'total_amount' => $input['total_amount'],
                'user_id' => $user_id
            ]);
        }
        $ResponseCode = \Config::get('constants.response.ResponseCode_no_content');
		$ResponseMessage = __('lottery.lottery_numbers_booked');
		return responseMsg($ResponseCode, $ResponseMessage, $transactions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myLotteryNumbers()
    {
        $user_id = Auth::id();
        $myNumbers = UserLotteryNumber::where('user_id',$user_id)->where('is_taken_out', 0)->select('id','lottery_number','created_at')->get();
        if(count($myNumbers)>0){
            $ResponseCode = \Config::get('constants.response.ResponseCode_success');
		    $ResponseMessage = __('lottery.my_lottery_numbers');
        }else{
            $ResponseCode = \Config::get('constants.response.ResponseCode_success');
            $ResponseMessage = __('lottery.no_lottery_numbers_booked');
        }
		return responseMsg($ResponseCode, $ResponseMessage, $myNumbers);
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
     * @param  \App\UserLotteryNumber  $userLotteryNumber
     * @return \Illuminate\Http\Response
     */
    public function show(UserLotteryNumber $userLotteryNumber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserLotteryNumber  $userLotteryNumber
     * @return \Illuminate\Http\Response
     */
    public function edit(UserLotteryNumber $userLotteryNumber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserLotteryNumber  $userLotteryNumber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserLotteryNumber $userLotteryNumber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserLotteryNumber  $userLotteryNumber
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserLotteryNumber $userLotteryNumber)
    {
        //
    }
}
