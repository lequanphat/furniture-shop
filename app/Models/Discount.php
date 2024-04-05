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

    public function is_currently_active()
    {
        $today = date('Y-m-d');
        return $this->is_active && $today >= $this->start_date && $today <= $this->end_date;
    }
}
