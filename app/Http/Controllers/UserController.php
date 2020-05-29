<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Hash;
use Auth;
use Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendActivationCode($textbody , $reciepent)
    {
        Mail::raw($textbody, function($message) use ($reciepent)
        {
            $message->subject('Activate your account');
            $message->to($reciepent);
        });
    }
    public function getUserData($id)
    {
        return User::find($id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userSignup(UserRequest $request)
    {
        //
        $input = $request->all();
        $password = Hash::make($input['password']);
        $activation_code = mt_rand(100000, 999999);
        // $activation_code = 123321;
        $userExist = User::where('email', $input['email'])->first();
        $textbody = 'Hello '.$input['user_name'].' !
        Your activation code is '.$activation_code;
        if ($userExist) {
            if ($userExist->is_activate == 0) {
                // Resend activation code
                 User::where('id',$userExist->id)->update([
                    'activation_code' => $activation_code
                 ]);
                 $this->sendActivationCode($textbody,$input['email']);
                 $code = \Config::get('constants.response.ResponseCode_account_not_activated');
                 $message = 'account_already_exist_but_not_active';
                 $User = $userExist;
            }else{
                 $code = \Config::get('constants.response.ResponseCode_account_already_exist');
                 $message = 'account_already_exist';
                 $User = $userExist;
            }
            
        } else {
            // user register
            $User = User::create([
                'user_name' => $input['user_name'],
                'email' => $input['email'],
                'password' => $password,
                'activation_code' => $activation_code
            ]);
            $this->sendActivationCode($textbody , $input['email']);
            $code = \Config::get('constants.response.ResponseCode_created');
            $message = 'register_success';
        }
        return responseMsg($code,__($message), $User);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function activateAccount(UserRequest $request)
    {
        $input = $request->all();
		 $userDetails = $this->getUserData($input['user_id']);
		if ($userDetails) {
			if ($userDetails->is_active == \Config::get('constants.user.user_not_active')) {
				if ($input['code'] == $userDetails->activation_code) {
					$userDetails->is_active = \Config::get('constants.user.user_active');
                    $userDetails->save();
                    // Auth::attempt(['email' => $userDetails->email, 'password' => $userDetails->password]);
                    $userDetails->token = $userDetails->createToken($userDetails->user_name)->accessToken;
					$ResponseCode = \Config::get('constants.response.ResponseCode_success');
					$ResponseMessage = __('users.account_activated');
				} else {
					$ResponseCode = \Config::get('constants.response.ResponseCode_wrong_activationCode');
					$ResponseMessage = __('users.enter_valid_code');
				}
			} else {
				$ResponseCode = \Config::get('constants.response.ResponseCode_fail');
				$ResponseMessage = __('users.already_active');
			}
		} else {
			$ResponseCode = \Config::get('constants.response.ResponseCode_no_content');
			$ResponseMessage = __('users.no_user_found');
			$userDetails = new \stdClass();
		}
		return responseMsg($ResponseCode, $ResponseMessage, $userDetails);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function userSignin(UserRequest $request)
    {
        $input = $request->all();
		$credentials = $request->only('email', 'password');
		$userDetails = User::where('email',$input['email'])->first();

		if ($userDetails && $userDetails->role == \Config::get('constants.roles.user')) {
			if (!Hash::check($input['password'], $userDetails->password)) {
				$ResponseCode = \Config::get('constants.response.ResponseCode_not_authenticated');
				$ResponseMessage = __('users.login_none');
				$userDetails = new \stdClass();
			}
			if ($userDetails->is_active == \Config::get('constants.user.user_not_active')) {
				$ResponseCode = \Config::get('constants.response.ResponseCode_account_not_activated');
				$ResponseMessage = __('users.account_not_found_phone');
			}
			if (Auth::attempt($credentials)) {			
				$authUser = Auth()->user();
				$UserToken = $authUser->createToken($authUser->full_name)->accessToken;
                $userDetails->save();
                $userDetails->token = $UserToken;
				$ResponseCode = \Config::get('constants.response.ResponseCode_success');
				$ResponseMessage = __('users.login_success');
			}
		} else {
			$ResponseCode = \Config::get('constants.response.ResponseCode_not_found');
            $ResponseMessage = __('users.nouserfound');
            $userDetails = new \stdClass();
        }
        return responseMsg($ResponseCode, $ResponseMessage, $userDetails);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function ainvyi()
    {
        $ad = Auth::id();
        return $ad;
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
