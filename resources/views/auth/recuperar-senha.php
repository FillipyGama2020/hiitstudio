<?php $erro = flash('erro'); $sucesso = flash('sucesso'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Recuperacao | Hiitstudio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900%7COswald:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('user-css/style-login.css') ?>">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <h2>Recuperacao de Conta</h2>

            <?php if ($erro): ?>
                <p style="color: #ff3e3e; text-align: center; font-weight: bold; margin-bottom: 15px;"><?= e($erro) ?></p>
            <?php endif; ?>
            <?php if ($sucesso): ?>
                <p style="color: #34A853; text-align: center; font-weight: bold; margin-bottom: 15px;"><?= e($sucesso) ?></p>
            <?php endif; ?>

            <br>
            <p>Digite seu e-mail para receber um link de redefinicao.</p>
            <form action="<?= url('recuperar-senha') ?>" method="POST">
                <div class="form-group">
                    <input type="email" name="email" placeholder="Seu e-mail cadastrado" required>
                </div>
                <button type="submit" class="btn-auth">Enviar Link</button>
            </form>
        </div>
    </div>
</body>
</html>
