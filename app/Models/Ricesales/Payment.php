<?php

namespace App\Models\Ricesales;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $table = 'payments';
    protected $fillable = ['order_id', 'user_id', 'payment_method', 'payment_status', 'transaction_id', 'amount'];

}
