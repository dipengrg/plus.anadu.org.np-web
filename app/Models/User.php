<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasApiTokens;

    // The attributes that are mass assignable.
    protected $fillable = [
        'role',
        'phone',
        'otp',
        'otp_created_at',
        'status'
    ];

    // The attributes that should be hidden for arrays.
    protected $hidden = [
        'otp',
        'otp_created_at'
    ];

    // Has many membership
    public function members()
    {
        return $this->hasMany(Member::class);
    }

    // The attributes that should be cast to native types.
    protected function casts(): array
    {
        return [
            'otp_created_at' => 'datetime',
            'status' => 'boolean',
        ];
    }
}
