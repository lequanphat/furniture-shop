<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivingReport extends Model
{
    use HasFactory;
    protected $table = 'receiving_reports';
    protected $primaryKey = 'receiving_report_id';
    protected $fillable = ['total_price', 'supplier_id', 'created_by'];
}
