<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivingReportDetails extends Model
{
    use HasFactory;
    protected $table = 'receiving_report_details';
    protected $fillable = ['receiving_report_id', 'sku', 'quantities', 'unit_price'];
    public function detailed_product()
    {
        return $this->belongsTo(ProductDetail::class, 'sku');
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
