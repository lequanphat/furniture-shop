<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'percentage', 'amount', 'start_date', 'end_date', 'is_active'];
}
