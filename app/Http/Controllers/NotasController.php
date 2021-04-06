<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
// use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\Models\MateriasAluno;
use App\Models\SemestreLetivo;
use App\Models\Tentativa;
use DB;


// use PhpParser\Node\Stmt\Foreach_;

class NotasController extends Controller
{
    protected $aluno_materias;
    protected $semestreLetivo;
    protected $tentativa;


    
    public function __construct(MateriasAluno $aluno_materias, SemestreLetivo $semestreLetivo, Tentativa $tentativa)
    {
        $this->user = Auth::user();
        $this->headers = $headers = \Request::header();
        $this->aluno_materias = $aluno_materias;
        $this->semestreLetivo = $semestreLetivo;
        $this->tentativa = $tentativa;

    }


    public function getSemestreAluno()
    {

        $matricula_aluno =  DB::table('matricula_grade_curricular')
        ->where('matricula_grade_curricular.usuario_id',$this->user->id)
        ->first();
        $data =   $this->semestreLetivo->getSemestreAluno($matricula_aluno->id);

       return $data;   
      
    }

    public function getNotasAluno($semestre_letivo_id){
       
        $disciplinas =  DB::table('semestre_letivo')
        ->join('semestre', 'semestre.id', 'semestre_letivo.semestre_id')
        ->join('disciplina_grade_curricular','disciplina_grade_curricular.semestre_id','semestre.id')
        ->join('oferta_disciplina_turma','oferta_disciplina_turma.disciplina_grade_curricular_id','disciplina_grade_curricular.id')   
    
        ->join('disciplina','disciplina.id','disciplina_grade_curricular.disciplina_id')
        ->where('semestre_letivo.id',$semestre_letivo_id)
                ->select('disciplina.nome','oferta_disciplina_turma.id')
             
                ->get();

            //    return  $disciplinas;

        
      $data =   $this->tentativa
      ->join('oferta_disciplina_turma','oferta_disciplina_turma.id','ead_tentativa.oferta_disciplina_turma_id')
     
      ->join('disciplina_grade_curricular','disciplina_grade_curricular.id','oferta_disciplina_turma.disciplina_grade_curricular_id')   
      ->join('disciplina','disciplina.id','disciplina_grade_curricular.disciplina_id')
     
      ->join('avaliacao','avaliacao.id','ead_tentativa.avaliacao_id')
      ->join('tipo_avaliacao','tipo_avaliacao.id','avaliacao.tipo_avaliacao_id')

      ->where('ead_tentativa.usuario_id',$this->user->id)
      ->where('ead_tentativa.semestre_letivo_id',$semestre_letivo_id)
        ->select('ead_tentativa.oferta_disciplina_turma_id','ead_tentativa.id as tentativa_id','disciplina.nome as nome_disciplina','tipo_avaliacao.id as tipo_avaliacao_id','tipo_avaliacao.nome as nome_avaliacao','ead_tentativa.nota')
        ->get();


    //  return $data;

foreach($disciplinas as $dis){
    $aux=['nome_disciplina'=>$dis->nome,'1'=>'','2'=>'','trabalho'=>'','3'=>''];
$nome_disciplina=$dis->nome;
        foreach($data as $item){
if($dis->id == $item->oferta_disciplina_turma_id){
    $aux[$item->tipo_avaliacao_id]=$item->nota;
          
    $nome_disciplina =$item->nome_disciplina;

    // $arrayprovas[$item->oferta_disciplina_turma_id] =
    //          ['av'=>$aux,'nome_disciplina'=>$item->nome_disciplina];
    
}
$arrayprovas[$dis->id]=['nome_disciplina'=>$nome_disciplina,'parcial 1'=>$aux['1'],'parcial 2'=>$aux['2'],'trabalho'=>'','final'=>$aux['3']];

        }
    $arraynotas[]=$arrayprovas;
    $arrayprovas=[];

    }
// $arraynotaMat =['nome_disciplina'=>'','parcial 1'=>0,'parcial 2'=>0,'trabalho'=>0,'final'=>0];
    $arrayTotal=[];
    foreach($arraynotas as $ar){
        foreach($ar as $element){

            $arrayTotal[]= $element ; 
        }
   
 
    }



        return $arrayTotal; 

    }


}
