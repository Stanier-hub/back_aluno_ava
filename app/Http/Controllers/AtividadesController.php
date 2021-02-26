<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
// use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\Models\AtividadeAluno;
use PhpParser\Node\Stmt\Foreach_;

class AtividadesController extends Controller
{
    protected $atividade;
    public function __construct(AtividadeAluno $atividade)
    {
        $this->user = Auth::user();
        $this->headers = $headers = \Request::header();
        $this->atividade = $atividade;
    }



    public function getAtividades($id_disciplina_oferta_turma){


$data = $this->atividade->getAtividades($id_disciplina_oferta_turma);
foreach($data as $element)
switch($element->status){
    case 1:
        $status='pendente';
        $corstatus='warning';
break;
    }
$array[] = [
    'quantidade_perguntas' =>$element->quantidade_perguntas,
    'avaliacao_id' =>$element->avaliacao_id,
    'titulo' => $element->nome,
    'descricao' =>'Atividade encerara em '.$element->data_fim.' '.$element->hora_fim ,
    'data_inicio'  => $element->data_inicio,
    'status' => $status,
    'corstatus'=>$corstatus

];

return response()->json($array,200);

    }


    public function getAtividadesPerguntas($id_avaliacao){
        $data = $this->atividade->getPerguntasAvaliacao($id_avaliacao);
        // return response()->json($data,200);
$array=[];

        foreach($data as $item){
            $resposta[$item->pergunta_id][] = $item->texto;
            $array[$item->pergunta_id] =['n'=>count($array),'pergunta'=>$item->enunciado,'resposta'=>$resposta[$item->pergunta_id]];
        
        }
        return response()->json((object)$array,200);

    }
}