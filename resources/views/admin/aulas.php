<?php $msg = $_GET['msg'] ?? null; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Aulas | Admin Hiitstudio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700%7COswald:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= asset('user-css/style-admin.css') ?>">
</head>
<body>

<?php require __DIR__ . '/_menu.php'; ?>

<div class="main-content">
    <header>
        <h2 class="oswald clr-branco">Aulas</h2>
    </header>

    <div class="container">
        <?php if ($msg): ?><div class="alert sucesso"><?= e($msg) ?></div><?php endif; ?>

        <form method="GET" class="filter-bar">
            <div class="filter-group">
                <label>Data</label>
                <input type="date" name="f_data" value="<?= e($filtroData) ?>">
            </div>
            <div class="filter-group">
                <label>Modalidade</label>
                <input type="text" name="f_modalidade" value="<?= e($filtroModalidade) ?>" placeholder="Ex: Pilates">
            </div>
            <button type="submit" class="btn-filter"><i class="fas fa-filter"></i> Filtrar</button>
        </form>

        <div class="grid-aulas">
            <?php foreach ($aulas as $aula): ?>
                <div class="card">
                    <span class="badge"><?= e($aula['modalidade']) ?></span>
                    <h3 class="oswald" style="margin: 10px 0 5px; color: var(--secondary);"><?= date('d/m/Y', strtotime($aula['data_aula'])) ?></h3>
                    <div class="info-item"><i class="far fa-clock"></i> <?= substr($aula['horario'], 0, 5) ?></div>
                    <div class="info-item"><i class="fas fa-chalkboard-user"></i> <?= e($aula['professor']) ?></div>
                    <div class="stats-agendamento">
                        <span><?= (int) $aula['vagas_disponiveis'] ?> / <?= (int) $aula['vagas_totais'] ?> vagas</span>
                    </div>
                    <a href="<?= url('admin/aulas/' . $aula['id']) ?>" class="btn-agendar">Gerenciar Mapa</a>
                    <a href="<?= url('admin/aulas/excluir?excluir=' . $aula['id']) ?>" class="btn-acao" style="display: block; text-align: center; margin-top: 10px; color: #dc3545;" onclick="return confirm('Excluir esta aula? Fichas dos alunos agendados serao estornadas.')"><i class="fas fa-trash"></i> Excluir</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<button class="fab" onclick="document.getElementById('modal-nova-aula').style.display='block'"><i class="fas fa-plus"></i></button>

<div class="modal" id="modal-nova-aula">
    <div class="modal-content">
        <h3 class="oswald clr-branco">Nova Aula</h3>
        <form method="POST" action="<?= url('admin/aulas') ?>">
            <div class="form-group">
                <label>Modalidade</label>
                <input type="text" name="modalidade" required>
            </div>
            <div class="form-group">
                <label>Professor</label>
                <input type="text" name="professor" required>
            </div>
            <div class="form-group">
                <label>Data</label>
                <input type="date" name="data" required>
            </div>
            <div class="form-group">
                <label>Horario</label>
                <input type="time" name="horario" required>
            </div>
            <div class="form-group">
                <label>Vagas</label>
                <input type="number" name="vagas" min="1" required>
            </div>
            <button type="submit" class="btn-submit">Salvar</button>
        </form>
    </div>
</div>

</body>
</html>
