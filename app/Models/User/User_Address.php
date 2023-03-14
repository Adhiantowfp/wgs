<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'address_id',
        'user_id',
        'name',
        'phone_number',
        'province',
        'city',
        'districts',
        'zip_code',
        'address',
    ];
}
