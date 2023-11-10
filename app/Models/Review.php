<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $table =  'reviews';

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'restaurant_id'
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function restaurant() {
        return $this->hasOne(Restaurant::class, 'id', 'restaurant_id');
    }

    public function images() {
        return $this->hasMany(ReviewImage::class, 'review_id', 'id');
    }

    public function favoriteReviews() {
        return $this->hasMany(FavoriteReview::class, 'review_id', 'id');
    }
}
