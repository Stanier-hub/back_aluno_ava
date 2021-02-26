<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResposta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resposta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('texto','500');
            $table->integer('correta');
            $table->timestamps();
            $table->integer('status');
            $table->foreignId('pergunta_id')->constrained('pergunta');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resposta');
    }
}
