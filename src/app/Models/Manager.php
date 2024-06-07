<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;
    protected $fillable = ['name','area_id','shop_id','postcode','address','tel','email','birthdate'];

    public function areas()
    {
        return $this->belongsTo('App\Models\Area', "area_id");
    }

    public function shops()
    {
        return $this->belongsTo('App\Models\Shop', "shop_id");
    }

    public function getArea(){
        return ($this->areas)->name;
    }

    public function getShop(){
        return ($this->shops)->name;
    }
}
