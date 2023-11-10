<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restaurant extends Model
{
    use HasFactory, SoftDeletes;

    protected $table =  'restaurants';

    protected $fillable = [
        'name',
        'description',
        'location',
        'image'
    ];

    public function favoriteRestaurants() {
        return $this->hasMany(FavoriteRestaurant::class, 'restaurant_id', 'id');
    }
}
