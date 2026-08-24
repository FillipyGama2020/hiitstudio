<?php $rota = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'); ?>
<div class="sidebar" id="sidebar">
    <button class="close-sidebar" onclick="document.getElementById('sidebar').classList.remove('active')"><i class="fas fa-times"></i></button>
    <div class="sidebar-logo"><img src="<?= asset('user-img/logo-l.png') ?>" width="130px"></div>
    <div class="sidebar-menu">
        <a href="<?= url('admin/alunos') ?>" class="<?= str_starts_with($rota, 'admin/alunos') ? 'active' : '' ?>"><i class="fas fa-users"></i> Alunos</a>
        <a href="<?= url('admin/aulas') ?>" class="<?= str_starts_with($rota, 'admin/aulas') ? 'active' : '' ?>"><i class="fas fa-calendar-alt"></i> Aulas</a>
        <a href="<?= url('admin/pacotes') ?>" class="<?= str_starts_with($rota, 'admin/pacotes') ? 'active' : '' ?>"><i class="fas fa-box"></i> Pacotes</a>
        <a href="<?= url('admin/cupons') ?>" class="<?= str_starts_with($rota, 'admin/cupons') ? 'active' : '' ?>"><i class="fas fa-tags"></i> Cupons</a>
        <a href="<?= url('dashboard') ?>"><i class="fas fa-arrow-left"></i> Voltar ao Site</a>
        <a href="<?= url('logout') ?>"><i class="fas fa-sign-out-alt"></i> Sair</a>
    </div>
</div>
<button class="mobile-menu-toggle" onclick="document.getElementById('sidebar').classList.add('active')"><i class="fas fa-bars"></i></button>
