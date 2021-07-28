<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turn', function (Blueprint $table) {
            $table->bigIncrements('id')->comment = 'Llave primaria autoincrementable';
            $table->unsignedInteger('client_id')->comment = 'FK de tabla client';
            $table->unsignedInteger('cat_queues_id')->comment = 'FK de tabla cat_queues';
            $table->unsignedInteger('ticket')->comment = 'Número del Ticket que corresponde a cada cola';
            $table->timestamps();
            $table->softDeletes();

            /* FOREIGN KEYS*/
            /* CLIENT */
			$table->foreign('client_id')->references('id')->on('client');
            /* QUEUES */
			$table->foreign('cat_queues_id')->references('id')->on('cat_queues');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turn');
    }
}
