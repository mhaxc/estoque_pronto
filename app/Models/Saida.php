<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Saida extends Model
{
    use HasFactory;

    protected $fillable = [
        'produto_id',
        'quantidade',
        'data_saida',
        'funcionario_id',
        'observacao'
    ];

    protected $casts = [
        'data_saida' => 'date',
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }

    protected static function booted()
    {
        

        static::created(function ($saida) {
            $saida->produto->atualizarEstoque($saida->quantidade, 'saida');
        });

        static::updating(function ($saida) {
            $saida->valor_total = $saida->quantidade * $saida->valor_unitario;
        });
    }
}
