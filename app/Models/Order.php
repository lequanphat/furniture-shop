<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    protected $fillable = ['total_price', 'is_paid', 'status', 'receiver_name', 'address', 'phone_number', 'customer_id', 'created_by'];    //mảng các trường có thể tác động

    // status: 0: unconfirmed, 1: confirmed, 2: in transit, 3: delivered, 4: canceled

}
