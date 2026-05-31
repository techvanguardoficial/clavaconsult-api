<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Controller;
use App\Models\WhatsappSession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BotSessionController extends Controller
{
    /**
     * Retorna a sessão do número. Cria automaticamente se não existir.
     */
    public function get(string $phone): JsonResponse
    {
        $session = WhatsappSession::firstOrCreate(
            ['phone' => $this->normalize($phone)],
            ['step' => 'idle', 'mode' => 'bot', 'data' => [], 'history' => []]
        );

        return response()->json($session);
    }

    /**
     * Atualiza campos da sessão (step, mode, data, history).
     * Aceita atualização parcial — só sobrescreve o que for enviado.
     * Para data/history usa merge quando o campo 'merge' = true.
     */
    public function update(Request $request, string $phone): JsonResponse
    {
        $input = $request->validate([
            'step'    => ['sometimes', 'string', 'max:100'],
            'mode'    => ['sometimes', 'string', 'in:bot,human'],
            'data'    => ['sometimes', 'array'],
            'history' => ['sometimes', 'array'],
            // quando true, faz merge de 'data' com o existente em vez de substituir
            'merge'   => ['sometimes', 'boolean'],
        ]);

        $session = WhatsappSession::firstOrCreate(
            ['phone' => $this->normalize($phone)],
            ['step' => 'idle', 'mode' => 'bot', 'data' => [], 'history' => []]
        );

        $merge = $input['merge'] ?? false;
        unset($input['merge']);

        if ($merge && isset($input['data'])) {
            $input['data'] = array_merge($session->data ?? [], $input['data']);
        }

        if ($merge && isset($input['history'])) {
            $input['history'] = array_merge($session->history ?? [], $input['history']);
        }

        $session->update($input);

        return response()->json($session->fresh());
    }

    /**
     * Reseta a sessão para o estado inicial (volta ao bot, limpa dados).
     */
    public function reset(string $phone): JsonResponse
    {
        $session = WhatsappSession::where('phone', $this->normalize($phone))->first();

        if ($session) {
            $session->update([
                'step'    => 'idle',
                'mode'    => 'bot',
                'data'    => [],
                'history' => [],
            ]);
        }

        return response()->json(['reset' => true]);
    }

    /**
     * Remove dígitos não numéricos do telefone para normalização.
     */
    private function normalize(string $phone): string
    {
        return preg_replace('/\D+/', '', $phone);
    }
}
