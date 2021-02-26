<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
// use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\Models\VideoAulas;
use App\Models\VideoExtra;
use App\Models\MaterialAluno;


class AulasController extends Controller
{
    protected $video;
    public function __construct(VideoAulas $video, VideoExtra $videoextra, MaterialAluno $material)
    {
        $this->user = Auth::user();
        $this->headers = $headers = \Request::header();
        $this->video = $video;
        $this->videoextra =$videoextra;
        $this->material =$material;
    }



    public function getAulasAndamento($id_oferta_disciplina_turma){

       
        $array = $this->video->getVideoAulas($id_oferta_disciplina_turma);
        
        
        return response()->json($array,200);



    }

    public function getVideosAndamento($id_oferta_disciplina_turma){

        $array = $this->videoextra->getVideoAulasExtra($id_oferta_disciplina_turma);
        
        
        return response()->json($array,200);

        
            }

            public function getMateriaisAndamento($id_oferta_disciplina_turma){

            $array = $this->material->getMateriais($id_oferta_disciplina_turma);
            return response()->json($array,200);
            
         }
}