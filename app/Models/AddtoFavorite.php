<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Elasticquent\ElasticquentTrait;

class AddtoFavorite extends Model
{
    // use ElasticquentTrait;
    use HasFactory;

    protected $fillable = [
        'product_id',
        'add_to_favourite', 
    ];

}
