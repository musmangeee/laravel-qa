<?php

namespace App\Http\Controllers;

use App\ContactUsForum;
use Illuminate\Http\Request;
use App\Http\Requests\ContactUsRequest;
use Illuminate\Support\Facades\Input;
use Auth;
use Mail;

class ContactUsForumController extends Controller
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
    public function submitContactUs(ContactUsRequest $request)
    {
        $user_id = Auth::id();
        $contactUs = ContactUsForum::create([
            'user_id' => $user_id,
            'subject' => $request['subject'],
            'message' => $request['message']
        ]);
        
        $ResponseCode = \Config::get('constants.response.ResponseCode_success');
		$ResponseMessage = __('contactUs.contact_us_Request');
		return responseMsg($ResponseCode, $ResponseMessage, $contactUs);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ContactUsForum  $contactUsForum
     * @return \Illuminate\Http\Response
     */
    public function getContactUsData()
    {
        $queryString = Input::get('filter');
        $sortcol = Input::get('sortcol');
        $builder = ContactUsForum::query();
        $builder->with('user');
        if (Input::has('filter') && $queryString !='') {
            $builder->where('subject', 'LIKE', "$queryString%");
        }
        return $users = $builder->orderBy($sortcol, Input::get('sort'))->paginate(50);
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ContactUsForum  $contactUsForum
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return ContactUsForum::where('id',$id)->with('user')->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ContactUsForum  $contactUsForum
     * @return \Illuminate\Http\Response
     */
    public function reply(Request $request)
    {
        // return $request['data']['email'];
        $mail = Mail::raw($request['data']['message'], function($message) use ($request)
        {
            $message->subject($request['data']['subject']);
            $message->to($request['data']['email']);
        });
        // if($mail){
            ContactUsForum::where('id',$request['data']['id'])->update([
                'is_replied' => 1]);
        // }
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ContactUsForum  $contactUsForum
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactUsForum $contactUsForum)
    {
        //
    }
}
