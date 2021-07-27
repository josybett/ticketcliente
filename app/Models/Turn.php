<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Turn extends Model
{
    use SoftDeletes;

    protected $table = 'turn';

    protected $fillable = [
        'id',
        'client_id',
        'cat_queues_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
