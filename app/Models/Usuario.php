<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuario';

    protected $fillable = ['id', 'nome', 'sobrenome', 'nome_sobrenome', 'cpf', 'rg','data_nascimento', 'rua', 'bairro', 'cep', 'email', 'status', 'sexo_id', 'telefone', 'perfil_id','profissao'];

    static function block($id)
    {
        return DB::table('usuario')
            ->where('id', $id)
            ->update(['status' => '0']);
    }

    static function unlock($id)
    {
        return DB::table('usuario')
            ->where('id', $id)
            ->update(['status' => '1']);
    }

    static function getUser($coluna, $valor)
    {
        if($coluna == "identificacao")
        {
            return DB::table('usuario')
              ->join('users','users.usuario_id','=','usuario.id')
              ->select('usuario.*','users.identificacao')
              ->where('users.identificacao', $valor)
              ->get();

        }else{

            return DB::table('usuario')
              ->join('users','users.usuario_id','=','usuario.id')
              ->select('usuario.*','users.identificacao')
              ->where($coluna, $valor)
              ->get();
        }
    }

}
