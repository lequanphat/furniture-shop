<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    protected $fillable = ['name', 'description', 'category_id', 'amount_sold', 'brand_id', 'is_deleted'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public function detailed_products()
    {
        return $this->hasMany(ProductDetail::class, 'product_id');
    }
    public function product_tags()
    {
        return $this->hasMany(ProductTag::class, 'product_id');
    }
}
