<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
// use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\Models\Lives;



class LivesController extends Controller
{
    protected $servico;
    public function __construct(Lives $servico)
    {
        $this->user = Auth::user();
        $this->headers = $headers = \Request::header();
        $this->servico= $servico;

    }

   public function createLives(Request $request){


    $this->servico->nome = $request->nome;
    $this->servico->created_at  = date('Y-m-d H:i:s');
    $this->servico->updated_at = null ;
    $this->servico->url = $request->url;
    $this->servico->descricao = $request->descricao;
    $this->servico->status = 1;
    $this->servico->oferta_disciplina_turma_id = $request->oferta_disciplina_turma_id;
    $this->servico->data_inicio =  date('Y-m-d', strtotime($request->data_inicio));
    $this->servico->hora_inicio = $request->hora_inicio;
    $this->servico->hora_fim = $request->hora_fim;
    $this->servico->data_fim = date('Y-m-d)', strtotime($request->data_fim));
    
    
    $this->servico->save();

    return response()->json('Live cadastrada com sucesso',200);
   }
   


   public function getLives($oferta_disciplina_turma_id){
    $data = $this->servico
    ->join('oferta_disciplina_turma','oferta_disciplina_turma.id','lives.oferta_disciplina_turma_id')   
    ->join('disciplina_grade_curricular','disciplina_grade_curricular.id','oferta_disciplina_turma.disciplina_grade_curricular_id')
    ->join('disciplina','disciplina.id','disciplina_grade_curricular.disciplina_id')
    ->where('oferta_disciplina_turma_id',$oferta_disciplina_turma_id)
    ->select('disciplina.nome as nome_disciplina','lives.id','lives.nome as titulo','lives.descricao','lives.data_inicio','lives.data_fim','hora_fim','lives.hora_inicio','lives.url as link')
    ->where('data_fim',date('Y-m-d'))
    ->get();
    $newarray=[];
    foreach($data as $element){
        if(date('Y-m-d H:i:s') > date('Y-m-d H:i:s', strtotime($element->data_fim.' '.$element->data_fim)))
        {
            $status = 'Encerrado';
        }
      
     $newarray[]= [
     'nome_disciplina'=>$element->nome_disciplina,
      'link' => $element->link,
     'id'=>$element->id,
     'titulo'=>$element->titulo,
     'data_inicio' => date('d/m/Y H:i:s', strtotime($element->data_inicio.' '.$element->hora_inicio)),
     'data_fim' =>date('d/m/Y H:i:s', strtotime($element->data_fim.' '.$element->hora_fim)),
     'descricao'=>$element->descricao 
    ];
    }
 
 return response()->json($newarray,200);
 
 }

}