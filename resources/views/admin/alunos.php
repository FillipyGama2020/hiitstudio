<?php $msg = $_GET['msg'] ?? null; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Alunos | Admin Hiitstudio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700%7COswald:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= asset('user-css/style-admin.css') ?>">
</head>
<body>

<?php require __DIR__ . '/_menu.php'; ?>

<div class="main-content">
    <header>
        <h2 class="oswald clr-branco">Alunos</h2>
    </header>

    <div class="container">
        <?php if ($msg): ?><div class="alert sucesso"><?= e($msg) ?></div><?php endif; ?>

        <form method="GET" class="filter-bar">
            <div class="filter-group">
                <label>Buscar</label>
                <input type="text" name="q" value="<?= e($termo) ?>" placeholder="Nome ou e-mail...">
            </div>
            <button type="submit" class="btn-filter"><i class="fas fa-search"></i> Buscar</button>
        </form>

        <div class="tabela-container">
            <table>
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Fichas</th>
                    <th>Validade</th>
                    <th>Status</th>
                    <th>Nivel</th>
                    <th>Acoes</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($alunos as $aluno): ?>
                    <tr>
                        <td><?= e($aluno['nome']) ?></td>
                        <td><?= e($aluno['email']) ?></td>
                        <td>
                            <form method="POST" action="<?= url('admin/alunos') ?>" style="display: flex; gap: 5px;">
                                <input type="hidden" name="id_usuario" value="<?= $aluno['id'] ?>">
                                <input type="hidden" name="nivel_acesso" value="<?= e($aluno['nivel_acesso']) ?>">
                                <input type="number" name="fichas" value="<?= (int) $aluno['fichas'] ?>" style="width: 60px; padding: 6px;">
                                <button type="submit" class="btn-acao" title="Salvar"><i class="fas fa-save"></i></button>
                            </form>
                        </td>
                        <td><?= $aluno['validade_fichas'] ? date('d/m/Y', strtotime($aluno['validade_fichas'])) : '-' ?></td>
                        <td>
                            <?php if ((int) $aluno['status'] === 1): ?>
                                <span class="status-badge status-1">Ativo</span>
                            <?php else: ?>
                                <span class="status-badge status-2">Inativo</span>
                            <?php endif; ?>
                        </td>
                        <td><?= e($aluno['nivel_acesso']) ?></td>
                        <td>
                            <?php if ((int) $aluno['status'] === 1): ?>
                                <a href="<?= url('admin/alunos/inativar?inativar=' . $aluno['id']) ?>" class="btn-acao" onclick="return confirm('Inativar este aluno?')"><i class="fas fa-user-slash"></i></a>
                            <?php else: ?>
                                <a href="<?= url('admin/alunos/ativar?ativar=' . $aluno['id']) ?>" class="btn-acao"><i class="fas fa-user-check"></i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
