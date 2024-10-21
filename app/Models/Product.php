<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'image', 'price', 'quantity'];

    public function pharmacies()
    {
        return $this->belongsToMany(Pharmacy::class,'product_pharmacy')
            ->withPivot('price') 
            ->withTimestamps();

    }

    public function getImageUrlAttribute()
    {
        if(Str::startsWith($this->image,['http://','https://']))
            {
                return $this->image; 
            }
        return asset('storage/' . $this->image);
        
    }
}
