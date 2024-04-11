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

    public function getSkuForDiscountId($discountId)
    {
//        return $this->where('discount_id', $discountId)->first()->sku;
        return $this->where('discount_id', $discountId)->pluck('sku');
    }

}
