<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
// use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\Models\AtividadeAluno;
use App\Models\Tentativa;
use App\Models\RespostaPerguntaAluno;
use PhpParser\Node\Stmt\Foreach_;
use DB;
class RespostaPerguntaController extends Controller
{
    protected $atividade;
    protected $tentativa;
    protected $respostaaluno;
    public function __construct(AtividadeAluno $atividade,tentativa $tentativa,RespostaPerguntaAluno $respostaaluno)
    {
        $this->user = Auth::user();
        $this->headers = $headers = \Request::header();
        $this->atividade = $atividade;
        $this->tentativa = $tentativa;
        $this->respostaaluno = $respostaaluno;


    }

  public function store(Request $request){

    $prova = $request->prova;
    $nota=0;
    $ids_res=[];
    try {
        DB::beginTransaction();
    foreach($request->respostas  as $key => $item){
        
    
        if(isset($item)){
            // return $item;
            $a = [
                'ead_resposta_id'=>$item,
                'ead_pergunta_id'=>$key,
                'status'=>1,
                'avaliacao_id'=>$prova['avaliacao_id'],
                'oferta_disciplina_turma_id'=>$prova['oferta_disciplina_turma_id'],
                'semestre_oferta_disciplina_id'=>$prova['semestre_oferta_disciplina_id'],
                'usuario_id'=>  $this->user->id
            ];
            $ids_res[]=  RespostaPerguntaAluno::create($a);
            $a=[];
        }
    }

    
 $corretas=   DB::table('ead_resposta_aluno')


 ->join('ead_resposta','ead_resposta.id','ead_resposta_aluno.ead_resposta_id')
    ->where('ead_resposta_aluno.usuario_id',$this->user->id)
    ->where('ead_resposta_aluno.avaliacao_id',$prova['avaliacao_id'])
    ->where('ead_resposta.correta',1)   
    ->select('ead_resposta.id','ead_resposta.correta')
    ->get();


  $nota = count($corretas);
    $update_colunas = array(
        'status' => '2',
        'nota' => $nota,
        'tempo'=>$prova['tempo_duracion_prova'],
        'encerramento'=>date('Y-m-d H:i:s')
    );

      DB::table('ead_tentativa')
        ->where('id', $prova['tentativa_id'])
        ->update($update_colunas); 

        DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json("Não foi possível gravar! " . $e->getMessage(), 400);
    
    }
    

    // return $corretas;
    
      return response()->json('Prova Finalizada com sucesso',200);
     }

     
    
  


}