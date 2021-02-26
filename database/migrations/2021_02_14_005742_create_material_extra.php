<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialExtra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_extra', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome','255');
            $table->timestamps();
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
        Schema::dropIfExists('materia_extra');
    }
}
