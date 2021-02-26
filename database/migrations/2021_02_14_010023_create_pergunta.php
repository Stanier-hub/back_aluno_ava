<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePergunta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pergunta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('enunciado','255')->nullable();
            $table->string('explicacao','255');
            $table->string('descricao','255'); 
            $table->timestamps();
            $table->integer('status')->nullable();
            $table->integer('tipo')->nullable();
            $table->integer('nivel')->nullable();
            $table->integer('pontos');
            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pergunta');
    }
}
