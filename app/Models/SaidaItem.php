<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaidaItem extends Model
{
    protected $fillable = [
        'saida_id',
        'produto_id',
        'quantidade',
    ];

    public function saida()
{
return $this->belongsTo(Saida::class);
}


public function produto()
{
return $this->belongsTo(Produto::class);
}


}
