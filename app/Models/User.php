<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class User extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = ['email', 'password', 'first_name', 'last_name', 'birth_date', 'gender', 'is_staff', 'is_verified', 'is_active'];
}
