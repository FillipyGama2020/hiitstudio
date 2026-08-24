<?php $erro = flash('erro'); $sucesso = flash('sucesso'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Redefinir Senha | Hiitstudio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900%7COswald:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('user-css/style-login.css') ?>">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <h2>Nova Senha</h2>

            <?php if ($erro): ?>
                <p style="color: #ff3e3e; text-align: center; font-weight: bold; margin-bottom: 15px;"><?= e($erro) ?></p>
            <?php endif; ?>

            <?php if ($sucesso): ?>
                <p style="color: #34A853; text-align: center; font-weight: bold; margin-bottom: 15px;"><?= e($sucesso) ?></p>
                <div class="auth-footer">
                    <a href="<?= url('login') ?>" class="btn-auth" style="display:block; text-align:center; text-decoration:none; line-height:40px;">Voltar ao Login</a>
                </div>
            <?php elseif ($pedido): ?>
                <p style="text-align: center; margin-bottom: 20px;">Crie uma nova senha para sua conta.</p>
                <form action="<?= url('redefinir-senha?token=' . urlencode($token)) ?>" method="POST">
                    <div class="form-group">
                        <label>Nova Senha</label>
                        <input type="password" name="password" required minlength="6">
                    </div>
                    <div class="form-group">
                        <label>Confirmar Nova Senha</label>
                        <input type="password" name="confirm_password" required minlength="6">
                    </div>
                    <button type="submit" class="btn-auth">Atualizar Senha</button>
                </form>
            <?php else: ?>
                <p style="text-align: center;">Este link de recuperacao e invalido ou ja expirou.</p>
            <?php endif; ?>

            <div class="auth-footer" style="margin-top: 20px;">
                Lembrou a senha? <a href="<?= url('login') ?>">Voltar para o login</a>
            </div>
        </div>
    </div>
</body>
</html>
