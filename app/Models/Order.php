<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    protected $fillable = ['total_price', 'is_paid', 'status', 'receiver_name', 'address', 'phone_number', 'note', 'customer_id', 'created_by'];    //mảng các trường có thể tác động

    // status: 0: unconfirmed, 1: confirmed, 2: in transit, 3: delivered, 4: canceled
    public function get_status()
    {
        switch ($this->status) {
            case 0:
                return 'Awaiting Confirm';
            case 1:
                return 'Confirmed';
            case 2:
                return 'In transit';
            case 3:
                return 'Delivered';
            case 4:
                return 'Canceled';
            default:
                return 'Unknown';
        }
    }
    public function get_is_paid()
    {
        return $this->is_paid ? 'Payment Received' : 'Pending Payment';
    }
    public function order_details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
    public function employee()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function howmanydaysago()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }
    public function money_type()
    {
        $money = number_format($this->total_price, 0, '.', ',');
        return $money;
    }
}
