<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;
    protected $table = 'product_details';
    protected $fillable = ['sku', 'product_id', 'name', 'description', 'color', 'size', 'original_price', 'warranty_month', 'quantities', 'is_deleted'];
}
