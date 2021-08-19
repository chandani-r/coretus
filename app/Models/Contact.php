<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Laravel\Scout\Searchable;
// use Elasticquent\ElasticquentTrait;

class Contact extends Model
{
    // use Searchable;
    // use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'email',
        'phone_no',
        'subject',
        'message'
    ];
}
