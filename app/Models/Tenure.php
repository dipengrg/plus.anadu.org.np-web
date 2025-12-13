<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenure extends Model
{
    // Define relationship with Member model through tenure_members pivot table
    public function members()
    {
        return $this->belongsToMany(Member::class, 'tenure_members')
                    ->withPivot('designation')
                    ->withTimestamps();
    }
}
