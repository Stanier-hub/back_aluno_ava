<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerguntaAvaliacao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pergunta_avaliacao', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descricao','255');
            $table->timestamps();
            $table->integer('status');
            $table->foreignId('avaliacao_id')->constrained('avaliacao');
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
        Schema::dropIfExists('pergunta_avaliacao');
    }
}
