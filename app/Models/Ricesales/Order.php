<?php

namespace App\Models\Ricesales;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table = 'orders';
    protected $fillable = ['user_id', 'order_code', 'total_price', 'status', 'stock', 'image'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
