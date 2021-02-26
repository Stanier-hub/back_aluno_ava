<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Lives extends Model
{
    use HasFactory;

    protected $table = 'lives';

    protected $fillable = ['id', 'nome', 'url', 'hora_inicio','hora_fim','data_fim', 'hora_fim' ,'oferta_disciplina_turma'];
}