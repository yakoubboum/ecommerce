<?php

namespace App\Models;

use App\Models\Image;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Product extends Model
{
    use Translatable;
    use HasFactory;
    public $translatedAttributes = ['name', 'details'];
    protected $fillable = [
        'name',
        'section_id',
        'price',
        'discount',
        'delivery_price',
        'delivery_time',
        'details',
        'rating',
        'number_of_ratings',
        'number_of_sales',
        'quantity',
        'specifications',
    ];

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
