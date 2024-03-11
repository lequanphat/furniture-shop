<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'order_details';
    protected $primaryKey = ['order_id', 'sku'];
    protected $fillable = ['order_id', 'sku', 'quantities', 'unit_price'];
}
