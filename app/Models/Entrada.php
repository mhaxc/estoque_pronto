<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    use HasFactory;

    protected $fillable = [
        'funcionario_id',
        'numero_nota',
        'data_entrada',
        'observacao'
    ];

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'entrada_produtos')
            ->withPivot('quantidade')
            ->withTimestamps();
    }

    public function funcionario()
    {
        return $this->belongsTo(User::class, 'funcionario_id');
    }

    public function getValorTotalAttribute()
{
    return $this->produtos->sum(function($produto) {
        return ($produto->pivot->quantidade ?? 0) * ($produto->preco ?? 0);
    });
}
}
