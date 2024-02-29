<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Translatable;

class Section extends Model
{
    use HasFactory;
    use Translatable; // 2. To add translation methods
    protected $fillable =['name'];
    // 3. To define which attributes needs to be translated
    public $translatedAttributes = ['name'];
    use HasFactory;
}
