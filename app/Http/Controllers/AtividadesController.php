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
use DB;

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


// public function excluir(Request $request){
//       $data = DB::table('avaliacao')->get();
//       return $data;
// }

public function listaTentativasAvaliacao($avaliacao_id){
     $data = $this->tentativa->where('status',2)->where('avaliacao_id',$avaliacao_id)->where('usuario_id',$this->user->usuario_id)->get();

     foreach($data as $item){
         $item->data_inicio = date('d/m/Y H:i:s',strtotime($item->data_inicio));
         $item->encerramento = date('d/m/Y H:i:s',strtotime($item->encerramento));
     }
    return response()->json($data,200);
}

    public function getAtividades($id_disciplina_oferta_turma){
        
    
      
    date_default_timezone_set('America/Asuncion');


     $data = $this->atividade->getAtividades($id_disciplina_oferta_turma);
     // if($data['resposta'] == 'negativo'){
     //     return response()->json('Perguntas insuficiantes',200);
     // }
    //  return $data;
    // return $data;
 if(count($data) <1){
     return $data;
 }



$tentativa_id='';
        foreach($data as $element){
            $tentativa_aluno =    $this->tentativa
    
            ->where('avaliacao_id',$element->avaliacao_id)
            ->where('status',1)
            ->orWhere('status',2)
        
            ->where('usuario_id',$this->user->usuario_id)->get();
            
            $tempo=0;
            if(!isset($tentativa_aluno[0]->id))
            {
                $tentativa_id = '';
                $status='Pendente';
                $corstatus='warning';
            }else{

$count=0;
$tentativa_aluno2=[];
$tentativa_aluno3=[];
            foreach($tentativa_aluno as $tent){
               
               if($tent->status == 2){
                $count++;
                $tentativa_aluno3=$tent;
               }
               if($tent->status==1){
               $tentativa_aluno2=$tent;
               }
        
        }

    //   return response()->json($element);
      
        if($element->data_fim_hora <= date('Y-m-d H:i:s')) {
            if($tentativa_aluno3->status == 2){
                $tentativa_id = '';
                $status='Realizado';
                $corstatus='success';
             }
        }else{

        
        $tentativa_aluno = $tentativa_aluno2;

        if($element->tentativa <= $count){
            $tentativa_id = '';
            $status='Realizado';
            $corstatus='success';

        }else{



            if(!isset($tentativa_aluno->id))
            {
                $tentativa_id = '';
                $status='Realizado';
                $corstatus='warning';
            }else{
        
         
         
                $tentativa_id = $tentativa_aluno->id;

                if($element->data_fim <= date('Y-m-d')   and $element->hora_fim <=  date('H:i:s')) {
                    if($tentativa_aluno->status != 2){
                        $tentativa_aluno->status = 3;
                     }
                }
   

            switch($tentativa_aluno->status){
            case 1:
             $status='Pendente';
             $corstatus='warning';
            break;

            case 2:
            $status ='Realizado';
            $corstatus = 'success';
            break; 
            case 3:
            $status ='Não Realizado';
            $corstatus = 'danger';
            break; 
            } 

          
            $tempo =  strtotime(date('Y-m-d H:i:s')) - strtotime($tentativa_aluno->created_at);
        }
    }
        }
    }

        
        $tempo_prova = $element->tempo_minutos * 60;
        if(isset($tentativa_aluno->id)){
        if($tentativa_aluno->status != 2)
        {
   
        if($tempo >= $tempo_prova){
            $status ='Não Realizado';
               $corstatus = 'danger';
         }
         
          if($tempo < 0){
            $status ='Não Realizado';
            $corstatus = 'danger';
         }
        }
        }
    
 
    
        $array[] = [

        'tentativa_id' =>$tentativa_id,
        'quantidade_perguntas_real' =>$element->quantidade_perguntas_real,
        'quantidade_perguntas' =>$element->quantidade_perguntas,
        'avaliacao_id' =>$element->avaliacao_id,
        'titulo' => $element->nome,
        'descricao' =>'Atividade encerara em '.date('d/m/Y',strtotime($element->data_fim)).' '.$element->hora_fim ,
        'data_fim' =>date('d/m/Y',strtotime($element->data_fim)).' '.$element->hora_fim ,
        'data_inicial' =>date('d/m/Y',strtotime($element->data_inicio)).' '.$element->hora_inicio ,
        'data_inicio'  => $element->data_inicio,
        'status' => $status,
        'corstatus'=>$corstatus,
        'tempo_minutos' =>$tempo_prova,
        'tentativas'=>$element->tentativa,
        'ead_avaliacao_oferta_disciplina_id'=>$element->ead_avaliacao_oferta_disciplina_id

        ];  
    }

        return response()->json($array,200);

    }


    public function getAtividadesPerguntas($id_avaliacao,$oferta_disciplina_turma_id,$semetre_letivo_id,$ead_avaliacao_oferta_disciplina_id){



        // if($tentativa_aluno)


  date_default_timezone_set('America/Asuncion');

        $tentativa_aluno =    $this->tentativa
        ->where('ead_tentativa.semestre_letivo_id',$semetre_letivo_id)
        ->where('ead_tentativa.avaliacao_id',$id_avaliacao)
        ->where('ead_tentativa.ead_avaliacao_oferta_disciplina_id',$ead_avaliacao_oferta_disciplina_id)
        ->join('ead_avaliacao_oferta_disciplina','ead_avaliacao_oferta_disciplina.id','ead_tentativa.ead_avaliacao_oferta_disciplina_id')
        ->where('ead_tentativa.status',1)
        ->orWhere('ead_tentativa.status',2)
        // ->orderBy('id','desc')
        // ->Where('status',2)
        ->where('ead_tentativa.usuario_id',$this->user->usuario_id)
        ->select('ead_tentativa.created_at','ead_tentativa.id','ead_tentativa.status','ead_avaliacao_oferta_disciplina.tentativa')
        ->get();

        $count=0;
$tentativa_aluno2=[];

            foreach($tentativa_aluno as $tent){
               
               if($tent->status == 2){
                $count++;
              
               }
           
               if($tent->tentativa <= $count){
            return response()->json('Tentativas Insuficientes',200);
    
            }

            if($tent->status==1){
                $tentativa_aluno2=$tent;
                }
        
        }

        $tentativa_aluno= $tentativa_aluno2;

       
        //   $tempo =  strtotime(date('Y-m-d H:i:s')) - strtotime($tentativa_aluno->created);

   
       if(!isset($tentativa_aluno->id)){
        $new_tentativa =[
            'nota'=> '',
            'descricao'=> '',
            'status'=> 1,
            'tempo'=>'',
            'usuario_id'=> $this->user->usuario_id,
            'created'=> date('Y-m-d H:i:s'),
            'data_inicio'=> date('Y-m-d H:i:s'),
            'oferta_disciplina_turma_id'=> $oferta_disciplina_turma_id,
            'avaliacao_id'=>$id_avaliacao,
            'semestre_letivo_id'=> $semetre_letivo_id,
            'ead_avaliacao_oferta_disciplina_id'=>$ead_avaliacao_oferta_disciplina_id
        ];
        $tentativa_aluno = Tentativa::create($new_tentativa);
      }
    

    
   
         $tempo =  strtotime(date('Y-m-d H:i:s')) - strtotime($tentativa_aluno->created_at);

        $data = $this->atividade->getPerguntasAvaliacao($id_avaliacao);
        // return response()->json($data,200);
        $array=[];

        foreach($data as $item){
            
            $resposta[$item->ead_pergunta_id][] = ['enunciado'=>$item->titulo_pergunta,'titulo'=>$item->titulo_resposta,'id'=>$item->ead_resposta_id];
            $array[$item->ead_pergunta_id] =[ 'data_inicio'=> $tentativa_aluno->data_inicio,'tempo_minutos'=>$tempo,'tentativa_id'=>$tentativa_aluno->id,'pergunta_id'=>$item->ead_pergunta_id,'n'=>count($array),'pergunta'=>$item->titulo_pergunta,'resposta'=>$resposta[$item->ead_pergunta_id]];
        
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