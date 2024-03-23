<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';    //tên bảng trong csdl
    protected $primaryKey = 'order_id';     //tên khóa chính trong csdl
    protected $fillable = ['total_price', 'is_paid', 'status', 'receiver_name', 'address', 'phone_number', 'customer_id', 'created_by'];    //mảng các trường có thể tác động

    /*public function customer()
    {
        return $this->belongsTo(Category::class, 'customer_id');
    }
    public function create_by()
    {
        return $this->belongsTo(Brand::class, 'create_by');
    }*/

}
