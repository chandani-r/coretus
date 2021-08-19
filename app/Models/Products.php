<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'discount_price',
        'cat_id',
        'image',
        'video',
        'description',
        'status',
        'detailed_description',
        'size',
        'color',
        'primary_image'
    ];
}
