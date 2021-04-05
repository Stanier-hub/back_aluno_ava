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

class FinanceiroController extends Controller
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

       public function show_join()
    {

        $matriculagradecurricular = MatriculaGradeCurricular::getByUser($this->user->usuario_id);
        return response()->json($matriculagradecurricular,200);
        
    }

    
    public function getSemestreAluno($id)
    {
        $data =   $this->semestre->getSemestreAluno($id);

       return $data;   
      
    }

    public function pegarPedidos($id_semestre_letivo){
        $data = $this->finan_pedidos
        ->join('produto','produto.id','finan_pedido_recebimento.produto_id')
        ->where('semestre_letivo_id',$id_semestre_letivo)
        ->where('finan_pedido_recebimento.status',1)
        ->select('finan_pedido_recebimento.id','produto.nome as nome_produto','valor_total','finan_pedido_recebimento.data_vencimento')
        ->get();
        foreach($data as $item){
    $item->data_vencimento = date('d/m/Y',strtotime($item->data_vencimento));
    $item->valor_total = 'G$' . " " . number_format($item->valor_total, 0, ',', '.') ;
        }
        
        return $data;
    }
    public function pegarParcelasPedido($finan_pedido_recebimento_id){
        $data = $this->finan_contas
        ->join('finan_pedido_recebimento','finan_pedido_recebimento.id','finan_contas_receber.finan_pedido_recebimento_id')
        ->join('produto','produto.id','finan_pedido_recebimento.produto_id')
        ->leftJoin('finan_modo_pagamento','finan_modo_pagamento.id','finan_contas_receber.finan_modo_pagamento_id')
        ->where('finan_pedido_recebimento_id',$finan_pedido_recebimento_id)
        ->select('finan_contas_receber.status','finan_contas_receber.id as id_finan_contas_receber','finan_pedido_recebimento.valor_total','finan_modo_pagamento.nome as modo_pagamento','produto.nome as nome_produto','finan_pedido_recebimento.valor_total as valor_parcelas','finan_pedido_recebimento.data_vencimento')
        ->get();

        foreach($data as $item){
            $item->data_vencimento = date('d/m/Y',strtotime($item->data_vencimento));
            $item->valor_parcelas = 'G$' . " " . number_format($item->valor_parcelas / count($data), 0, ',', '.') ;
            
        }
        
        return $data;
    }





}