<?php $erro = flash('erro'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Cadastro | Hiitstudio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900%7COswald:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('user-css/style-login.css') ?>">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <h2>Novo Membro</h2>

            <?php if ($erro): ?>
                <div class="alert erro"><?= e($erro) ?></div><br>
            <?php endif; ?>

            <form action="<?= url('cadastro') ?>" method="POST">
                <div class="form-group">
                    <label>Nome Completo</label>
                    <input type="text" name="nome" required>
                </div>
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Telefone de Contato</label>
                    <input type="tel" name="telefone" placeholder="(00) 00000-0000" required>
                </div>
                <div class="form-group">
                    <label>CPF</label>
                    <input type="text" name="cpf" placeholder="000.000.000-00" required>
                </div>
                <div class="form-group">
                    <label>Data de nascimento</label>
                    <input type="date" name="data" required>
                </div>
                <div class="form-group">
                    <label>Crie uma Senha</label>
                    <input type="password" name="password" required minlength="6">
                </div>
                <button type="submit" class="btn-auth">Finalizar Cadastro</button>
            </form>

            <div class="auth-footer">
                Ja possui conta? <a href="<?= url('login') ?>">Fazer Login</a>
            </div>
        </div>
    </div>
</body>
</html>
