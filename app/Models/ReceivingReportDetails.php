<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivingReportDetails extends Model
{
    use HasFactory;
    protected $table = 'receiving_report_details';
    protected $primaryKey = ['receiving_report_id', 'sku'];
    protected $fillable = ['receiving_report_id', 'sku', 'quantities', 'unit_price'];
}
