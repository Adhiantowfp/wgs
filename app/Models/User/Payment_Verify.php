<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment_Verify extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'payment_id',
        'user_id',
        'price_total',
        'image_payment',
        'payment_type',
        'status',
    ];
}
