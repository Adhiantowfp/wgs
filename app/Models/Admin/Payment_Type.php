<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment_Type extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'payment_type',
        'account_name',
        'account_number',
        'total',
    ];
}
