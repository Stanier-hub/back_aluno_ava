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

class FinanceiroController extends Controller
{
    protected $matriculagrade;
    protected $Semestre;
    public function __construct(MatriculaGradeCurricular $matriculagrade, SemestreLetivo $semestre, FinanPedidoRecebimento $finan_pedidos)
    {
        $this->user = Auth::user();
        $this->headers = $headers = \Request::header();
        $this->matriculagrade = $matriculagrade;
        $this->semestre = $semestre;
        $this->finan_pedidos = $finan_pedidos;
    }

public function show_join()
    {

        $matriculagradecurricular = MatriculaGradeCurricular::getByUser($this->user->id);
        return response()->json($matriculagradecurricular,200);
    }

    
    public function getSemestreAluno($id)
    {
        $data =   $this->semestre
        ->join('semestre', 'semestre.id', '=', 'semestre_letivo.semestre_id')
        ->join('convocatoria', 'convocatoria.id', '=', 'semestre_letivo.convocatoria_id')
        ->join('semestre_anual', 'semestre_anual.id', '=', 'convocatoria.semestre_anual_id')
        ->join('ano', 'ano.id', '=', 'convocatoria.ano_id')
        ->join('users as users_inclusao', 'users_inclusao.id', '=', 'semestre_letivo.user_in')
        ->leftjoin('users as users_alteracao', 'users_alteracao.id', '=', 'semestre_letivo.user_up')
        ->where('semestre_letivo.matricula_grade_curricular_id', $id)
        ->select('semestre.nome as nome_semestre', 'semestre_letivo.*', 'ano.nome as nome_ano', 'semestre_anual.nome as nome_semestre_anual', 'users_inclusao.name as usuario_inclusao', 'users_alteracao.name as usuario_alteracao')
        ->get();
       
       return $data;

        
      
    }

    public function pegarPedidos($id_semestre_letivo){
        $data = $this->finan_pedidos->where('semestre_letivo_id',$id_semestre_letivo)
        ->select('valor_total','data_validade as data_vencimento')
        ->get();
        
        return $data;
    }

}