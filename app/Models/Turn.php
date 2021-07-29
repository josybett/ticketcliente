<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CatQueues;
use App\Models\Client;

class Turn extends Model
{
    use SoftDeletes;

    protected $table = 'turn';

    protected $fillable = [
        'id',
        'client_id',
        'cat_queues_id',
        'ticket',
        'turn_at',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function catqueues()
    {
       return $this->belongsTo(CatQueues::class, 'cat_queues_id');
    }

    public function client()
    {
       return $this->belongsTo(Client::class, 'client_id');
    }
}
