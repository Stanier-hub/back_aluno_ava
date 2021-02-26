<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class MatriculaGradeCurricular extends Model
{
    use HasFactory;

    protected $table = 'matricula_grade_curricular';

    protected $fillable = ['id', 'status', 'descricao', 'usuario_id', 'grade_curricular_id', 'contrato_aluno_id', 'filial_id', 'user_in', 'user_up'];

    public function contrato_aluno()
    {
        return $this->belongsTo(ContratoAluno::class, 'contrato_aluno_id', 'id');
    }

    static function getAll()
    {
        return self::query()
            ->join('grade_curricular', 'grade_curricular.id', '=', 'matricula_grade_curricular.grade_curricular_id')
            ->join('curso', 'curso.id', '=', 'grade_curricular.curso_id')
            ->join('tipo_grade_curricular', 'tipo_grade_curricular.id', '=', 'grade_curricular.tipo_grade_curricular_id')
            ->join('users as users_inclusao', 'users_inclusao.id', '=', 'matricula_grade_curricular.user_in')
            ->leftjoin('users as users_alteracao', 'users_alteracao.id', '=', 'matricula_grade_curricular.user_up')
            ->leftjoin('contrato_aluno', 'contrato_aluno.id', '=', 'matricula_grade_curricular.contrato_aluno_id')
            ->select('matricula_grade_curricular.*', 'tipo_grade_curricular.nome as nome_tipo_grade_curricular', 'curso.nome as nome_curso',
                'contrato_aluno.nome as Contrato', 'users_inclusao.name as usuario_inclusao', 'users_alteracao.name as usuario_alteracao')
            ->get();
    }

    static function getById($id)
    {
        return self::query()
            ->join('grade_curricular', 'grade_curricular.id', '=', 'matricula_grade_curricular.grade_curricular_id')
            ->join('curso', 'curso.id', '=', 'grade_curricular.curso_id')
            ->join('tipo_grade_curricular', 'tipo_grade_curricular.id', '=', 'grade_curricular.tipo_grade_curricular_id')
            ->join('users as users_inclusao', 'users_inclusao.id', '=', 'matricula_grade_curricular.user_in')
            ->leftjoin('users as users_alteracao', 'users_alteracao.id', '=', 'matricula_grade_curricular.user_up')
            ->leftjoin('contrato_aluno', 'contrato_aluno.id', '=', 'matricula_grade_curricular.contrato_aluno_id')
            ->select('matricula_grade_curricular.*', 'tipo_grade_curricular.nome as nome_tipo_grade_curricular', 'curso.nome as nome_curso',
                'contrato_aluno.nome as Contrato', 'users_inclusao.name as usuario_inclusao', 'users_alteracao.name as usuario_alteracao')
            ->where('matricula_grade_curricular.id', $id)
            ->get();
    }

    static function block($id)
    {
        return self::query()
            ->where('id', $id)
            ->update(['status' => '0']);
    }

    static function unlock($id)
    {
        return self::query()
            ->where('id', $id)
            ->update(['status' => '1']);
    }

    static function getByUser($usuario)
    {
        return self::query()
            ->join('usuario', 'usuario.id', '=', 'matricula_grade_curricular.usuario_id')
            ->join('grade_curricular', 'grade_curricular.id', '=', 'matricula_grade_curricular.grade_curricular_id')
            ->join('curso', 'curso.id', '=', 'grade_curricular.curso_id')
            ->join('tipo_grade_curricular', 'tipo_grade_curricular.id', '=', 'grade_curricular.tipo_grade_curricular_id')
            ->join('filial', 'filial.id', 'matricula_grade_curricular.filial_id')
            ->select(
                'matricula_grade_curricular.*',
                'curso.nome as nome_curso',
                'tipo_grade_curricular.nome as nome_tipo_grade_curricular',
                'grade_curricular.nome as nome_grade_curricular',
                'usuario.nome as nome_usuario',
                'filial.nome as nome_filial'
            )
            ->where('matricula_grade_curricular.usuario_id', $usuario)
            ->get();
    }
}
