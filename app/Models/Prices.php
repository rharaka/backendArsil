<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Prices extends Model
{
    use Notifiable;
    protected $fillable = [
        'WEIGHT_FROM', 
        'WEIGHT_TO', 
        'COURIER', 
        'PRICE', 
        'PRICE_TYPE'
    ];
}
