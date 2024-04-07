<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $table = 'discounts';
    protected $primaryKey = 'discount_id';
    protected $fillable = ['title', 'description', 'percentage', 'amount', 'start_date', 'end_date', 'is_active'];

    public function productDetail()
    {
        return $this->hasMany(ProductDiscounts::class,'discount_id');
    }
}
