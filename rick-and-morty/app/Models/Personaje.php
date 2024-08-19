<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personaje extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'name', 
        'status', 
        'species', 
        'type', 
        'gender', 
        'origin', 
        'location', 
        'image', 
        'url', 
        'episode', 
        'created',
    ];
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'favoritos');
    }
}
