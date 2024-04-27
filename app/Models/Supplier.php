<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'suppliers';
    protected $primaryKey = 'supplier_id';
    protected $fillable = ['name', 'description', 'address', 'phone_number'];

    public function receivingReports()
    {
        return $this->hasMany(ReceivingReport::class, 'supplier_id');
    }
}
