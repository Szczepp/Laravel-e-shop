<?php

namespace App\Models;

use App\Scopes\AvailableScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
      'title',
      'description',
      'price',
      'stock',
      'status',
    ];

    protected $with = [
        'images'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new AvailableScope());

        static::updated(function ($product) {
            if ($product->stock == 0 && $product->status == 'available') {
                $product->status = 'unavailable';
                $product->save();
            }
        });
    }

    public function carts()
    {
        return $this->morphedByMany(Cart::class, 'productable')->withPivot('quantity');
    }

    public function orders()
    {
        return $this->morphedByMany(Order::class, 'productable')->withPivot('quantity');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function getTotalAttribute()
    {
        return $this->price * $this->pivot->quantity;
    }
}
