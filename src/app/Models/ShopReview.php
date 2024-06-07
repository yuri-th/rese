<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopReview extends Model
{
    use HasFactory;
    protected $fillable = ['shop_id','user_id','stars','comment','image_path'];

    public function shop()
    {
        return $this->belongsTo('App\Models\Shop', 'shop_id');
    }

    public function getGenre()
    {
        if ($this->shop) {
            return $this->shop->genres->name;
        } 
    }

    public function getArea(){
        return $this->shop->areas->name;
    }
}
