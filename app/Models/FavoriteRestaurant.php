<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FavoriteRestaurant extends Model
{
    use HasFactory, SoftDeletes;

    protected $table =  'favorite_restaurants';

    public $timestamps = false;
    
    protected $fillable = [
        'user_id',
        'restaurant_id'
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function restaurant() {
        return $this->hasOne(Restaurant::class, 'id', 'restaurant_id');
    }
}
