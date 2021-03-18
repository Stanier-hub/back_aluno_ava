<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
// use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\Models\matriculagradeAluno;
use PhpParser\Node\Stmt\Foreach_;
use App\Models\MatriculaGradeCurricular;
use App\Models\SemestreLetivo;
use App\Models\FinanPedidoRecebimento;
use App\Models\FinanContasReceber;
use Illuminate\Support\Facades\Http;
use DB;
class PagWiseController extends Controller
{
    protected $matriculagrade;
    protected $Semestre;
    protected $finan_pedidos;
    protected $finan_contas;

    public function __construct(MatriculaGradeCurricular $matriculagrade, SemestreLetivo $semestre, FinanPedidoRecebimento $finan_pedidos, FinanContasReceber $finan_contas)
    {
        $this->user = Auth::user();
        $this->headers = $headers = \Request::header();
        $this->matriculagrade = $matriculagrade;
        $this->semestre = $semestre;
        $this->finan_pedidos = $finan_pedidos;
        $this->finan_contas = $finan_contas;
    }


 public function gerar_cobranca(Request $request)
 {
    $dados_ordem = (object)$request->data;


    $bo = $this->finan_contas->where('id', $dados_ordem->id_finan_contas_receber)->first();
    if($bo->status == 3){
        // $message =['tipo'=>'erro'];
        return response()->json(['status'=>'warning','mensagem'=>'Esse boleto ja avisa cido gerado','dados'=>'https://pagwise.com.br/cobrancas/'.$bo->ordem_uuid],200);
    }

    $dados_usu = DB::table('usuario')
    ->join('cidade','cidade.id','usuario.cidade_id')
    ->join('estado','estado.id','cidade.estado_id')
    ->where('usuario.id', $this->user->usuario_id)
    ->select('usuario.*','estado.sigla as uf','cidade.nome as nome_cidade')
    ->first();



    // return ['res'=>(float)number_format($dados_ordem->valor_total/1150, 2, '.', ''),'usu'=>$dados_usu->nome_sobrenome];
    #region t


          
//      $this->load->model('Usuario_model', 'usuario');
//   $usuario = $this->usuario->get($this->session->userdata('usuario_id'));
  
//   $dados['ordens'] = $this->ordens_usuario();
//   $status_pago = false;
  
//   foreach($dados['ordens'] as $ordem){
      
//       if($ordem->status != 5 and $ordem->data_vencimento >= date('Y-m-d')){
//           $status_pago = true;
//       }
//   }
  
//   if($status_pago){
      
//       redirect("cadastro/pag");
      
//   }

  
//   $nosso_numero = $this->nosso_numero();
  #endrefio
  $cambio = DB::table('finan_cambio')->orderBy('id','desc')->first();
//    return 'https://pagwise.com.br/cobrancas/11cba9cd-613a-4069-83dd-bd02e319a318';
  date_default_timezone_set('America/Sao_Paulo');

$valor_boleto = $dados_ordem->valor_total *0.7;

  $dados = [
      
          "empresa"=>[
               "id" => 1
               ],
          "contaProduto"=>[
               "id" => 1
               ],
               
                "numeroDocumento"=> $dados_ordem->id_finan_contas_receber,
                "valor" => (float)number_format($valor_boleto/(int)$cambio->compra, 2, '.', ''),
                "dataVencimento" => date('d.m.Y', strtotime('+5 days')),
                "dataProcessamento" => date('d.m.Y'),
                "dataDocumentos" => date('d.m.Y'),
                "instrucoes" => $dados_ordem->nome_produto,
                "nomePagador" => $dados_usu->nome_sobrenome,
                "registroNacional" => $dados_usu->cpf, //str_pad($dados_usu->cpf, 11, "0", STR_PAD_LEFT),
                "logradouro" => $dados_usu->rua,
                "bairro" => $dados_usu->bairro,
                "cidade" => $dados_usu->nome_cidade,
                "uf" => $dados_usu->uf,
                "cep" => $dados_usu->cep, // $usuario->cep,
                "chave" => 40372091000100 
      
      ];

  
  
            // $jsonencode = json_encode($dados);
            $response = Http::withHeaders([

                'access-token'=>$this->token_acesso_pagwise(),
                'api-key'=>'21a87771-a92c-44c3-b44f-546aa5221234',
                'Content-Type'=> 'application/json'

            ])->post('https://pagwise.com.br/api/v1/ordem',$dados);
    // var_dump($dados);

          
            $res_deco = json_decode($response);
            // return ['dados'=>$res_deco->uuid,'teste'=>true];
            if(isset($res_deco->uuid)){
            


                $data = $this->finan_contas->where('id', $dados_ordem->id_finan_contas_receber)->first();
                
                
                    $data->ordem_uuid= $res_deco->uuid;
                    $data->ordem_id= $res_deco->id;
                    $data->status = 3;
                    $data->data_vencimento_boleto = date('Y-m-d', strtotime('+5 days'));
                    $data->updated_at = date('Y-m-d H:i:s');
                 
                
                $data->save();
               
            return ['status'=>'success','mensagem'=>'Boleto gerado com sucesso','dados'=>'https://pagwise.com.br/cobrancas/'.$res_deco->uuid];
            }
            return ['status'=>'error','mensagem'=>'Erro ao gerar'];
            
            // var_dump($res_deco);
           
//    redirect("cadastro/pag");

       // echo "https://pagwise-com-br.umbler.net/cobrancas/".$res_deco->uuid;
     
 }
 
