<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPharmacy extends Model
{
    use HasFactory;
    protected $table = 'product_pharmacy'; 

    protected $fillable = ['product_id', 'pharmacy_id', 'price'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }
}
