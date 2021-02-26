<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class VideoAulas extends Model
{
    use HasFactory;

    protected $table = 'video_aulas';

    protected $fillable = ['id','nome', 'descricao', 'status','oferta_disciplina_turma','url'];



    static function getVideoAulas($oferta_disciplina_turma)
    {
        return  DB::table('video_aula') 
        ->where('video_aula.oferta_disciplina_turma_id',$oferta_disciplina_turma)
        ->select('id','url','created_at','video_aula.nome as titulo','video_aula.descricao')
        ->get();
    }
    

    
}
