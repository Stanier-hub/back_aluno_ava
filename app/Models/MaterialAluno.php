<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class MaterialAluno extends Model
{
    use HasFactory;

    protected $table = 'material';

    protected $fillable = ['id','nome', 'descricao', 'status','oferta_disciplina_turma'];



    static function getMateriais($oferta_disciplina_turma)
    {
        $data=  DB::table('material') 
        ->where('material.oferta_disciplina_turma_id',$oferta_disciplina_turma)
        ->join('arquivo','arquivo.id','material.arquivo_id')
        ->select('arquivo.arquivo_original','arquivo.extensao','material.created_at','material.nome as titulo','material.descricao','arquivo.arquivo')
        ->get();

        foreach($data as $item){
            $item->link = 'https://localhost:8000/storege/arquivos/material/'.$item->arquivo;
        }

        return $data;

    }
    

    
}
