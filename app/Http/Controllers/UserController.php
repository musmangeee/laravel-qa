<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Hash;
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
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
