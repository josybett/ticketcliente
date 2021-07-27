<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'client';

    protected $fillable = [
        'id',
        'identification',
        'name',
        'created_at',
        'updated_at'
    ];
}