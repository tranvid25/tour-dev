<?php

namespace App\Models\clients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable=[
        'order_code',
        'amount',
        'bank_code',
        'transaction_no',
        'response_code',
        'transaction_status',
        'order_info',
        'pay_date',
        'ip_address'
    ];
}
