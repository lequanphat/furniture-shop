<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDiscounts extends Model
{
    use HasFactory;
    protected $table = 'product_discounts';
    protected $fillable = ['sku', 'discount_id'];

    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }
}
