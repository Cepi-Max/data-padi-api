<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPadi extends Model
{
    use HasFactory;
    //
    protected $table = 'data_padi';
    protected $fillable = ['nama', 'jumlah_padi', 'latitude', 'longitude', 'foto_padi'];

}
