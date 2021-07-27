<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_queues', function (Blueprint $table) {
            $table->bigIncrements('id')->comment = 'Llave primaria autoincrementable';
            $table->string('name')->comment = 'Nombre de cola';
            $table->time('time_queues')->comment = 'Tiempo en minutos de la cola';
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cat_queues');
    }
}
