<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    //
}
