<?php

namespace App\Console\Commands;

use App\Models\Produto;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckLowStock extends Command
{
    protected $signature = 'check:lowstock';
    protected $description = 'Verifica produtos com estoque baixo e envia alerta';

    public function handle()
    {
        $produtos = Produto::where('estoque_atual', '<=', \DB::raw('estoque_minimo'))->get();

        if ($produtos->count() > 0) {
            // Enviar email ou notificação
            // Aqui você pode adaptar para enviar um email para o responsável
            Mail::send('emails.low_stock', ['produtos' => $produtos], function ($message) {
                $message->to('admin@example.com')
                        ->subject('Alertas de Estoque Baixo');
            });

            $this->info('Alerta de estoque baixo enviado.');
        } else {
            $this->info('Nenhum produto com estoque baixo.');
        }
    }
}