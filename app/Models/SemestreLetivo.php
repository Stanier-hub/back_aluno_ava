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

 
}
