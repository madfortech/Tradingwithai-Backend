<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'price',
        'stripe_price_id',
        'ai_credits',
        
        'active',
        'description',
        'features',
        'is_active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'is_active' => 'boolean',
        'features' => 'array', 
        
    ];
    
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
