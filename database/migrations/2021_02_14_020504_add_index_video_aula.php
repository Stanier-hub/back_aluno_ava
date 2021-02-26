<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexVideoAula extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('video_aula', function (Blueprint $table) {
      
            $table->index('nome');
            $table->index('url');
            $table->index('descricao');
            $table->index('status');   
            $table->index('oferta_disciplina_turma_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('video_aula', function (Blueprint $table) {
            $table->dropIndex('video_aula_nome_index');
            $table->dropIndex('video_aula_url_index');
            $table->dropIndex('video_aula_descricao_index');
            $table->dropIndex('video_aula_status_index');  
            $table->dropIndex('video_aula_oferta_disciplina_turma_id_index');
        });
    }
}
