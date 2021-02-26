<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexPerguntaAvaliacao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pergunta_avaliacao', function (Blueprint $table) {
            $table->index('descricao');
            $table->index('status');
            $table->index('avaliacao_id');
            $table->index('pergunta_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pergunta_avaliacao', function (Blueprint $table) {
            $table->dropIndex('pergunta_avaliacao_descricao_index');
            $table->dropIndex('pergunta_avaliacao_status_index');
            $table->dropIndex('pergunta_avaliacao_avaliacao_id_index');
            $table->dropIndex('pergunta_avaliacao_pergunta_id_index');
        });
    }
}
