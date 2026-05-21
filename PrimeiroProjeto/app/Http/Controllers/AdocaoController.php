<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Adocao;
use App\Models\Favorito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class AdocaoController extends Controller
{
    // Solicitar adoção
    public function solicitar(Request $request, Animal $animal)
    {
        // Verificar se é o próprio anúncio
        if (auth()->id() === $animal->user_id) {
            return back()->with('error', 'Você não pode solicitar adoção do seu próprio animal.');
        }
        
        // Verificar se animal já foi adotado
        if ($animal->adotado) {
            return back()->with('error', 'Este animal já foi adotado.');
        }
        
        // Verificar se já existe solicitação pendente
        $solicitacaoExistente = Adocao::where('animal_id', $animal->id)
            ->where('adotante_id', auth()->id())
            ->whereIn('status', ['pendente', 'aprovada'])
            ->first();
            
        if ($solicitacaoExistente) {
            return back()->with('error', 'Você já possui uma solicitação para este animal.');
        }
        
        try {
            Adocao::create([
                'animal_id' => $animal->id,
                'adotante_id' => auth()->id(),
                'doador_id' => $animal->user_id,
                'status' => 'pendente',
            ]);
            
            return back()->with('success', 'Solicitação de adoção enviada ao anunciante!');
            
        } catch (Exception $e) {
            Log::error('Erro ao solicitar adoção: ' . $e->getMessage());
            return back()->with('error', 'Erro ao enviar solicitação.');
        }
    }
    
    // Salvar nos favoritos
    public function favoritar(Animal $animal)
    {
        // Verificar se é o próprio anúncio
        if (auth()->id() === $animal->user_id) {
            return back()->with('error', 'Você não pode favoritar seu próprio anúncio.');
        }
        
        try {
            $favorito = Favorito::where('animal_id', $animal->id)
                ->where('user_id', auth()->id())
                ->first();
            
            if ($favorito) {
                $favorito->delete();
                $message = 'Anúncio removido dos favoritos.';
            } else {
                Favorito::create([
                    'animal_id' => $animal->id,
                    'user_id' => auth()->id(),
                ]);
                $message = 'Anúncio salvo nos favoritos!';
            }
            
            return back()->with('success', $message);
            
        } catch (Exception $e) {
            Log::error('Erro ao favoritar: ' . $e->getMessage());
            return back()->with('error', 'Erro ao processar solicitação.');
        }
    }
    
    // Notificações do doador
    public function notificacoes()
    {
        $notificacoes = Adocao::where('doador_id', auth()->id())
            ->where('status', 'pendente')
            ->with(['animal', 'adotante'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('notificacoes', compact('notificacoes'));
    }
    
    // Responder solicitação
    public function responder(Request $request, Adocao $adocao)
    {
        // Verificar se é o doador
        if (auth()->id() !== $adocao->doador_id) {
            return back()->with('error', 'Sem permissão.');
        }
        
        $request->validate([
            'status' => 'required|in:aprovada,recusada',
        ]);
        
        try {
            if ($request->status === 'aprovada') {
                $adocao->aprovar();
                $message = 'Solicitação aprovada! O animal foi marcado como adotado.';
            } else {
                $adocao->recusar();
                $message = 'Solicitação recusada.';
            }
            
            return back()->with('success', $message);
            
        } catch (Exception $e) {
            Log::error('Erro ao responder solicitação: ' . $e->getMessage());
            return back()->with('error', 'Erro ao processar solicitação.');
        }
    }
    
    // Minhas solicitações (como adotante)
    public function minhasSolicitacoes()
    {
        $solicitacoes = Adocao::where('adotante_id', auth()->id())
            ->with(['animal', 'doador'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('minhas-solicitacoes', compact('solicitacoes'));
    }
    
    // Solicitações recebidas (como doador)
    public function solicitacoesRecebidas()
    {
        $solicitacoes = Adocao::where('doador_id', auth()->id())
            ->with(['animal', 'adotante'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('solicitacoes-recebidas', compact('solicitacoes'));
    }
}