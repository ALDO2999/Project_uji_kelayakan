<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterType extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'letter_code',
        'name_type',
    ];

    public function letterType(){
        return $this->hasMany(Letter::class, 'letter_type_id', 'letter_code');
    }

    
}
