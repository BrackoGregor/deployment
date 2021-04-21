<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    protected  $guarded = [];

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'work_description',
        'developer_description',
        'id_clients',
        'id_statuses'
    ];

    use HasFactory;

    public function client()
    {
        return $this->hasOne(Client::class, 'id_clients', 'id');
    }

    public function status()
    {
        return $this->hasOne(Status::class,'id_statuses', 'id');
    }
}
