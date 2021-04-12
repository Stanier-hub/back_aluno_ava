<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class SemestreLetivo extends Model
{
    use HasFactory;

    protected $table = 'semestre_letivo';

    protected $fillable = ['id', 'nome', 'status', 'descricao', 'semestre_id', 'matricula_grade_curricular_id', 'convocatoria_id', 'filial_id', 'user_in' ,'user_up'];


    public function getSemestreAluno($id)
    {
        return  DB::table('semestre_letivo')
        ->join('semestre', 'semestre.id', '=', 'semestre_letivo.semestre_id')
        ->join('convocatoria', 'convocatoria.id', '=', 'semestre_letivo.convocatoria_id')
        ->join('semestre_anual', 'semestre_anual.id', '=', 'convocatoria.semestre_anual_id')
        ->join('ano', 'ano.id', '=', 'convocatoria.ano_id')
        ->join('users as users_inclusao', 'users_inclusao.id', '=', 'semestre_letivo.user_in')
        ->leftjoin('users as users_alteracao', 'users_alteracao.id', '=', 'semestre_letivo.user_up')
        ->where('semestre_letivo.matricula_grade_curricular_id', $id)
        ->select('semestre.nome as nome_semestre', 'semestre_letivo.*', 'ano.nome as nome_ano', 'semestre_anual.nome as nome_semestre_anual', 'users_inclusao.name as usuario_inclusao', 'users_alteracao.name as usuario_alteracao')
        ->get();
      
      
    }
 
}
