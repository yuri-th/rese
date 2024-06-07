<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Shop extends Model
{
    use HasFactory;
    protected $fillable = ['name','area_id','genre_id','description','image_url',];

    public function areas()
    {
        return $this->belongsTo('App\Models\Area', "area_id");
    }

    public function genres()
    {
        return $this->belongsTo('App\Models\Genre', "genre_id");
    }

    public function getArea(){
        return ($this->areas)->name;
    }

    public function getGenre(){
        return ($this->genres)->name;
    }

    public function likes()
    {
        return $this->hasMany('App\Models\Like');
    }

    public function reservations()
    {
        return $this->hasMany('App\Models\Reservation');
    }

    public function managers()
    {
        return $this->hasMany('App\Models\Manager');
    }

    public function scopeAreaSearch($query, $area_id)
    {
        if (!empty($area_id)) {
            $query->where('area_id', $area_id);
        }
    }

    public function scopeGenreSearch($query, $genre_id)
    {
        if (!empty($genre_id)) {
            $query->where('genre_id', $genre_id);
        }
    }

    public function scopeKeywordSearch($query, $keyword)
    {
        if (!empty($keyword)) {
        $query->where('name', 'like', '%' . $keyword . '%');
        }
    }

    public function scopeShopSearch($query, $name)
    {
            $query->where('name', $name);    
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'shop_reviews');
    }    
}
