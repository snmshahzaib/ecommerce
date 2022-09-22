<?php

namespace App;
use App\User;
use App\Product;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['created_by','title'];
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function products(){
        return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id');
    }
}
