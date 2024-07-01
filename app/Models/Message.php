<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['sender', 'message','receiver'];

    public function user()
    {
        return $this->belongsTo(User::class); // Replace with your user model
    }
}
