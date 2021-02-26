<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class VideoExtra extends Model
{
    use HasFactory;

    protected $table = 'video_extra';

    protected $fillable = ['id','nome', 'descricao', 'status','oferta_disciplina_turma','url'];




    
    static function getVideoAulasExtra($oferta_disciplina_turma)
    {
        return  DB::table('video_extra') 
        ->where('video_extra.oferta_disciplina_turma_id',$oferta_disciplina_turma)
        ->select('id','url','created_at','video_extra.nome as titulo','video_extra.descricao')
        ->get();
    }
 
    
}
