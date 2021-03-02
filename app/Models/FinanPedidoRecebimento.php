<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class FinanPedidoRecebimento extends Model
{
    use HasFactory;

    protected $table = 'finan_pedido_recebimento';

    protected $fillable = ['id', 'usuario_id', 'emissao', 'data_vencimento', 'valor_total', 'filial_id', 'finan_forma_pagamento_id', 'finan_caixa_id', 'finan_cambio_id', 'semestre_letivo_id', 'semestre_oferta_disciplina_id', 'avaliacao_id', 'status', 'user_in', 'user_up'];

    public function itens()
    {
        return $this->hasMany(FinanItemPedidoRecebimento::class, 'pedido_recebimento_id', 'id');
    }

    static function block($id)
    {
        return DB::table('finan_pedido_recebimento')
            ->where('id', $id)
            ->update(['status' => '0']);
    }

    static function unlock($id)
    {
        return DB::table('finan_pedido_recebimento')
            ->where('id', $id)
            ->update(['status' => '1']);
    }

    static function getAll()
    {
        return DB::table('finan_pedido_recebimento')
            ->join('usuario', 'usuario.id', '=', 'usuario_id')
            ->join('filial', 'filial.id', '=', 'finan_pedido_recebimento.filial_id')
            ->leftJoin('finan_forma_pagamento', 'finan_forma_pagamento.id', '=', 'finan_forma_pagamento_id')
            ->join('finan_cambio', 'finan_cambio.id', '=', 'finan_cambio_id')
            ->leftJoin('semestre_letivo', 'semestre_letivo.id', '=', 'finan_pedido_recebimento.semestre_letivo_id')
            ->leftjoin('semestre_oferta_disciplina', 'semestre_oferta_disciplina.id', '=', 'finan_pedido_recebimento.semestre_oferta_disciplina_id')
            ->leftjoin('avaliacao', 'avaliacao.id', '=', 'finan_pedido_recebimento.avaliacao_id')
            ->select('finan_pedido_recebimento.*', 'usuario.nome as usuario', 'filial.nome as filial',
                'finan_forma_pagamento.nome as Forma_pagamento', 'finan_cambio.nome as Cambio',
                'semestre_letivo.nome as Semestre Letivo','semestre_oferta_disciplina.nome as Oferta Disciplina')
            ->get();
    }

    static function getPedidoById($id)
    {
        return self::query()
            ->select('finan_pedido_recebimento.*', 'usuario.nome as usuario', 'filial.nome as filial',
                'finan_forma_pagamento.nome as Forma_pagamento', 'finan_cambio.nome as Cambio',
                'semestre_letivo.nome as Semestre Letivo','semestre_oferta_disciplina.nome as Oferta Disciplina')
            ->join('usuario', 'usuario.id', '=', 'usuario_id')
            ->join('filial', 'filial.id', '=', 'finan_pedido_recebimento.filial_id')
            ->join('finan_forma_pagamento', 'finan_forma_pagamento.id', '=', 'finan_forma_pagamento_id')
            ->join('finan_cambio', 'finan_cambio.id', '=', 'finan_cambio_id')
            ->join('semestre_letivo', 'semestre_letivo.id', '=', 'finan_pedido_recebimento.semestre_letivo_id')
            ->leftjoin('semestre_oferta_disciplina', 'semestre_oferta_disciplina.id', '=', 'finan_pedido_recebimento.semestre_oferta_disciplina_id')
            ->leftjoin('avaliacao', 'avaliacao.id', '=', 'finan_pedido_recebimento.avaliacao_id')
            ->with('itens')
            ->find($id);
    }

    static function getFormaPagamento($id)
    {
        return DB::table('finan_pedido_recebimento')
            ->join('finan_forma_pagamento', 'finan_forma_pagamento.id', '=', 'finan_forma_pagamento_id')
            ->select('finan_forma_pagamento.qtdparc')
            ->where('finan_pedido_recebimento.id', $id)
            ->first();
    }
}
