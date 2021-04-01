<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
// use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\Models\AtividadeAluno;
use App\Models\Tentativa;
use App\Models\RespostaAluno;
use PhpParser\Node\Stmt\Foreach_;

class AtividadesController extends Controller
{
    protected $atividade;
    protected $tentativa;
    public function __construct(AtividadeAluno $atividade,tentativa $tentativa)
    {
        $this->user = Auth::user();
        $this->headers = $headers = \Request::header();
        $this->atividade = $atividade;
        $this->tentativa = $tentativa;
    }



    public function getAtividades($id_disciplina_oferta_turma){


     $data = $this->atividade->getAtividades($id_disciplina_oferta_turma);
     // if($data['resposta'] == 'negativo'){
     //     return response()->json('Perguntas insuficiantes',200);
     // }
    //  return $data;
 if(!isset($data)){
     return $data;
 }



$tentativa_id='';
        foreach($data as $element){
            $tentativa_aluno =    $this->tentativa
    
            ->where('avaliacao_id',$element->avaliacao_id)
            ->where('usuario_id',$this->user->id)->first();
            if(!isset($tentativa_aluno->id))
            {
                $tentativa_id = '';
                $status='pendente';
                $corstatus='warning';
            }else{
                $tentativa_id = $tentativa_aluno->id;
            switch($tentativa_aluno->status){
            case 1:
             $status='pendente';
             $corstatus='warning';
            break;

            case 2:
            $status ='feito';
            $corstatus = 'success';
            break; 
            } 
        }
        $array[] = [

        'tentativa_id' =>$tentativa_id,
        'quantidade_perguntas_real' =>$element->quantidade_perguntas_real,
        'quantidade_perguntas' =>$element->quantidade_perguntas,
        'avaliacao_id' =>$element->avaliacao_id,
        'titulo' => $element->nome,
        'descricao' =>'Atividade encerara em '.$element->data_fim.' '.$element->hora_fim ,
        'data_inicio'  => $element->data_inicio,
        'status' => $status,
        'corstatus'=>$corstatus

        ];  
    }

        return response()->json($array,200);

    }


    public function getAtividadesPerguntas($id_avaliacao,$oferta_disciplina_turma_id,$semetre_letivo_id){

        $tentativa_aluno =    $this->tentativa
        ->where('semestre_letivo_id',$semetre_letivo_id)
        ->where('avaliacao_id',$id_avaliacao)
        ->where('usuario_id',$this->user->id)->first();

   
       if(!isset($tentativa_aluno)){
        $new_tentativa =[
            'nota'=> '',
            'descricao'=> '',
            'status'=> 1,
            'tempo'=>'',
            'usuario_id'=> $this->user->id,
            'created'=> date('Y-m-d H:i:s'),
            'oferta_disciplina_turma_id'=> $oferta_disciplina_turma_id,
            'avaliacao_id'=>$id_avaliacao,
            'semestre_letivo_id'=> $semetre_letivo_id,
        ];
        $tentativa_aluno = Tentativa::create($new_tentativa);
      }

        $data = $this->atividade->getPerguntasAvaliacao($id_avaliacao);
        // return response()->json($data,200);
        $array=[];

        foreach($data as $item){
            
            $resposta[$item->ead_pergunta_id][] = ['enunciado'=>$item->titulo_pergunta,'titulo'=>$item->titulo_resposta,'id'=>$item->ead_resposta_id];
            $array[$item->ead_pergunta_id] =['tentativa_id'=>$tentativa_aluno->id,'pergunta_id'=>$item->ead_pergunta_id,'n'=>count($array),'pergunta'=>$item->titulo_pergunta,'resposta'=>$resposta[$item->ead_pergunta_id]];
        
        }
        $a=[];
        $i=0;
        foreach($array as $element){
            $i++;
        $a[$i]= $element;
        }
        return response()->json($a,200);

    }
}