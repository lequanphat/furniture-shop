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
}
