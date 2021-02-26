<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexMaterial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('material', function (Blueprint $table) {       
            $table->index('nome');
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
        Schema::table('material', function (Blueprint $table) {
            $table->dropIndex('material_nome_index');
            $table->dropIndex('material_descricao_index');
            $table->dropIndex('material_status_index');
            $table->dropIndex('material_oferta_disciplina_turma_id_index'); 
        });
    }
}
