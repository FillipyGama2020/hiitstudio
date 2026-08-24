<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Booking;
use App\Models\ClassSession;
use App\Models\User;

final class ClassController extends Controller
{
    private const USUARIO_MANUTENCAO_ID = 999;

    public function index(): string
    {
        Auth::requireAdmin();

        $aulas = ClassSession::comFiltros($this->input('f_data'), $this->input('f_modalidade'));

        return $this->view('admin.aulas', [
            'aulas' => $aulas,
            'filtroData' => $this->input('f_data', ''),
            'filtroModalidade' => $this->input('f_modalidade', ''),
        ], layout: null);
    }

    public function salvar(): never
    {
        Auth::requireAdmin();

        $dados = [
            'professor' => trim((string) $this->input('professor')),
            'modalidade' => trim((string) $this->input('modalidade')),
            'data_aula' => $this->input('data'),
            'horario' => $this->input('horario'),
            'vagas_totais' => (int) $this->input('vagas'),
            'vagas_disponiveis' => (int) $this->input('vagas'),
        ];

        $id = $this->input('id_aula');

        if ($id) {
            ClassSession::update((int) $id, $dados);
        } else {
            ClassSession::insert($dados);
        }

        redirect('admin/aulas?msg=Sucesso');
    }

    public function excluir(): never
    {
        Auth::requireAdmin();

        $id = (int) $this->input('excluir');

        User::beginTransaction();

        $agendados = Booking::usuariosAgendados($id, self::USUARIO_MANUTENCAO_ID);

        foreach ($agendados as $usuarioId) {
            User::creditarFicha((int) $usuarioId);
        }

        Booking::removerTodosDaAula($id);
        ClassSession::delete($id);

        User::commit();

        $quantidade = count($agendados);
        $mensagem = $quantidade > 0 ? "Aula removida e $quantidade ficha(s) estornada(s) aos alunos agendados" : 'Aula removida';

        redirect('admin/aulas?msg=' . urlencode($mensagem));
    }

    public function detalhes(int $id): string
    {
        Auth::requireAdmin();

        $aula = ClassSession::find($id);

        if (!$aula) {
            exit('Aula nao encontrada.');
        }

        if ($this->input('toggle_aparelho')) {
            Booking::alternarManutencao($id, (int) $this->input('aparelho_id'), self::USUARIO_MANUTENCAO_ID);
            redirect("admin/aulas/$id");
        }

        $ocupacoes = ClassSession::ocupantes($id);
        $ocupados = [];

        foreach ($ocupacoes as $ocupacao) {
            $ocupados[$ocupacao['aparelho_id']] = [
                'nome' => (int) $ocupacao['usuario_id'] === self::USUARIO_MANUTENCAO_ID ? 'INATIVO' : $ocupacao['nome'],
                'is_manutencao' => (int) $ocupacao['usuario_id'] === self::USUARIO_MANUTENCAO_ID,
            ];
        }

        return $this->view('admin.detalhes-aula', ['aula' => $aula, 'ocupados' => $ocupados], layout: null);
    }
}
