<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransferenciaItem extends Model
{
   



    use HasFactory;

    protected $fillable = [
        'transferencia_id',
        'produto_id',
        'quantidade'
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function transferencia()
    {
        return $this->belongsTo(Transferencia::class);
    }

}
