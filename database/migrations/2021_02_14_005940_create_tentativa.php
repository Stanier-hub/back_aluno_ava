<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTentativa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ead_tentativa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nota','255');
            $table->string('descricao','255')->nullable();
            $table->timestamps();    
            $table->integer('status'); 
            $table->integer('usuario_id')->constrained('usuario'); 
            $table->string('tempo','45')->nullable();
            $table->dateTime('data_incio')->nullable();
            $table->foreignId('avaliacao_id')->constrained('avaliacao');
            $table->foreignId('oferta_disciplina_turma_id')->constrained('oferta_disciplina_turma');
            $table->foreignId('semestre_letivo_id')->constrained('semestre_letivo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tentativa');
    }
}
