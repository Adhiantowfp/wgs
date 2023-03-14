<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'product_name',
        'product_image',
        'product_type',
        'product_quantity',
        'product_description',
        'product_detail',
        'product_info',
        'product_price',
        'product_discount',
        'product_category',
        'product_rating',
        'product_review',
    ];
}
