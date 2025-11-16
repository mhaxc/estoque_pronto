<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transferencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'produto_id',
        'quantidade',
        'origem',
        'destino',
        'data_transferencia',
        'funcionario_id',
        'observacao',
       
    ];

    protected $casts = [
        'data_transferencia' => 'date',
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