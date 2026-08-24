<?php $sucesso = flash('sucesso'); $erro = flash('erro'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Agenda | Hiitstudio</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700%7COswald:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= asset('user-css/style-user.css') ?>">
    <style>
        :root { --primary: #ff6A00; --secondary: #071a3d; }
        .oswald { font-family: 'Oswald', sans-serif; text-transform: uppercase; }
        header { background: var(--secondary); color: white; padding: 20px 5%; display: flex; justify-content: space-between; align-items: center; }
        .nav-semana { display: flex; justify-content: center; align-items: center; gap: 20px; margin: 30px 0; }
        .btn-nav { background: var(--primary); color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-weight: bold; transition: 0.3s; }
        .btn-nav:hover { background: #e55a00; }
    </style>
</head>
<body>

<header>
    <h2 class="oswald"><i class="fa fa-calendar clr-laranja"></i> Minha Agenda</h2>
    <a href="<?= url('dashboard') ?>" style="color: white; text-decoration: none;"><i class="fa fa-angle-left"></i> Voltar</a>
</header>

<div class="nav-semana">
    <a href="?semana=<?= $offset - 1 ?>" class="btn-nav"><i class="fas fa-chevron-left"></i> Anterior</a>
    <div style="text-align: center;">
        <span class="oswald" style="font-size: 1.2rem; color: white;">
            <?= date('d/m', $inicio) ?> &mdash; <?= date('d/m', $fim) ?>
        </span>
    </div>
    <a href="?semana=<?= $offset + 1 ?>" class="btn-nav">Proxima <i class="fas fa-chevron-right"></i></a>
</div>

<div class="calendar-grid">
    <?php
    $diasTraducao = ['Monday' => 'Segunda', 'Tuesday' => 'Terca', 'Wednesday' => 'Quarta', 'Thursday' => 'Quinta', 'Friday' => 'Sexta', 'Saturday' => 'Sabado', 'Sunday' => 'Domingo'];

    for ($i = 0; $i < 7; $i++):
        $timestampLoop = strtotime("+$i days", $inicio);
        $dataLoop = date('Y-m-d', $timestampLoop);
        $diaIngles = date('l', $timestampLoop);
        $hojeClasse = ($dataLoop === date('Y-m-d')) ? 'today' : '';
    ?>
        <div class="day-column">
            <div class="day-header <?= $hojeClasse ?>">
                <div class="oswald"><?= $diasTraducao[$diaIngles] ?></div>
                <div style="font-size: 0.85rem; opacity: 0.8;"><?= date('d/m', $timestampLoop) ?></div>
            </div>
            <div class="day-content">
                <?php if (isset($agendamentos[$dataLoop])): ?>
                    <?php foreach ($agendamentos[$dataLoop] as $aula): ?>
                        <div class="event-card">
                            <strong><?= e($aula['modalidade']) ?></strong>
                            <span class="info"><i class="far fa-clock"></i> <?= substr($aula['horario'], 0, 5) ?></span>
                            <span class="info"><i class="fas fa-user-tie"></i> <?= e($aula['professor']) ?></span>
                            <?php
                            $horarioAula = strtotime($dataLoop . ' ' . $aula['horario']);
                            if ($horarioAula > (time() + 28800)):
                            ?>
                                <button class="btn-cancelar" onclick="confirmarCancelamento(<?= $aula['agendamento_id'] ?>)">
                                    <i class="fas fa-times"></i> Cancelar
                                </button>
                            <?php else: ?>
                                <span class="fora-prazo">8h de antecedencia para cancelamento</span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="text-align: center; color: #ddd; padding-top: 40px; font-size: 0.8rem; font-style: italic;">Sem treinos</div>
                <?php endif; ?>
            </div>
        </div>
    <?php endfor; ?>
</div>

<script>
    <?php if ($sucesso): ?>alert(<?= json_encode($sucesso) ?>);<?php endif; ?>
    <?php if ($erro): ?>alert(<?= json_encode($erro) ?>);<?php endif; ?>

    function confirmarCancelamento(id) {
        if (confirm("Deseja realmente cancelar? Sua ficha sera devolvida.")) {
            window.location.href = "<?= url('cancelar-agendamento') ?>?id=" + id;
        }
    }
</script>
</body>
</html>
