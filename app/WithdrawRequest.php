<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class WithdrawRequest extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function user_wallet() {
        return $this->hasOne(UserWallet::class, 'user_id', 'user_id');
    }
}
