<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id',
        'category',
        'name',
        'description',
        'price',
        'quantity',
        'status',
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products')->withPivot('quantity');
    }
    
     public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
}
