<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class shipment extends Model
{
    use Notifiable;
    protected $fillable = [
        'ORDER_NUMBER', 
        'SENDER_CODE', 
        'RECEIVER_CODE', 
        'COURIER', 
        'PRICE', 
        'PRICE_TYPE', 
        'DETAILS', 
        'CONTACT_DETAILS', 
        'ID_USER'
    ];
}
