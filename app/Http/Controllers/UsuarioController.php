<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Models\Usuario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\Models\Roles;
use App\Models\Permissions;

class UsuarioController extends Controller
{

    public function __construct()
    {
        $this->user = Auth::user();
        $this->headers = $headers = \Request::header();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(isset($this->user)){

            if(count(Roles::getPermissionFilial($this->user['id'],Permissions::getPermissionId("ra_Usuario")->id,$this->headers['filial']))> 0){
                return response()->json(Usuario::all(), 200);
            }else{
                return response()->json("unauthorized",401);
            }

        }else{
            return response()->json("unauthorized",401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\UsuarioRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsuarioRequest $request)
    {
        if(isset($this->user)){

            if(count(Roles::getPermissionFilial($this->user['id'],Permissions::getPermissionId("c_Usuario")->id,$this->headers['filial']))> 0){
                $usuario = Usuario::create($request->all())->id;
                
                $chave = "";
                $chave .= substr($request->cpf, 8,1);
                $chave .= substr($request->data_nascimento, 9,1);
                $chave .= substr($request->cpf, 9,1);
                $chave .= substr($request->data_nascimento, 6,1);
                $chave .= substr($request->cpf, 10,1);
                $chave .= substr($request->data_nascimento, 3,1);

                if($usuario){

                    $user = [
                        'name'       => $request->nome,
                        'email'      => $request->email,
                        'password'   =>  bcrypt("10203040"),
                        'usuario_id' => $usuario,
                     
                    ];

                    User::create($user);

                    return response()->json("Usuario adicionado com sucesso", 201);
                }else{
                    return response()->json("Falha ao incluir registro",200);
                }
            }else{
                return response()->json("unauthorized",401);
            }

        }else{
            return response()->json("unauthorized",401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(isset($this->user)){

            if(count(Roles::getPermissionFilial($this->user['id'],Permissions::getPermissionId("r_Usuario")->id,$this->headers['filial']))> 0){
                $usuario = Usuario::find($id);
                return response()->json($usuario,200);
            }else{
                return response()->json("unauthorized",401);
            }

        }else{
            return response()->json("unauthorized",401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UsuarioRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsuarioRequest $request, $id)
    {
        if(isset($this->user)){

            if(count(Roles::getPermissionFilial($this->user['id'],Permissions::getPermissionId("u_Usuario")->id,$this->headers['filial']))> 0){
                $data = $request->validated();
                $usuario = Usuario::find($id);
                if($usuario){
                    Usuario::find($id)->update($request->all());
                    return response()->json("Usuario atualizado com sucesso", 201);
                }else{
                    return response()->json("Usuario nao encontrado", 200);
                }
            }else{
                return response()->json("unauthorized",401);
            }

        }else{
            return response()->json("unauthorized",401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function block($id)
    {
        if(isset($this->user)){

            if(count(Roles::getPermissionFilial($this->user['id'],Permissions::getPermissionId("lock_Usuario")->id,$this->headers['filial']))> 0){
                if(Usuario::find($id)){
                    Usuario::block($id);
                    return response()->json("Usuario bloqueado com sucesso", 200);
                }else{
                    return response()->json("Usuario nao encontrado", 200);
                }
            }else{
                return response()->json("unauthorized",401);
            }

        }else{
            return response()->json("unauthorized",401);
        }
    }

    public function unlock($id)
    {
        if(isset($this->user)){

            if(count(Roles::getPermissionFilial($this->user['id'],Permissions::getPermissionId("unlock_Usuario")->id,$this->headers['filial']))> 0){
                if(Usuario::find($id)){
                    Usuario::unlock($id);
                    return response()->json("Usuario desbloqueado com sucesso", 200);
                }else{
                    return response()->json("Usuario nao encontrado", 200);
                }
            }else{
                return response()->json("unauthorized",401);
            }

        }else{
             return response()->json("unauthorized",401);
        }
    }

    public function buscar(Request $req)
    {
        if(isset($this->user)){
            if(count(Roles::getPermissionFilial($this->user['id'],Permissions::getPermissionId("s_Usuario")->id,$this->headers['filial']))> 0){

                return response()->json(Usuario::getUser($req->get('tipo'),$req->get('texto')));

            }else{
                return response()->json("unauthorized",401);
            }

         }else{
             return response()->json("unauthorized",401);
        }
    }
}
