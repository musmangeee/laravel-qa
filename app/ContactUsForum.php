<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class ContactUsForum extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    
    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    //
}
