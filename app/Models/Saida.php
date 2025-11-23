<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Saida extends Model
{
protected $fillable = [
'funcionario_id',
'data_saida',
'observacao',
];


public function funcionario()
{
return $this->belongsTo(Funcionario::class);
}


public function items()
{
return $this->hasMany(SaidaItem::class);
}
};