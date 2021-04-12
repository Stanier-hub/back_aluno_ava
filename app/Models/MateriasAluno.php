<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class MateriasAluno extends Model
{
    use HasFactory;

    protected $table = 'matricula_grade_curricular';

    protected $fillable = ['id', 'descricao', 'status','oferta_disciplina_turma','data_matricula','filial_id','user_in','user_up'];



    static function getDisciplinaAluno($id_aluno)
    {
        return  DB::table('matricula_grade_curricular')
        
        ->join('semestre_letivo','semestre_letivo.matricula_grade_curricular_id','matricula_grade_curricular.id')
        ->join('semestre_oferta_disciplina','semestre_oferta_disciplina.semestre_letivo_id','semestre_letivo.id')
        ->join('oferta_disciplina_turma','oferta_disciplina_turma.id','semestre_oferta_disciplina.oferta_disciplina_turma_id')   
        ->join('disciplina_grade_curricular','disciplina_grade_curricular.id','oferta_disciplina_turma.disciplina_grade_curricular_id')
        ->join('disciplina','disciplina.id','disciplina_grade_curricular.disciplina_id')
        ->join('filial','filial.id','=','semestre_oferta_disciplina.filial_id')
        ->where('semestre_letivo.status',1)
        ->where('matricula_grade_curricular.status',1)
        ->where('oferta_disciplina_turma.status',1)
        ->where('semestre_oferta_disciplina.status',1)
                ->select('semestre_oferta_disciplina.id as semestre_oferta_disciplina_id','semestre_letivo.id as semestre_letivo_id','disciplina.nome as nome_disciplina','filial.nome as nome_filial',
                'semestre_oferta_disciplina.*')
                ->where('matricula_grade_curricular.usuario_id',$id_aluno)
                
                ->get();
    }
}
