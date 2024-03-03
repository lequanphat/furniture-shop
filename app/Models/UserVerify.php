<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVerify extends Model
{
    use HasFactory;
    protected $primaryKey = 'user_id';
    protected $fillable = ['user_id', 'otp', 'expired_time'];
}
