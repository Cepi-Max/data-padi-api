<?php

namespace App\Models\Ricesales;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = 'products';
    protected $fillable = ['user_id', 'name', 'description', 'price', 'stock', 'image'];
}
