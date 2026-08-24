<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Coupon;

final class CouponController extends Controller
{
    public function index(): string
    {
        Auth::requireAdmin();

        return $this->view('admin.cupons', ['cupons' => Coupon::all('id DESC')], layout: null);
    }

    public function salvar(): never
    {
        Auth::requireAdmin();

        $idCupom = $this->input('id_cupom') ? (int) $this->input('id_cupom') : null;
        $valor = (float) str_replace(['.', ','], ['', '.'], (string) $this->input('valor'));

        $dados = [
            'codigo' => strtoupper(trim((string) $this->input('codigo'))),
            'tipo' => $this->input('tipo'),
            'valor' => $valor,
            'validade' => $this->input('validade') ?: null,
            'uso_limite' => $this->input('uso_limite') ? (int) $this->input('uso_limite') : null,
        ];

        try {
            if ($idCupom) {
                Coupon::update($idCupom, $dados);
            } else {
                Coupon::insert([...$dados, 'uso_contagem' => 0, 'status' => 'ativo']);
            }

            redirect('admin/cupons?msg=Sucesso');
        } catch (\PDOException $exception) {
            error_log('Erro ao salvar cupom: ' . $exception->getMessage());
            exit('Erro ao salvar o cupom. Verifique os dados e tente novamente.');
        }
    }

    public function excluir(): never
    {
        Auth::requireAdmin();
        Coupon::delete((int) $this->input('excluir'));
        redirect('admin/cupons?msg=' . urlencode('Cupom removido'));
    }
}
