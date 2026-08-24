<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Detalhes da Aula | Admin Hiitstudio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700%7COswald:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= asset('user-css/style-admin.css') ?>">
    <style>
        #mapaAula { margin: 20px 0; padding: 20px; background: white; border-radius: 10px; display: flex; justify-content: center; }
        #mapaAula svg { width: 100%; max-width: 600px; height: auto; }
        .legenda { display: flex; justify-content: center; gap: 20px; margin: 15px 0; font-size: 0.85rem; }
        .legenda-item { display: flex; align-items: center; gap: 6px; }
        .box-legenda { width: 14px; height: 14px; border-radius: 3px; }
        .aparelho-nome-flutuante { text-align: center; font-size: 0.8rem; color: #333; margin-top: -10px; }
    </style>
</head>
<body>

<?php require __DIR__ . '/_menu.php'; ?>

<div class="main-content">
    <header>
        <h2 class="oswald clr-branco"><?= e($aula['modalidade']) ?></h2>
        <a href="<?= url('admin/aulas') ?>" style="color: white; text-decoration: none;"><i class="fas fa-arrow-left"></i></a>
    </header>

    <div class="container">
        <div class="tabela-container" style="padding: 20px;">
            <div class="info-item"><i class="far fa-calendar-alt"></i> <?= date('d/m/Y', strtotime($aula['data_aula'])) ?></div>
            <div class="info-item"><i class="far fa-clock"></i> <?= substr($aula['horario'], 0, 5) ?></div>
            <div class="info-item"><i class="fas fa-chalkboard-user"></i> <?= e($aula['professor']) ?></div>
            <div class="info-item"><i class="fas fa-users"></i> <?= (int) $aula['vagas_totais'] ?> vagas totais</div>
        </div>

        <div class="legenda">
            <div class="legenda-item"><div class="box-legenda" style="background: white; border: 1px solid #ccc;"></div> Livre</div>
            <div class="legenda-item"><div class="box-legenda" style="background: #dc3545;"></div> Ocupado</div>
            <div class="legenda-item"><div class="box-legenda" style="background: #6c757d;"></div> Manutencao</div>
        </div>

        <div id="mapaAula"><p style="color: #333;">Carregando mapa...</p></div>
        <p style="text-align: center; color: #ccc; font-size: 0.85rem;">Clique em um aparelho livre para marca-lo em manutencao, ou em um ja marcado para reativa-lo.</p>
    </div>
</div>

<script>
    const ocupados = <?= json_encode($ocupados) ?>;
    const modalidade = <?= json_encode($aula['modalidade']) ?>;
    const arquivoSVG = modalidade === 'Spinning' ? '<?= asset('user-img/sala-spinning.svg') ?>' : '<?= asset('user-img/sala-esteira.svg') ?>';

    fetch(arquivoSVG)
        .then((response) => response.text())
        .then((svgData) => {
            const container = document.getElementById('mapaAula');
            container.innerHTML = svgData;

            const grupos = container.querySelectorAll('g[id*="bike-"], g[id*="aparelho-"]');

            grupos.forEach((grupo, index) => {
                const numeroAparelho = index + 1;
                const ocupacao = ocupados[numeroAparelho] || null;

                if (ocupacao && !ocupacao.is_manutencao) {
                    grupo.querySelectorAll('path, polygon, circle, rect').forEach((el) => el.style.fill = '#dc3545');
                    grupo.style.cursor = 'not-allowed';
                    grupo.setAttribute('title', ocupacao.nome);
                } else if (ocupacao && ocupacao.is_manutencao) {
                    grupo.querySelectorAll('path, polygon, circle, rect').forEach((el) => el.style.fill = '#6c757d');
                    grupo.style.cursor = 'pointer';
                    grupo.setAttribute('title', 'Em manutencao - clique para reativar');
                    grupo.onclick = () => alternarManutencao(numeroAparelho);
                } else {
                    grupo.style.cursor = 'pointer';
                    grupo.setAttribute('title', 'Livre - clique para marcar manutencao');
                    grupo.onclick = () => alternarManutencao(numeroAparelho);
                }
            });
        });

    function alternarManutencao(numeroAparelho) {
        window.location.href = '?toggle_aparelho=1&aparelho_id=' + numeroAparelho;
    }
</script>
</body>
</html>
