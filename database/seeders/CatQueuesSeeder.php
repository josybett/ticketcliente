<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CatQueues;

class CatQueuesSeeder extends Seeder
{

    /**
     * Array del catálogo de Colas
     */
    protected $queues = [
        [
            'name' => 'Cola 1',
            'time_queues' => '00:02:00'
        ],[
            'name' => 'Cola 2',
            'time_queues' => '00:03:00'
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->queues as $q) :
            CatQueues::create(
                [
                    'name' => $q['name'],
                    'time_queues' => $q['time_queues']
                ]
            );
        endforeach;
    }
}
