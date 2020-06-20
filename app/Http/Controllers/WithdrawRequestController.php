<?php

namespace App\Http\Controllers;

use App\WithdrawRequest;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Input;
use App\UserWallet;
use Hash;
use Auth;
use Mail;

class WithdrawRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function userWithdrawRequest(UserRequest $request)
    {
        $input = $request->all();
        $user_id = Auth::id();
        $availableBalance = 0;
        $userWallet = UserWallet::where('user_id',$user_id)->first();
        if($userWallet){
            $availableBalance = $userWallet->available_balance;
            if($input['withdraw_amount'] > $availableBalance || $input['withdraw_amount'] == 0){
                $withdrawRequest = new \stdClass();
                $ResponseCode = \Config::get('constants.response.ResponseCode_fail');
                $ResponseMessage = __('withdraw.not_enough_available_balance');
            }else{
                $withdraw = WithdrawRequest::create([
                    'user_id' => $user_id,
                    'amount' => $input['withdraw_amount']
                ]);
                $withdrawRequest =  UserWallet::where('user_id',$rem->user_id)->decrement('available_balance',$input['withdraw_amount']);
                $ResponseCode = \Config::get('constants.response.ResponseCode_success');
                $ResponseMessage = __('withdraw.withdraw_request_success');
            }
        }else{
            $withdrawRequest = new \stdClass();
            $ResponseCode = \Config::get('constants.response.ResponseCode_fail');
            $ResponseMessage = __('withdraw.no_wallet_history');

        }
		return responseMsg($ResponseCode, $ResponseMessage, $withdrawRequest);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WithdrawRequest  $withdrawRequest
     * @return \Illuminate\Http\Response
     */
    public function getWithdrawRequestData(WithdrawRequest $withdrawRequest)
    {
        
        $queryString = Input::get('filter');
        $sortcol = Input::get('sortcol');
        $builder = WithdrawRequest::query();
        $builder->with('user','user_wallet');
        if (Input::has('filter') && $queryString !='') {
            $builder->where('full_name', 'LIKE', "$queryString%");
        }
        return $users = $builder->orderBy($sortcol, Input::get('sort'))->paginate(50)->toArray();
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WithdrawRequest  $withdrawRequest
     * @return \Illuminate\Http\Response
     */
    public function getUserWalletDetails($id)
    {
        return WithdrawRequest::where('id',$id)->with('user','user_wallet')->first();
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WithdrawRequest  $withdrawRequest
     * @return \Illuminate\Http\Response
     */
    public function proceedWithdraw(Request $request)
    {
        UserWallet::where('id',$request['data']['userWallet']['id'])->decrement('total_balance',$request['data']['withdraw_amount']);        //
        return WithdrawRequest::where('id',$request['data']['requestId'])->update(['is_proceed' => 1]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WithdrawRequest  $withdrawRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(WithdrawRequest $withdrawRequest)
    {
        //
    }
}
