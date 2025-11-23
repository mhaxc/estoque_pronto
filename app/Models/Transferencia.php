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

    public function produtos()
    {
        return $this->hasMany(Transferenciaitem::class);
    }

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }


}