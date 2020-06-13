<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LotteryWinner extends Model
{
    protected $guarded = [];

    public function lottery_number() {
        return $this->hasOne(UserLotteryNumber::class, 'id', 'lottery_id');
    }
    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    //
}
