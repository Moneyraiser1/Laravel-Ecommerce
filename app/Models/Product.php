<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'images',
        'price',
        'stock',
        'category_id',
        'status',
        'description'
    ];
// App\Models\Product.php
public function category()
{
    return $this->belongsTo(\App\Models\Category::class, 'category_id');
}

    // Cast JSON images to array automatically
    protected $casts = [
        'images' => 'array',
    ];
}
