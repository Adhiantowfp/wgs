<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_Checkout extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'payment_id',
        'user_id',
        'address_id',
        'product_id',
        'product_quantity',
        'product_price',
        'price_total',
        'order_notes',
        'payment_type',
        'status',
    ];
}
