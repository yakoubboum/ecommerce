<?php

namespace App\Models;

use App\Models\Product;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    use Translatable; // 2. To add translation methods
    protected $fillable =['name'];
    // 3. To define which attributes needs to be translated
    public $translatedAttributes = ['name'];
    use HasFactory;

    public function products(){
        return $this->hasMany(Product::class);
    }
}
