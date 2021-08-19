<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
// use Elasticquent\ElasticquentTrait;

class Category extends Model
{
    use Searchable;
    // use HasFactory;

    protected $fillable = [
        'name',
        'product_id'
    ];
}
