<?php

namespace App;
use App\Product;
use App\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use Notifiable;
    protected $fillable = [
        'order_by','name', 'phone', 'address', 'product_id', 'quantity', 'total_price', 'payment_method', 'payment_status', 'delivery_status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'order_by');
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
