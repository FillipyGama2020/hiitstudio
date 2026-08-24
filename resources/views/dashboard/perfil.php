<?php $erro = flash('erro'); $sucesso = flash('sucesso'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Editar Perfil | Hiitstudio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,600,700%7COswald:400,700" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('user-css/style-login.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <h2>Meu Perfil</h2>

            <?php if ($erro): ?><p style="color: #ff3e3e; text-align: center; font-weight: bold; margin-bottom: 15px;"><?= e($erro) ?></p><?php endif; ?>
            <?php if ($sucesso): ?><p style="color: #34A853; text-align: center; font-weight: bold; margin-bottom: 15px;"><?= e($sucesso) ?></p><?php endif; ?>

            <form action="<?= url('editar-perfil') ?>" method="POST">
                <div class="form-group">
                    <label>E-mail (Login)</label>
                    <input type="email" value="<?= e($user['email']) ?>" disabled style="background: gray; cursor: not-allowed;">
                </div>
                <div class="form-group">
                    <label>Nome Completo</label>
                    <input type="text" name="nome" value="<?= e($user['nome']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Telefone / WhatsApp</label>
                    <input type="text" name="telefone" value="<?= e($user['telefone'] ?? '') ?>" placeholder="(00) 00000-0000">
                </div>
                <div class="form-group">
                    <label>CPF</label>
                    <input type="text" name="cpf" value="<?= e($user['cpf'] ?? '') ?>" placeholder="000.000.000-00">
                </div>
                <div style="margin: 20px 0; border-top: 1px solid #eee; padding-top: 10px;">
                    <p style="font-size: 0.8rem; color: #888;">Deixe em branco se nao quiser alterar a senha:</p>
                </div>
                <div class="form-group">
                    <label>Nova Senha</label>
                    <input type="password" name="password">
                </div>
                <div class="form-group">
                    <label>Confirmar Senha</label>
                    <input type="password" name="confirm_password">
                </div>
                <button type="submit" class="btn-auth">Salvar Alteracoes</button>
            </form>

            <div class="auth-footer" style="margin-top: 20px;">
                <a href="<?= url('dashboard') ?>" style="text-decoration: none; color: white; font-weight: bold;">
                    <i class="fas fa-chevron-left"></i> Voltar ao Painel
                </a>
            </div>
        </div>
    </div>
</body>
</html>
