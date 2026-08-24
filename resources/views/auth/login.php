<?php $erro = flash('erro'); $sucesso = flash('sucesso'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Login | Hiitstudio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900%7COswald:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('user-css/style-login.css') ?>">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <h2>Acessar Conta</h2>

            <?php if ($erro): ?>
                <p style="color: #ff3e3e; text-align: center; font-weight: bold; margin-bottom: 15px;"><?= e($erro) ?></p>
            <?php endif; ?>
            <?php if ($sucesso): ?>
                <p style="color: #34A853; text-align: center; font-weight: bold; margin-bottom: 15px;"><?= e($sucesso) ?></p>
            <?php endif; ?>

            <form action="<?= url('login') ?>" method="POST">
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Senha</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" class="btn-auth">Entrar</button>
            </form>

            <div class="login-container">
                <p>OU</p>
                <a href="<?= url('auth/google') ?>" class="google-btn">
                    <span class="google-text">Entrar com Google</span>
                </a>
            </div>

            <div class="auth-footer">
                Ainda nao tem conta? <a href="<?= url('cadastro') ?>">Cadastre-se aqui</a>
            </div>
            <div class="auth-footer" style="font-size:12px;">
                <a href="<?= url('recuperar-senha') ?>">Quero recuperar minha senha</a>
            </div>
        </div>
    </div>
</body>
</html>
