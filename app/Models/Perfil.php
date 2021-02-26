<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Perfil extends Model
{
    use HasFactory;

    protected $table = 'perfil';

    protected $fillable = ['id', 'nome', 'descricao', 'status'];

    static function block($id)
    {
        return DB::table('perfil')
            ->where('id', $id)
            ->update(['status' => '0']);
    }

    static function unlock($id)
    {
        return DB::table('perfil')
            ->where('id', $id)
            ->update(['status' => '1']);
    }
}
