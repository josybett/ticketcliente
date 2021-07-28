<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Turn;

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

    public function turns()
    {
       return $this->hasMany(Turn::class, 'cat_queues_id');
    }

}
