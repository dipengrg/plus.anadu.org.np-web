<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    // The attributes that are mass assignable.
    protected $fillable = [
        'user_id',
        'title',
        'name',
        'gender',
        'dob',
        'photo',
        'address',
        'current_residence',
        'status'
    ];

    // Belongs to user
    public function user()
    {
        return $this->BelongsTo(User::class);
    }

    // Define relationship with Tenure model through tenure_members pivot table
    public function tenures()
    {
        return $this->belongsToMany(Tenure::class, 'tenure_members')
                    ->withPivot('designation')
                    ->withTimestamps();
    }

    // The attributes that should be cast to native types.
    protected function casts(): array
    {
        return [
            'registered_at' => 'datetime',
            'status' => 'boolean',
        ];
    }
}
