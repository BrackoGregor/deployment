<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_Assignment extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id_users',
        'id_assignments'
    ];

    public function user(): HasMany
    {
        return $this->hasMany(User::class, 'id_clients', 'id');
    }

    public function assignment(): HasMany
    {
        return $this->hasMany(Assignment::class, 'id_assignments', 'id');
    }
}
