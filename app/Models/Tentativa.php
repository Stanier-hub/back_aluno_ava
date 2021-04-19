<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Tentativa extends Model
{
    use HasFactory; 

    protected $table = 'ead_tentativa';

    protected $fillable = ['id', 'nota','ead_avaliacao_oferta_disciplina_id','descricao',  'status','usuario_id', 'tempo', 'data_inicio', 'avaliacao_id', 'oferta_disciplina_turma_id', 'semestre_letivo_id'];



}
