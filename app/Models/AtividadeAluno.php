<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AtividadeAluno extends Model
{
    use HasFactory;

    protected $table = 'pergunta_avaliacao';

    protected $fillable = ['id','nome', 'descricao', 'status','oferta_disciplina_turma'];



    static function getPerguntasAvaliacao($id_avaliacao)
    {
        return  DB::table('pergunta_avaliacao') 
     
        ->join('pergunta','pergunta.id','pergunta_avaliacao.pergunta_id')
        ->join('resposta','resposta.pergunta_id','pergunta_avaliacao.pergunta_id')
        ->where('pergunta_avaliacao.avaliacao_id',$id_avaliacao)
        ->where('pergunta_avaliacao.status',1)
        ->select('pergunta_avaliacao.pergunta_id','pergunta.enunciado','resposta.texto')
        ->get();
    }
    static function getAtividades($oferta_disciplina_turma)
    {
        $data = DB::table('avaliacao') 
 ->join('tipo_avaliacao','tipo_avaliacao.id','avaliacao.tipo_avaliacao_id')
        ->where('avaliacao.oferta_disciplina_turma_id',$oferta_disciplina_turma)
        ->select('avaliacao.id as avaliacao_id','tipo_avaliacao.nome','tipo_avaliacao.descricao','avaliacao.status','tempo_minutos','quantidade_perguntas',
        'data_inicio','data_fim','hora_inicio','hora_fim')
        ->get();

        foreach($data as $item){
            $item->quantidade_perguntas =   20*$item->quantidade_perguntas;
        }
return $data;
    
    }
    
    

    
}
