<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\User;

final class StudentController extends Controller
{
    public function index(): string
    {
        Auth::requireAdmin();

        $termo = trim((string) $this->input('q', ''));
        $alunos = User::search($termo);

        return $this->view('admin.alunos', ['alunos' => $alunos, 'termo' => $termo], layout: null);
    }

    public function ativar(): never
    {
        Auth::requireAdmin();
        User::setStatus((int) $this->input('ativar'), 1);
        redirect('admin/alunos?msg=Ativado');
    }

    public function inativar(): never
    {
        Auth::requireAdmin();
        User::setStatus((int) $this->input('inativar'), 2);
        redirect('admin/alunos?msg=Inativado');
    }

    public function atualizar(): never
    {
        Auth::requireAdmin();

        User::update((int) $this->input('id_usuario'), [
            'fichas' => (int) $this->input('fichas'),
            'nivel_acesso' => $this->input('nivel_acesso'),
        ]);

        redirect('admin/alunos?msg=Atualizado');
    }
}
