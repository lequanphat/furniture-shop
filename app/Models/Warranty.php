<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warranty extends Model
{
    use HasFactory;
    protected $table = 'warranties';
    protected $primaryKey = 'warranty_id';
    protected $fillable = ['order_id', 'sku', 'start_date', 'end_date', 'description'];

    public function product_detail(){
        return $this->belongsTo(ProductDetail::class, 'sku');
    }
    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }
    public function is_active()
    {
        $today = date('Y-m-d');
        return $today >= $this->start_date && $today <= $this->end_date;
    }
}
