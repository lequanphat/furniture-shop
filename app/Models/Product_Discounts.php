<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Discounts extends Model
{
    use HasFactory;
    protected $table = 'product_discounts';
    protected $fillable = ['sku', 'discount_id'];
}
