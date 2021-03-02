<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class FinanContasReceber extends Model
{
    use HasFactory;

    protected $table = 'finan_contas_receber';

    protected $fillable = [
        'finan_pedido_recebimento_id',
        'conta_id',
        'parcela',
        'usuario_id',
        'emissao',
        'valor',
        'vencimento',
        'finan_forma_pagamento_id',
        'juros',
        'multa',
        'desconto',
        'baixa',
        'historico',
        'status',
        'finan_moeda_id',
        'filial_id',
        'user_in',
        'user_up'
    ];


    static function getAll()
    {
        return DB::table('finan_contas_receber')
            ->join('usuario', 'usuario.id', '=', 'finan_contas_receber.usuario_id')
            ->join('finan_forma_pagamento', 'finan_forma_pagamento.id', '=', 'finan_contas_receber.finan_forma_pagamento_id')
            ->join('finan_moeda', 'finan_moeda.id', '=', 'finan_contas_receber.finan_moeda_id')
            ->join('filial', 'filial.id', '=', 'finan_contas_receber.filial_id')
            ->join('users as users_inclusao', 'users_inclusao.id', '=', 'finan_contas_receber.user_in')
            ->leftjoin('users as users_alteracao', 'users_alteracao.id', '=', 'finan_contas_receber.user_up')
            ->leftJoin('conta as conta_bancaria', 'conta_bancaria.id', '=', 'finan_contas_receber.conta_id')
            ->leftJoin('banco as b', 'b.id', '=', 'conta_bancaria.banco_id')
            ->select('finan_contas_receber.*', 'b.nome as banco','usuario.nome as nome_usuario', 'finan_forma_pagamento.nome as forma_pagamento', 'finan_moeda.nome as moeda', 'filial.nome as filial', 'users_inclusao.name as usuario_inclusao', 'users_alteracao.name as usuario_alteracao')
            ->get();
    }

    static function getAllById($id)
    {
        return DB::table('finan_contas_receber')
            ->join('usuario', 'usuario.id', '=', 'finan_contas_receber.usuario_id')
            ->join('finan_forma_pagamento', 'finan_forma_pagamento.id', '=', 'finan_contas_receber.finan_forma_pagamento_id')
            ->join('finan_moeda', 'finan_moeda.id', '=', 'finan_contas_receber.finan_moeda_id')
            ->join('filial', 'filial.id', '=', 'finan_contas_receber.filial_id')
            ->join('users as users_inclusao', 'users_inclusao.id', '=', 'finan_contas_receber.user_in')
            ->leftjoin('users as users_alteracao', 'users_alteracao.id', '=', 'finan_contas_receber.user_up')
            ->leftJoin('conta as conta_bancaria', 'conta_bancaria.id', '=', 'finan_contas_receber.conta_id')
            ->leftJoin('banco as banco', 'banco.id', '=', 'conta_bancaria.banco_id')
            ->select('finan_contas_receber.*', 'banco.nome as banco', 'usuario.nome as nome_usuario', 'finan_forma_pagamento.nome as forma_pagamento', 'finan_moeda.nome as moeda', 'filial.nome as filial', 'users_inclusao.name as usuario_inclusao', 'users_alteracao.name as usuario_alteracao')
            ->where('finan_contas_receber.id', $id)
            ->get();
    }

    static function checkBaixa($id)
    {
        return DB::table('finan_contas_receber')
            ->select('*')
            ->where('id', $id)
            ->first();
    }

    static function getTitulo($idPedido)
    {
        return DB::table('finan_contas_receber')
            ->select('finan_contas_receber.*', 'banco.nome as banco', 'finan_forma_pagamento.nome as forma_pagamento')
            ->join('finan_forma_pagamento', 'finan_forma_pagamento.id', '=', 'finan_contas_receber.finan_forma_pagamento_id')
            ->leftJoin('conta as conta_bancaria', 'conta_bancaria.id', '=', 'finan_contas_receber.conta_id')
            ->leftJoin('banco', 'banco.id', '=', 'conta_bancaria.banco_id')
            ->where('finan_contas_receber.finan_pedido_recebimento_id', $idPedido)
            ->get();
    }

    static function atualizaTitulos($id, $valor, $usuario)
    {
        $update_colunas = array(
            'valor' => $valor,
            'user_up' => $usuario
        );

        return DB::table('finan_contas_receber')
            ->where('finan_pedido_recebimento_id', $id)
            ->update($update_colunas);
    }

    static function consulta($data)
    {
        $query = DB::table('finan_contas_receber')
            ->join('usuario', 'usuario.id', '=', 'finan_contas_receber.usuario_id')
            ->join('finan_forma_pagamento', 'finan_forma_pagamento.id', '=', 'finan_contas_receber.finan_forma_pagamento_id')
            ->join('finan_moeda', 'finan_moeda.id', '=', 'finan_contas_receber.finan_moeda_id')
            ->join('filial', 'filial.id', '=', 'finan_contas_receber.filial_id')
            ->join('users as users_inclusao', 'users_inclusao.id', '=', 'finan_contas_receber.user_in')
            ->leftjoin('users as users_alteracao', 'users_alteracao.id', '=', 'finan_contas_receber.user_up')
            ->leftJoin('conta as conta_bancaria', 'conta_bancaria.id', '=', 'finan_contas_receber.conta_id')
            ->leftJoin('banco as banco', 'banco.id', '=', 'conta_bancaria.banco_id')
            ->select('finan_contas_receber.*', 'banco.nome as banco', 'usuario.nome as nome_usuario', 'finan_forma_pagamento.nome as forma_pagamento', 'finan_moeda.nome as moeda', 'filial.nome as filial', 'users_inclusao.name as usuario_inclusao', 'users_alteracao.name as usuario_alteracao');

        if(!empty($data['emissao_de']))
        {
            $query->where('emissao','>=',$data['emissao_de']);
        }

        if(!empty($data['emissao_ate']))
        {
            $query->where('emissao','<=',$data['emissao_ate']);
        }

        if(!empty($data['vencimento_de']))
        {
            $query->where('vencimento','>=',$data['vencimento_de']);
        }

        if(!empty($data['vencimento_ate']))
        {
            $query->where('vencimento','<=',$data['vencimento_ate']);
        }

        if($data['status'] == "Pagos")
        {
            $query->where('baixa','<>',' ');
        }else{
            $query->where('baixa','=',null);
        }

        return $query->get();
    }
}

