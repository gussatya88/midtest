<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'detail_packages', 'id_product', 'id_package')->withPivot('quantity');
    }
}