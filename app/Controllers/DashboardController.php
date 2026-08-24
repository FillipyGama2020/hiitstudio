<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Booking;
use App\Models\ClassSession;
use App\Models\User;

final class DashboardController extends Controller
{
    public function index(): string
    {
        Auth::requireLogin();

        $user = $this->user();
        User::expirarFichasVencidas();
        $user = User::find($user['id']);

        $aulas = ClassSession::proximasParaUsuario($user['id']);
        $ocupados = ClassSession::aparelhosOcupados();
        $totalAgendadas = Booking::totalFuturasParaUsuario($aulas);

        $modalidades = array_values(array_unique(array_column($aulas, 'modalidade')));
        sort($modalidades);
        $professores = array_values(array_unique(array_column($aulas, 'professor')));
        sort($professores);

        return $this->view('dashboard.index', [
            'user' => $user,
            'aulas' => $aulas,
            'ocupados' => $ocupados,
            'totalAgendadas' => $totalAgendadas,
            'modalidades' => $modalidades,
            'professores' => $professores,
            'isAdmin' => Auth::isAdmin(),
        ], layout: null);
    }

    public function agendar(): never
    {
        Auth::requireLogin();
        header('Content-Type: application/json');

        $aulaId = (int) $this->input('aula');
        $aparelhoId = (int) $this->input('aparelho');

        try {
            Booking::criar(Auth::id(), $aulaId, $aparelhoId);
            echo json_encode(['sucesso' => true, 'mensagem' => "Aula agendada com sucesso no aparelho $aparelhoId!"]);
        } catch (\RuntimeException $exception) {
            echo json_encode(['sucesso' => false, 'erro' => $exception->getMessage()]);
        }

        exit;
    }

    public function cancelar(): never
    {
        Auth::requireLogin();

        $agendamentoId = (int) $this->input('id');
        $detalhes = Booking::detalhesParaCancelamento($agendamentoId, Auth::id());

        if (!$detalhes) {
            flash('erro', 'Agendamento nao encontrado.');
            redirect('minha-agenda');
        }

        if (!Booking::podeCancelar($detalhes)) {
            flash('erro', 'O cancelamento so e permitido com 1 hora de antecedencia.');
            redirect('minha-agenda');
        }

        $cancelado = Booking::cancelar($agendamentoId, Auth::id());

        flash($cancelado ? 'sucesso' : 'erro', $cancelado
            ? 'Agendamento cancelado e ficha devolvida!'
            : 'Este agendamento ja havia sido cancelado.');

        redirect('minha-agenda');
    }

    public function agenda(): string
    {
        Auth::requireLogin();

        $offset = (int) $this->input('semana', 0);
        $inicio = strtotime('monday this week' . ($offset >= 0 ? " +$offset week" : " $offset week"));
        $fim = strtotime('+6 days', $inicio);

        $agendamentos = Booking::daSemana(Auth::id(), date('Y-m-d', $inicio), date('Y-m-d', $fim));

        return $this->view('dashboard.agenda', [
            'agendamentos' => $agendamentos,
            'inicio' => $inicio,
            'fim' => $fim,
            'offset' => $offset,
        ], layout: null);
    }
}
