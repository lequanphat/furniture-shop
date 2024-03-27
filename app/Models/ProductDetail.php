<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;
    protected $table = 'product_details';
    protected $keyType = 'string';
    protected $primaryKey = 'sku';
    protected $fillable = ['sku', 'product_id', 'name', 'description', 'color_id', 'size', 'original_price', 'warranty_month', 'quantities', 'is_deleted'];

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'sku');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }
}
