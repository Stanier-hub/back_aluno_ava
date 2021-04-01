<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndextentativa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ead_tentativa', function (Blueprint $table) {
            $table->index('nota');
            $table->index('descricao'); 
            $table->index('status'); 
            $table->index('tempo');
            $table->index('data_incio');
            $table->index('avaliacao_id');
            $table->index('oferta_disciplina_turma_id');
            $table->index('usuario_id');
            $table->index('semestre_letivo_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ead_tentativa', function (Blueprint $table) {
            $table->dropIndex('ead_tentativa_nota_index');
            $table->dropIndex('ead_tentativa_descricao_index'); 
            $table->dropIndex('ead_tentativa_status_index'); 
            $table->dropIndex('ead_tentativa_tempo_index');
            $table->dropIndex('ead_tentativa_data_incio_index');
            $table->dropIndex('ead_tentativa_avaliacao_id_index');
            $table->dropIndex('ead_tentativa_oferta_disciplina_turma_id_index');
            $table->dropIndex('ead_tentativa_usuario_id_index');
            $table->dropIndex('ead_tentativa_semestre_letivo_id_index');

        });
    }
}
