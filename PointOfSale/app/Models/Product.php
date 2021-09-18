<?php

namespace App\Models;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'product_category_id',
        'retail_price',
        'whole_sale_price',
        'business_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
