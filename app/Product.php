<?php

namespace App;
use App\Image;
use App\Order;
use App\Category;
use App\Comment;


use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['created_by','name','image', 'brand', 'price', 'discription'];

    public function images(){
        return $this->hasMany(Image::class);
    }
    public function categories(){
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }
    public function orders(){
        return $this->hasMany(Order::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }
}
