<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexTentativa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tentativa', function (Blueprint $table) {
            $table->index('nota');
            $table->index('descricao'); 
            $table->index('status'); 
            $table->index('tempo');
            $table->index('data_incio');
            $table->index('avaliacao_id');
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
        Schema::table('tentativa', function (Blueprint $table) {
            $table->dropIndex('tentativa_nota_index');
            $table->dropIndex('tentativa_descricao_index'); 
            $table->dropIndex('tentativa_status_index'); 
            $table->dropIndex('tentativa_tempo_index');
            $table->dropIndex('tentativa_data_incio_index');
            $table->dropIndex('tentativa_avaliacao_id_index');
            $table->dropIndex('tentativa_oferta_disciplina_turma_id_index');
        });
    }
}