 public function token_acesso_pagwise()
 {
     $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://pagwise.com.br/api/v1/oauth/token',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_HTTPHEADER => array(
                'api-key: 21a87771-a92c-44c3-b44f-546aa5221234'
              ),
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);
            $decode =json_decode($response);
            return $decode->access_token;
 }
 
 	public function baixar_boletos()
	{
	   // date_default_timezone_set('America/Sao_Paulo');
	    
	   // $date = new DateTime();
	    
    //     echo $date->format('Y-m-d H:i:s T');
  
	   // date->format("H:i:s T")
	      $startDate = '2021-01-01T13:38:50.582Z';
	   // $startDate = $date->format('Y-01-d H:i:s T');// date('Y-m-d H:i:s',strtotime('-30 days'));

        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://pagwise.com.br/api/v1/boleto/bb?status=pago&startDate='.$startDate.'&endDate=2021-12-30T13:38:50.582Z',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'api-key: 21a87771-a92c-44c3-b44f-546aa5221234',
            'access-token:'.$this->token_acesso_pagwise(),
          ),
        ));
        
        $response = curl_exec($curl);
        $respon = curl_exec($curl);
        
        curl_close($curl);
        
        $response = json_decode($response);
       
        foreach($response as $value){
            foreach($value as $val){
              
		      
		      $contas_receber =  $this->finan_contas->where('ordem_uuid',$val->ordem_uuid)->first();
		      if(isset($contas_receber->status)){
		           $contas_receber->valor_pago = $val->valor_pago;
		        $contas_receber->status = 2;
		            $ids[] = $contas_receber->save();
		      }
		       
		        
		   
            }
            
        }
        
        
        
     return response()->json($ids,200);
   
    //   echo $respon;
          
	}
	
	public function baixar_pix()
	{
	   // date_default_timezone_set('America/Sao_Paulo');
	    
	   // $date = new DateTime();
	    
    //     echo $date->format('Y-m-d H:i:s T');
  
	   // date->format("H:i:s T")
	      $startDate = '2021-01-01T13:38:50.582Z';
	   // $startDate = $date->format('Y-01-d H:i:s T');// date('Y-m-d H:i:s',strtotime('-30 days'));

        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://pagwise.com.br/api/v1/pix/bb?status=CONCLUIDA&startDate='.$startDate.'&endDate=2021-12-30T13:38:50.582Z',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'api-key: 21a87771-a92c-44c3-b44f-546aa5221234',
            'access-token:'.$this->token_acesso_pagwise(),
          ),
        ));
        
        $response = curl_exec($curl);
        $respon = curl_exec($curl);
        
        curl_close($curl);
        
        $response = json_decode($response);
       
        foreach($response as $value){
            foreach($value as $val){
                
        //     
		            $contas_receber =  $this->finan_contas->where('ordem_uuid',$val->ordem_uuid)->first();
		      if(isset($contas_receber->status)){
		           $contas_receber->valor_pago = $val->valor_original;
		        $contas_receber->status = 2;
		            $ids[] = $contas_receber->save();
		      }
            }
            
        }
    //   echo count($res);
   return response()->json($ids,200);
          
	}


}