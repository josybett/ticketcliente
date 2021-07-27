<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatQueues extends Model
{
    use SoftDeletes;

    protected $table = 'cat_queues';

    protected $fillable = [
        'id',
        'name',
        'time_queues',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
