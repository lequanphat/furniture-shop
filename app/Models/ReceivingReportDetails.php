<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivingReportDetails extends Model
{
    use HasFactory;
    protected $fillable = ['receiving_report_id', 'sku', 'quantities', 'unit_price'];
}
