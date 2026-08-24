<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Package;
use App\Models\User;
use App\Services\PagarmeGateway;

final class PackageController extends Controller
{
    public function index(): string
    {
        Auth::requireAdmin();

        $pacotes = Package::all('categoria ASC, preco ASC');

        return $this->view('admin.pacotes', ['pacotes' => $pacotes], layout: null);
    }

    public function salvar(): never
    {
        Auth::requireAdmin();

        $nome = trim((string) $this->input('nome'));
        $fichas = (int) $this->input('fichas');
        $preco = (float) str_replace(['.', ','], ['', '.'], (string) $this->input('preco'));
        $intervaloQuantidade = (int) $this->input('interval_count');
        $intervaloTipo = (string) $this->input('interval_type');
        $descricao = trim((string) $this->input('descricao'));
        $categoria = (string) $this->input('categoria');
        $idPacote = $this->input('id_pacote') ? (int) $this->input('id_pacote') : null;
        $maxParcelas = max(1, (int) $this->input('max_parcelas', 1));

        $multiplicador = match ($intervaloTipo) {
            'month' => 30,
            'year' => 365,
            default => 1,
        };
        $validadeDias = $intervaloQuantidade * $multiplicador;

        $planoId = null;
        $precoAntigo = 0.0;

        if ($idPacote) {
            $atual = Package::find($idPacote);
            $planoId = $atual['mp_plan_id'] ?? null;
            $precoAntigo = (float) ($atual['preco'] ?? 0);
        }

        if ($categoria === 'assinatura' && $maxParcelas > 1) {
            $planoId = null;
        } elseif ($categoria === 'assinatura') {
            $precoCentavos = (int) round($preco * 100);
            $precoAntigoCentavos = (int) round($precoAntigo * 100);

            if (!$idPacote || $precoCentavos !== $precoAntigoCentavos || empty($planoId)) {
                $gateway = new PagarmeGateway();
                $resposta = $gateway->criarPlano([
                    'name' => $nome,
                    'description' => $descricao,
                    'shippable' => false,
                    'payment_methods' => ['credit_card'],
                    'interval' => $intervaloTipo,
                    'interval_count' => $intervaloQuantidade,
                    'billing_type' => 'prepaid',
                    'currency' => 'BRL',
                    'statement_descriptor' => 'HIITSTUDIO',
                    'items' => [[
                        'name' => "Assinatura Recorrente - $nome",
                        'quantity' => 1,
                        'pricing_scheme' => ['scheme_type' => 'unit', 'price' => $precoCentavos],
                    ]],
                ]);

                if ($resposta['status_code'] >= 200 && $resposta['status_code'] < 300 && isset($resposta['body']['id'])) {
                    $planoId = $resposta['body']['id'];
                } else {
                    http_response_code(422);
                    exit('Erro ao sincronizar com a Pagar.me.');
                }
            }
        }

        $dados = [
            'nome' => $nome,
            'fichas' => $fichas,
            'preco' => $preco,
            'validade_dias' => $validadeDias,
            'mp_interval_type' => $intervaloTipo,
            'descricao' => $descricao,
            'categoria' => $categoria,
            'mp_plan_id' => $planoId,
            'max_parcelas' => $maxParcelas,
        ];

        if ($idPacote) {
            Package::update($idPacote, $dados);
        } else {
            Package::insert($dados);
        }

        redirect('admin/pacotes?msg=Sucesso');
    }

    public function excluir(): never
    {
        Auth::requireAdmin();

        $id = (int) $this->input('excluir');
        $pacote = Package::find($id);

        if ($pacote && $pacote['categoria'] === 'assinatura' && !empty($pacote['mp_plan_id'])) {
            $gateway = new PagarmeGateway();
            $usuarios = User::assinantesDoPlano($pacote['mp_plan_id']);

            foreach ($usuarios as $usuario) {
                $gateway->cancelarAssinatura($usuario['mp_subscription_id']);
                User::cancelarAssinatura((int) $usuario['id']);
            }
        }

        Package::delete($id);

        redirect('admin/pacotes?msg=' . urlencode('Pacote removido e assinaturas canceladas'));
    }
}
