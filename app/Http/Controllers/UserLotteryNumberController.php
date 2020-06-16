<?php

namespace App\Http\Controllers;

use App\UserLotteryNumber;
use App\UserTransaction;
use App\LotteryWinner;
use App\LotteryPrice;
use Illuminate\Http\Request;
use App\Http\Requests\LotteryRequest;
use Auth;
use Carbon\Carbon;
use App\UserWallet;

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
        $ResponseCode = \Config::get('constants.response.ResponseCode_success');
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
            $ResponseCode = \Config::get('constants.response.ResponseCode_no_content');
            $ResponseMessage = __('lottery.no_lottery_numbers_booked');
        }
		return responseMsg($ResponseCode, $ResponseMessage, $myNumbers);
    }

    public function allLotteryNumbersThisWeek()
    {
        $myNumbers = UserLotteryNumber::where('is_taken_out', 0)->with('user')->get();
        if(count($myNumbers)>0){
            $ResponseCode = \Config::get('constants.response.ResponseCode_success');
		    $ResponseMessage = __('lottery.my_lottery_numbers');
        }else{
            $ResponseCode = \Config::get('constants.response.ResponseCode_success');
            $ResponseMessage = __('lottery.no_lottery_numbers_booked');
        }
		return responseMsg($ResponseCode, $ResponseMessage, $myNumbers);
    }

    public function getJackpotWinner()
    {
        $myNumbers = UserLotteryNumber::where('is_taken_out', 0)->pluck('lottery_number')->toArray();
        if($myNumbers){
            $length = count($myNumbers);
            $index = mt_rand(1,$length);
            $winner = $myNumbers[$index];

            $ResponseCode = \Config::get('constants.response.ResponseCode_success');
		    $ResponseMessage = __('lottery.lottery_winner');
        }else{
            $winner = new \stdClass();
            $ResponseCode = \Config::get('constants.response.ResponseCode_success');
            $ResponseMessage = __('lottery.no_winner');
        }
		return responseMsg($ResponseCode, $ResponseMessage, $winner);
    }

    public function getLotteryWinners(Request $req)
    {
        $totalRevenue = 0;
        $remwinners = UserLotteryNumber::where('is_taken_out', 0)->get();
        if($remwinners){
            $lotteryStartDate = $remwinners[0]->created_at->toDateTimeString();
            $totalRevenue =  UserTransaction::where('created_at','>=',$lotteryStartDate)->sum('total_amount');
        }
        
        $totalLotteryPrize = 0.6 * $totalRevenue;
        $totalJackPotPrize = 0.6 * $totalLotteryPrize;
        $fiveNumberPrize = 0.035 * $totalLotteryPrize;
        $fourNumberPrize = 0.015 * $totalLotteryPrize;
        $threeNumberPrize = 0.35 * $totalLotteryPrize;

        $JackWinners  = 0;
        $fiveWinners  = 0;
        $fourWinners  = 0;
        $threeWinners = 0;

        // $jWinner = $req['jackpot'];
        // $jackpotWinners = UserLotteryNumber::where('is_taken_out', 0)->where('lottery_number', $jWinner)->get();
        // $jackpotPrize = $totalJackPotPrize / count($jackpotWinners);
        // foreach($jackpotWinners as $jackWinner){
        //     $jackWinner->is_taken_out = 1;
        //     $jackWinner->save();
        //     $jack_winner = LotteryWinner::create([
        //         'lottery_id' => $jackWinner->id,
        //         'user_id' => $jackWinner->user_id,
        //         'is_winner_status' => 1,
        //         'total_amount' => $jackpotPrize
        //     ]);
        // }
        $winner_number = explode(",",$req['jackpot']);
        foreach($remwinners as $key=>$winner){
            $compare = explode(",",$winner['lottery_number']);
            $result=array_intersect($compare,$winner_number);
            $winner->is_taken_out = 1;
            $winner->save();
            $winner['winner_status'] = count($result);
            if($winner['winner_status'] == 6){
                $JackWinners++;
            }elseif($winner['winner_status'] == 5){
                $fiveWinners++;
            }elseif($winner['winner_status'] == 4){
                $fourWinners++;
            }elseif($winner['winner_status'] == 3){
                $threeWinners++;
            }else{
                unset($remwinners[$key]);
            }
        }

        foreach($remwinners as $key=>$rem){
            if($rem['winner_status']==6){
                $status = 1;
                $prize_amount = $totalJackPotPrize / $JackWinners;
            }elseif($rem['winner_status']==5){
                $status = 2;
                $prize_amount = $fiveNumberPrize / $fiveWinners;
            }elseif($rem['winner_status'] == 4){
                $status = 3;
                $prize_amount = $fourNumberPrize / $fourWinners;
            }elseif($rem['winner_status'] == 3){
                $status = 4;
                $prize_amount = $threeNumberPrize / $threeWinners;
            }
            $jack_winner = LotteryWinner::create([
                'lottery_id' => $rem->id,
                'user_id' => $rem->user_id,
                'is_winner_status' => $status,
                'total_amount' => $prize_amount
            ]);
            $userWallet =  UserWallet::where('user_id',$rem->user_id)->increment('available_balance',$prize_amount);
        }

        // $length = count($myNumbers);
        // $index = mt_rand(1,$length);
        // $winner = $myNumbers[$index];
        // if($winner){
        //     $ResponseCode = \Config::get('constants.response.ResponseCode_success');
		//     $ResponseMessage = __('lottery.lottery_winner');
        // }else{
        //     $ResponseCode = \Config::get('constants.response.ResponseCode_success');
        //     $ResponseMessage = __('lottery.no_winner');
        // }
		// return responseMsg($ResponseCode, $ResponseMessage, $winner);
    }

    public function getLotteryInfo()
    {
        $lJackpotNumber = '';
        $lastJackpotPrize = 0;
        $price = '';
        $avaiableBalance = 0;
        $nextDrawDate = Carbon::parse('next friday')->toDateString();
        $lastJackpotNumber = LotteryWinner::where('is_winner_status', 1)->with('lottery_number')->latest('created_at')->first();
        if($lastJackpotNumber){
            $date = $lastJackpotNumber['created_at']->toDateString().' 00:00:00';
            $lastJackpotPrize = LotteryWinner::where('is_winner_status', 1)->where('created_at','>=', $date)->get()->sum('total_amount');
            $lJackpotNumber = $lastJackpotNumber['lottery_number']->lottery_number;
        }
        $lottery_price = lotteryPrice::first();
        if($lottery_price){
            $price = $lottery_price->total_amount;
        }
        $userWallet =  UserWallet::where('user_id',Auth::id())->first();
        if($userWallet){
            $avaiableBalance = $userWallet->available_balance;
        }
        $lotteries = UserLotteryNumber::where('is_taken_out', 0)->with('user')->get();
        $totalEntries = count($lotteries);
        $lotteryInfo = new \stdClass();
        $lotteryInfo->last_jackpot_number =  $lJackpotNumber;
        $lotteryInfo->next_draw_date =  $nextDrawDate;
        $lotteryInfo->total_entries =  $totalEntries;
        $lotteryInfo->last_jackpot_prize =  round($lastJackpotPrize);
        $lotteryInfo->account_balance =  $avaiableBalance;
        $lotteryInfo->lottery_price =  $price;
        
        $ResponseCode = \Config::get('constants.response.ResponseCode_success');
        $ResponseMessage = __('lottery.no_lottery_numbers_booked');
        
		return responseMsg($ResponseCode, $ResponseMessage, $lotteryInfo);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getWinnersList(Request $req)
    {
        if(array_key_exists('latest',$req->all())){
            $getDate = LotteryWinner::latest('created_at')->first();
            if($getDate){
                $lastDrawDate = $getDate['created_at']->toDateString().' 00:00:00';
                $lastJackpotNumber = LotteryWinner::with('lottery_number','user')->where('created_at','>=',$lastDrawDate)->latest('created_at')->get();        
            }else{
                $lastJackpotNumber = new \stdClass();
            }
            }else{
            $lastJackpotNumber = LotteryWinner::with('lottery_number','user')->latest('created_at')->get();
        }

        $ResponseCode = \Config::get('constants.response.ResponseCode_success');
        $ResponseMessage = __('lottery.no_lottery_numbers_booked');
        
		return responseMsg($ResponseCode, $ResponseMessage, $lastJackpotNumber);
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
