<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\User;

class UserRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules(Request $request)
	{

		$rules = [];
		if($request->path()=='api/signup'){
				$rules = [
					'user_name' => 'required',
					'email' => 'required|email',
					'player_id' => 'required',
					'password' => [
						'required',
						'string',
						// 'min:8',
						// 'max:12',             // must be at least 8 characters in length
					],
				];			
			}
	if($request->path()=='api/activate_account'){
		$rules = [
			'code' => 'required|min:6',
			'user_id' => 'required',
			'player_id' => 'required',
		];
	}
	if($request->path()=='api/signin'){
		$rules = [
			'email' => 'required|email',
			'password' => 'required',
			'player_id' => 'required',
		];
	}
	if($request->path()=='api/forgot_password'){
		$rules = [
			'email' => 'required|email',
		];
	}
	if($request->path()=='api/update_user'){
		$rules = [
			'user_name' => 'required',
		];
	}
	if($request->path()=='api/reset_password'){
		$rules = [
			'code' => 'required|min:6',
			'user_id' => 'required',
			'player_id' => 'required',
			'new_password' => [
				'required',
				'string',
				// 'min:8' 
			],
				// 'confirm_password' => 'required|same:new_password|min:8'    
		];
	}
	if($request->path()=='api/change_password'){
		$rules = [
			'old_password' => 'required',
			'new_password' => 'required',
		];
	}
	// if($request->path()=='api/edit_profile'){
	// 	$rules = [
	// 		'email' => 'email|unique:users',
	// 		'phone' => 'unique:users|min:12',
	// 	];
	// }
	if($request->path()=='api/get_cms'){
		$rules = [
			'slug' => 'required',
		];
	}
	if($request->path()=='api/withdraw_request'){
		$rules = [
			'withdraw_amount' => 'required',
		];
	}
	if($request->path()=='api/set_player_id'){
		$rules = [
			'player_id' => 'required',
		];
	}
	if($request->path()=='api/socialPhoneVerification'){
		$rules = [
			'phone' => 'required|min:12|numeric',
			'gender' => 'required',
			'id' => 'required'
		];
	}
	return $rules;
	}

protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
{

	$message=$validator->errors()->first();
	$rescode=\Config::get('constants.response.ResponseCode_precondition_required');
	$param='Data';
	$values= new \stdClass();
	$response = new JsonResponse([
		'ResponseHeader' => [
			'ResponseCode' => $rescode,
			'ResponseMessage' =>  $message
		],
	], \Config::get('constants.response.ResponseCode_precondition_required'));

	throw new \Illuminate\Validation\ValidationException($validator, $response);
}

}
