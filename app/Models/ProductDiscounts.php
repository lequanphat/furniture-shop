<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class   ProductDiscounts extends Model
{
    use HasFactory;
    protected $table = 'product_discounts';
    protected $fillable = ['sku', 'discount_id'];

    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }

    public function sku()
    {
        return $this->belongsTo(ProductDetail::class, 'sku');
    }
    public function sku_PL()
    {
        return $this->hasMany(ProductDetail::class, 'sku');
    }
    public function discount_dc()
    {
        return $this->hasMany(Discount::class, 'discount_id');
    }
   
}
