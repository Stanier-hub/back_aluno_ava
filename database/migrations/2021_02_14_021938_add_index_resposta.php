<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexResposta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resposta', function (Blueprint $table) {   
            $table->index('texto');
            $table->index('correta');
            $table->index('status');
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
        Schema::table('resposta', function (Blueprint $table) {
            $table->dropIndex('resposta_texto_index');
            $table->dropIndex('resposta_correta_index');
            $table->dropIndex('resposta_status_index');
            $table->dropIndex('resposta_pergunta_id_index');
        });
    }
}
