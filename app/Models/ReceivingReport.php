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

    public function receiving_details()
    {
        return $this->hasMany(ReceivingReportDetails::class, 'receiving_report_id');
    }
    public function employee()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
   
    
}
