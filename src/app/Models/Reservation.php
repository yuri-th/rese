<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['shop_id','user_id','num_of_users','date','start_at',];

    public function shops()
    {
        return $this->belongsTo('App\Models\Shop', "shop_id");
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User', "user_id");
    }

    public function shopName(){
        return ($this->shops)->name;
    }

    public function shopUser(){
        return ($this->users)->name;
    }

    public function userMail(){
        return ($this->users)->email;
    }
}
