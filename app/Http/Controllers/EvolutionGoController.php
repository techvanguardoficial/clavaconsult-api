<?php

namespace App\Http\Controllers;

use App\Models\UnitAddress;
use App\Services\EvolutionGoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RuntimeException;
use Throwable;

class EvolutionGoController extends Controller
{
    public function __construct(private readonly EvolutionGoService $evolution) {}

    // ── Listar todas as instâncias (global) ───────────────────────────────────

    public function index(): JsonResponse
    {
        return $this->respond(fn () => $this->evolution->listInstances());
    }

    // ── Criar e vincular instância a uma unidade ──────────────────────────────

    public function storeForUnit(Request $request, UnitAddress $unit): JsonResponse
    {
        if ($unit->evolution_instance_id) {
            return response()->json(['message' => 'Unidade já possui uma instância vinculada.'], 409);
        }

        $data = $request->validate([
            'webhook_url' => 'nullable|url',
        ]);

        return $this->respond(function () use ($unit, $data) {
            $slug = \Illuminate\Support\Str::slug($unit->unit_name);
            $instanceName = "{$slug}-" . now()->valueOf();
            $result = $this->evolution->createInstance(
                name:       $instanceName,
                webhookUrl: $data['webhook_url'] ?? null,
            );

            $instanceData = $result['data'] ?? $result;
            $unit->update([
                'evolution_instance_id' => $instanceData['id'],
                'evolution_token'       => $instanceData['token'],
            ]);

            return $result;
        }, 201);
    }

    // ── Conectar instância de uma unidade (retorna QR code) ───────────────────

    public function connectUnit(Request $request, UnitAddress $unit): JsonResponse
    {
        if (!$unit->evolution_token) {
            return response()->json(['message' => 'Unidade não possui instância vinculada.'], 404);
        }

        $data = $request->validate([
            'webhook_url' => 'nullable|url',
            'subscribe'   => 'nullable|array',
            'subscribe.*' => 'string',
        ]);

        return $this->respond(
            fn () => $this->evolution->connectInstance(
                instanceApiKey: $unit->evolution_token,
                webhookUrl:     $data['webhook_url'] ?? null,
                subscribe:      $data['subscribe'] ?? null,
            )
        );
    }

    // ── Desconectar instância de uma unidade ──────────────────────────────────

    public function disconnectUnit(UnitAddress $unit): JsonResponse
    {
        if (!$unit->evolution_token) {
            return response()->json(['message' => 'Unidade não possui instância vinculada.'], 404);
        }

        return $this->respond(
            fn () => $this->evolution->disconnectInstance($unit->evolution_token)
        );
    }

    // ── Deletar instância de uma unidade ──────────────────────────────────────

    public function destroyUnit(UnitAddress $unit): JsonResponse
    {
        if (!$unit->evolution_instance_id) {
            return response()->json(['message' => 'Unidade não possui instância vinculada.'], 404);
        }

        return $this->respond(function () use ($unit) {
            $result = $this->evolution->deleteInstance($unit->evolution_instance_id);
            $unit->update([
                'evolution_instance_id' => null,
                'evolution_token'       => null,
            ]);
            return $result;
        });
    }

    // ── QR Code da instância de uma unidade ───────────────────────────────────

    public function qrCodeUnit(UnitAddress $unit): JsonResponse
    {
        if (!$unit->evolution_token) {
            return response()->json(['message' => 'Unidade não possui instância vinculada.'], 404);
        }

        return $this->respond(
            fn () => $this->evolution->getQrCode($unit->evolution_token)
        );
    }

    // ── Status da instância de uma unidade ────────────────────────────────────

    public function statusUnit(UnitAddress $unit): JsonResponse
    {
        if (!$unit->evolution_token) {
            return response()->json([
                'data' => ['Connected' => false, 'LoggedIn' => false, 'Name' => null],
                'message' => 'no_instance',
            ]);
        }

        return $this->respond(
            fn () => $this->evolution->getStatus($unit->evolution_token)
        );
    }

    // ── Helper ────────────────────────────────────────────────────────────────

    private function respond(callable $action, int $successStatus = 200): JsonResponse
    {
        try {
            return response()->json($action(), $successStatus);
        } catch (RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 502);
        } catch (Throwable $e) {
            return response()->json(['message' => 'Erro interno ao comunicar com Evolution Go.'], 500);
        }
    }
}
