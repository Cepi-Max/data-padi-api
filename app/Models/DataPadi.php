<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPadi extends Model
{
    //
    protected $table = 'data_padi';
    protected $fillable = ['nama', 'jumlah_padi', 'latitude', 'longitude', 'foto_padi'];

}
