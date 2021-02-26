<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
// use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\Models\VideoAulas;



class VideoAulasController extends Controller
{
    protected $video;
    public function __construct(VideoAulas $video )
    {
        $this->user = Auth::user();
        $this->headers = $headers = \Request::header();
        $this->video = $video;
    }

 
    

    public function getVideoAulas(){
 
      $use = $this->user->id;
$array = $this->video->getVideoAulas($use);


return response()->json($array,200);

    }
}