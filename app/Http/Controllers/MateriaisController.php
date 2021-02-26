<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
// use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\Models\MateriasAluno;



class MateriasController extends Controller
{
    protected $aluno_materias;
    public function __construct(MateriasAluno $aluno_materias )
    {
        $this->user = Auth::user();
        $this->headers = $headers = \Request::header();
        $this->aluno_materias = $aluno_materias;
    }

 
    

    public function getMateriasAndamento(){
 
      $use = $this->user->id;
$array = $this->aluno_materias->getDisciplinaAluno($use);


return response()->json($array,200);

    }
}