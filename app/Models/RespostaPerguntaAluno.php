<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class RespostaPerguntaAluno extends Model
{
    use HasFactory;

    protected $table = 'ead_resposta_aluno';

    protected $fillable = ['id', 'ead_resposta_id','avaliacao_id', 'status',  'oferta_disciplina_turma_id', 'semestre_oferta_disciplina_id', 'usuario_id', 'ead_pergunta_id'];



}
