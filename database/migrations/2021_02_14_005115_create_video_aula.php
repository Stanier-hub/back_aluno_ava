<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoAula extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_aula', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome','255');
            $table->timestamps();
            $table->string('url','255')->nullable();
            $table->string('descricao','255')->nullable();
            $table->integer('status');  
            $table->foreignId('oferta_disciplina_turma_id')->constrained('oferta_disciplina_turma');          
    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_aula');
    }
}
