<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transferencia extends Model
{
    use HasFactory;
Protected $fillable = [
        'origem',
        'destino',
        'data_transferencia',
        'funcionario_id',
        'observacao'
    ];





protected $casts = [
    'data_transferencia' => 'date',
];

public function funcionario()
{
    return $this->belongsTo(Funcionario::class);
}

public function items()
{
    return $this->hasMany(TransferenciaItem::class);
}

public function produtos()
{
    return $this->belongsToMany(Produto::class, 'transferencia_itens')
        ->withPivot('quantidade');
}
}