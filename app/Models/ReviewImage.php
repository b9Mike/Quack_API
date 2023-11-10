<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReviewImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table =  'review_images';

    //public $timestamps = false;

    protected $fillable = [
        'image',
        'review_id'
    ];

    public function review() {
        return $this->belongsTo(Review::class);
    }
}
