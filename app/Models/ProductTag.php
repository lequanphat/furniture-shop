<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
    use HasFactory;
    protected $table = 'product_tags';
    protected $primaryKey = ['product_id', 'tag_id'];
    protected $fillable = ['product_id', 'tag_id'];
}
