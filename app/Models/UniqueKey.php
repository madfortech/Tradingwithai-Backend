<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniqueKey extends Model
{

    protected $fillable = [
        'user_id',
        'name',
        'key_hash',
        'last_used_at',
        'revoked_at',
    ];

    protected $casts = [
        'last_used_at' => 'datetime',
        'revoked_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
