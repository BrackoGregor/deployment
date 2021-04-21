<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_Role extends Model
{
    use SoftDeletes;

    protected $table = 'users_roles';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'role'
    ];

    use HasFactory;
}
