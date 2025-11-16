<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
     use HasFactory;

    protected $fillable = [
        'produto_id',
        'quantidade',
        'data_entrada',
        'observacao',
        'funcionario_id',
        'numero_nota'
    ];

    protected $casts = [
        'data_entrada' => 'date'
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }

}
