<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'categoria_id',
        'unidade_id',
        'preco',
        'estoque_minimo',
        'estoque_atual',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }

    public function entradas()
    {
        return $this->hasMany(Entrada::class);
    }

    public function saidas()
    {
        return $this->hasMany(Saida::class);
    }

    public function transferencias()
    {
        return $this->hasMany(Transferencia::class);
    }
    public function atualiarzEstoque($quantidade, $tipo = 'entrada')
    {
        if ($tipo === 'entrada') {
            $this->estoque_atual += $quantidade;
        } else {
            $this->estoque_atual -= $quantidade;
        }
        $this->save();
    }

    public function estaComEstoqueBaixo()
    {
        return $this->estoque_atual <= $this->estoque_minimo;
    }


}
