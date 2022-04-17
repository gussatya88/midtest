<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function products()
    {
        return $this->belongsToMany(Product::class, 'detail_packages', 'id_package', 'id_product')->withPivot('quantity');
    }

    public function getNormalPriceAttribute($value)
    {
        return number_format($value, 0, ',', '.');
    }

    public function getEndPriceAttribute($value)
    {
        return number_format($value, 0, ',', '.');
    }
}