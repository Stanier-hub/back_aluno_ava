<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AtividadeAluno extends Model
{
    use HasFactory;

    protected $table = 'ead_pergunta_avaliacao';

    protected $fillable = ['id','ead_pergunta_id', 'avaliacao_id', 'status'];



    static function getPerguntasAvaliacao($id_avaliacao)
    {
        return  DB::table('ead_pergunta_avaliacao') 
     
        ->join('ead_pergunta','ead_pergunta.id','ead_pergunta_avaliacao.ead_pergunta_id')
        ->join('ead_resposta','ead_resposta.ead_pergunta_id','ead_pergunta.id')
        ->where('ead_pergunta_avaliacao.avaliacao_id',$id_avaliacao)
        ->where('ead_pergunta_avaliacao.status',1)
        ->select('ead_resposta.id as ead_resposta_id','ead_pergunta_avaliacao.ead_pergunta_id','ead_pergunta.titulo as titulo_pergunta','ead_resposta.titulo as titulo_resposta')
        ->get();
    }

    static function getAtividades($oferta_disciplina_turma)
    {
        date_default_timezone_set('America/Asuncion');
        // return date('H:i:s');
        $data = DB::table('ead_avaliacao_oferta_disciplina') 
        ->join('avaliacao','avaliacao.id','ead_avaliacao_oferta_disciplina.avaliacao_id')
        ->join('tipo_avaliacao','tipo_avaliacao.id','avaliacao.tipo_avaliacao_id')
        ->where('ead_avaliacao_oferta_disciplina.oferta_disciplina_turma_id',$oferta_disciplina_turma)
        // ->where('ead_avaliacao_oferta_disciplina.data_inicio','<=',date('Y-m-d'))
        // ->where('ead_avaliacao_oferta_disciplina.data_fim','>=',date('Y-m-d'))
        // ->where('ead_avaliacao_oferta_disciplina.hora_inicio','<=',date('H:i:s'))
        // ->where('ead_avaliacao_oferta_disciplina.hora_fim','>=',date('H:i:s'))
        ->select('ead_avaliacao_oferta_disciplina.id as ead_avaliacao_oferta_disciplina_id','avaliacao.id as avaliacao_id','tipo_avaliacao.nome','tipo_avaliacao.descricao','tempo_minutos','quantidade_perguntas',
        'ead_avaliacao_oferta_disciplina.data_inicio','ead_avaliacao_oferta_disciplina.data_fim','ead_avaliacao_oferta_disciplina.hora_inicio','ead_avaliacao_oferta_disciplina.hora_fim')
        ->get();

        // return $data;
        $id_avaliacao =0;
        foreach($data as $item){
            $id_avaliacao = $item->avaliacao_id;
            $item->quantidade_perguntas =   20*$item->quantidade_perguntas;
        }

     $arrayPerguntas =   DB::table('ead_pergunta_avaliacao') 
     
        ->join('ead_pergunta','ead_pergunta.id','ead_pergunta_avaliacao.ead_pergunta_id')
        ->where('ead_pergunta_avaliacao.avaliacao_id',$id_avaliacao)
        ->where('ead_pergunta_avaliacao.status',1)
        ->select('ead_pergunta.titulo as titulo_pergunta')
        ->get();

        foreach($data as $item){

    $item->quantidade_perguntas_real = 20*count($arrayPerguntas);


        }
return $data;
    
    }
    
    

    
}
