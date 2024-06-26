<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'address';
    protected $primaryKey = 'address_id';
    protected $fillable = ['user_id', 'receiver_name', 'address', 'phone_number', 'is_default'];
}
