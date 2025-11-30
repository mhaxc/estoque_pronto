<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntradaProduto extends Model
{
    use HasFactory;

    protected $table = 'entrada_produtos';

    protected $fillable = [
        'entrada_id',
        'produto_id',
        'quantidade'
    ];

    public function entrada()
    {
        return $this->belongsTo(Entrada::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
