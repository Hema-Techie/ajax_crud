<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['product_name', 'quantity', 'status', 'category_id','image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
