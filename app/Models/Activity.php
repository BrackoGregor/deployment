<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title',
        'start_time',
        'end_time',
        'comment',
        'id_assignments'
    ];

    public function assignment(): HasMany
    {
        return $this->hasMany(Assignment::class, 'id_assignments', 'id');
    }

    use HasFactory;
}

