<?php
 namespace App\product;
 use App\Models\Products;
 use Illuminate\Database\Eloquent\Collection;
 class EloquentSearchRepository implements SearchRepository
 {
     public function search(string $term): Collection
     {
         return Products::query()
             ->where(fn ($query) => (
                 $query->where('name', 'LIKE', "%{$term}%")
                    //  ->orWhere('title', 'LIKE', "%{$term}%")
             ))
             ->get();
     }
 }