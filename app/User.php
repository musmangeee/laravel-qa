<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 'email', 'password','role','is_active','activation_code','player_id'
    ];

    public function lottery_numbers() {
        return $this->hasMany(UserLotteryNumber::class, 'user_id', 'id');
    }
    public function winning_numbers() {
        return $this->hasMany(LotteryWinner::class, 'user_id', 'id');
    }
    public function user_wallet() {
        return $this->hasOne(UserWallet::class, 'user_id', 'id');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','activation_code'
    ];
}
