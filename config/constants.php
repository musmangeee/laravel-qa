<?php

return [
    'user' => [
        'user_not_active' => 0,
        'user_active' => 1,
    ],
    'roles' => [
        'admin' => 1,
        'employee' => 2,
        'user'=>3,
    ],
    'notifications' => [
        'read' => 1,
        'unread' => 2,
        'seen'=>3,
    ],
    'response' => [
        'ResponseCode_fail' => 201,
        'ResponseCode_success' => 200,
        'ResponseCode_account_not_activated' => 203,
        'ResponseCode_account_already_exist' => 204,
        'ResponseCode_created' => 200,
        'ResponseCode_wrong_activationCode' => 205,
        'ResponseCode_not_authenticated' => 401,
        'ResponseCode_bad_request' => 400,
        'ResponseCode_not_found' => 404,
        'ResponseCode_precondition_required'=>428,
    ]
];