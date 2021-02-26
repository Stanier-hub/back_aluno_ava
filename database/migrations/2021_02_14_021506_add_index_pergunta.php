<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexPergunta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pergunta', function (Blueprint $table) {
            $table->index('enunciado');
            $table->index('explicacao');
            $table->index('descricao'); 
          
            $table->index('status');
            $table->index('tipo');
            $table->index('nivel');
            $table->index('pontos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pergunta', function (Blueprint $table) {
            $table->dropIndex('pergunta_enunciado_index');
            $table->dropIndex('pergunta_explicacao_index');
            $table->dropIndex('pergunta_descricao_index');  
            $table->dropIndex('pergunta_status_index');
            $table->dropIndex('pergunta_tipo_index');
            $table->dropIndex('pergunta_nivel_index');
            $table->dropIndex('pergunta_pontos_index');
        });
    }
}
