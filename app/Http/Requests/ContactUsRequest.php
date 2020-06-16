<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\User;

class ContactUsRequest extends FormRequest
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
		if($request->path()=='api/contact_us'){
				$rules = [
					'subject' => 'required',
					'message' => 'required'
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
