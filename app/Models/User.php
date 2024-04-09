<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles;
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $fillable = ['email', 'password', 'first_name', 'last_name', 'avatar', 'birth_date', 'gender', 'is_staff', 'is_verified', 'is_active'];
    protected $casts = [
        'gender' => 'boolean',
    ];
    public function full_name()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    public function getAuthIdentifierName()
    {
        return 'user_id';
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }
    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id');
    }
    public function default_address()
    {
        return $this->hasOne(Address::class, 'user_id')->where('is_default', 1);;
    }
}
