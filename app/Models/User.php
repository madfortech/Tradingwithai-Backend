<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Spatie\Permission\Traits\HasRoles;


#[Fillable(['name', 'email', 'password', 'plan_id', 'ai_credits', 'daily_ai_credits_used', 'credits_reset_at', 'daily_reset_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */

    use HasFactory, Notifiable, Billable, HasRoles;

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function uniqueKey()
    {
        return $this->hasOne(UniqueKey::class);
    }
  

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'credits_reset_at' => 'datetime',
            'daily_reset_at' => 'datetime',
        ];
    }
}
