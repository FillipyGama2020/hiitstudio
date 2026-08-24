<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Dashboard | Hiitstudio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700%7COswald:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= asset('user-css/style-user.css') ?>">
    <style>
        :root { --primary: #ff6A00; }
        .badge-agendamentos {
            position: absolute; top: -8px; right: -8px;
            background: var(--primary); color: white;
            font-size: 0.75rem; font-weight: bold;
            min-width: 20px; height: 20px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            padding: 0 4px; box-shadow: 0 0 0 2px var(--secondary);
        }
        .modal-aparelhos { display: none; position: fixed; z-index: 3000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); backdrop-filter: blur(8px); }
        .modal-content-aparelhos { background: #fff; margin: 2% auto; padding: 20px; border-radius: 15px; width: 95%; max-width: 600px; text-align: center; }
        #containerAparelhos { margin: 20px 0; height: 500px; padding: 10px; background: #f4f4f4; border-radius: 10px; display: flex; justify-content: center; }
        #containerAparelhos svg { width: 100%; height: auto; max-height: 70vh; }
        .legenda { display: flex; justify-content: center; gap: 15px; margin-bottom: 20px; font-size: 0.9rem; }
        .legenda-item { display: flex; align-items: center; gap: 5px; }
        .box-legenda { width: 15px; height: 15px; border-radius: 3px; }
        .btn-confirmar-agendamento { background: var(--primary); color: white; border: none; padding: 12px 30px; border-radius: 5px; font-weight: bold; cursor: pointer; width: 100%; }
        .btn-confirmar-agendamento:disabled { background: #ccc; cursor: not-allowed; }
        .aparelho-click { cursor: pointer; transition: transform 0.2s; border-radius: 10px; padding: 5px; }
        .aparelho-click:hover { transform: scale(1.05); background: rgba(255,106,0,0.05); }
    </style>
</head>
<body>

<header>
    <div class="oswald" style="font-size: 1.6rem;"><img src="<?= asset('user-img/logo-l.png') ?>" width="100px"></div>
    <button class="menu-toggle" onclick="toggleMenu()"><i class="fas fa-bars"></i></button>
    <div class="header-actions" id="nav-menu">
        <?php if ($isAdmin): ?>
            <a href="<?= url('admin/aulas') ?>" style="color: #ff6A00; text-decoration: none; font-weight: bold; font-size: 0.9rem; border: 1px solid #ff6A00; padding: 5px 10px; border-radius: 5px;">
                <i class="fa fa-address-card"></i> PAINEL ADMIN
            </a>
        <?php endif; ?>
        <div onclick="abrirModalFichas()" style="background: rgba(255,255,255,0.1); padding: 5px 15px; border-radius: 20px; border: 1px solid var(--primary); display: flex; align-items: center; gap: 8px; cursor: pointer;">
            <i class="fas fa-ticket-alt clr-laranja"></i>
            <span style="font-weight: bold; font-size: 1.1rem; color: white;"><?= (int) $user['fichas'] ?> Fichas</span>
        </div>
        <div class="flexbox">
            <a href="<?= url('editar-perfil') ?>" style="color: white; font-size: 1.3rem; margin-right:10px;" title="Editar Perfil"><i class="fas fa-user-circle"></i></a>
            <a href="<?= url('logout') ?>" style="color: #ff3e3e; font-size: 1.3rem;" title="Sair"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </div>
</header>

<div class="main-container">
    <div class="section-header spacebox">
        <div>
            <h2 class="clr-laranja oswald">Proximas Aulas</h2>
            <p class="clr-branco">Ola, <strong><?= e(explode(' ', $user['nome'])[0]) ?></strong>!</p>
        </div>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <button type="button" class="btn-agenda-link" onclick="toggleFiltro()"><i class="fas fa-filter"></i> Filtro</button>
            <a href="<?= url('minha-agenda') ?>" class="btn-agenda-link" style="position: relative;">
                <i class="fas fa-calendar-alt"></i> Minha Agenda
                <?php if ($totalAgendadas > 0): ?>
                    <span class="badge-agendamentos"><?= $totalAgendadas ?></span>
                <?php endif; ?>
            </a>
        </div>
    </div>

    <div id="painelFiltro" style="display: none; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); border-radius: 10px; padding: 20px; margin-bottom: 25px; flex-wrap: wrap; gap: 15px; align-items: end;">
        <div>
            <label class="clr-branco" style="display:block; margin-bottom:5px; font-size:0.85rem;">Aula</label>
            <select id="filtroAula" onchange="aplicarFiltros()" style="padding:10px; border-radius:8px; border:1px solid #ccc; min-width:180px;">
                <option value="">Todas</option>
                <?php foreach ($modalidades as $modalidade): ?>
                    <option value="<?= e($modalidade) ?>"><?= e($modalidade) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="clr-branco" style="display:block; margin-bottom:5px; font-size:0.85rem;">Instrutor</label>
            <select id="filtroInstrutor" onchange="aplicarFiltros()" style="padding:10px; border-radius:8px; border:1px solid #ccc; min-width:180px;">
                <option value="">Todos</option>
                <?php foreach ($professores as $professor): ?>
                    <option value="<?= e($professor) ?>"><?= e($professor) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="clr-branco" style="display:block; margin-bottom:5px; font-size:0.85rem;">Data</label>
            <input type="date" id="filtroData" onchange="aplicarFiltros()" style="padding:10px; border-radius:8px; border:1px solid #ccc;">
        </div>
        <button type="button" class="btn-agenda-link" onclick="limparFiltros()"><i class="fas fa-times"></i> Limpar</button>
    </div>

    <p id="semResultadosFiltro" style="display:none; color:#ccc; text-align:center; margin: 30px 0;">Nenhuma aula encontrada com esse filtro.</p>

    <div class="aulas-grid" id="gridAulas">
        <?php foreach ($aulas as $aula):
            $horarioInicio = strtotime($aula['data_aula'] . ' ' . $aula['horario']);
            $agora = time();
            $emAndamento = ($agora >= $horarioInicio && $agora <= ($horarioInicio + 2700));
            $ocupadosAula = isset($ocupados[$aula['id']]) ? json_encode($ocupados[$aula['id']]) : '[]';
        ?>
            <div class="card-aula"
                 data-modalidade="<?= e($aula['modalidade']) ?>"
                 data-professor="<?= e($aula['professor']) ?>"
                 data-data="<?= e($aula['data_aula']) ?>">
                <div class="card-header" style="<?= $aula['modalidade'] === 'Spinning' ? 'background: #0d2552;' : '' ?>">
                    <h3 class="oswald"><?= e($aula['modalidade']) ?></h3>
                </div>
                <div class="card-body" style="background: white;">
                    <div style="display:flex; align-items: center;">
                        <div style="width:40%;">
                            <div class="info-item"><i class="far fa-calendar-alt"></i> <?= date('d/m', strtotime($aula['data_aula'])) ?></div>
                            <div class="info-item"><i class="far fa-clock"></i> <?= substr($aula['horario'], 0, 5) ?></div>
                            <div class="info-item"><i class="fas fa-chalkboard-user"></i> <?= e($aula['professor']) ?></div>
                            <div class="info-item"><i class="fas fa-users"></i> <?= max(0, $aula['vagas_reais']) ?> Vagas</div>
                        </div>
                        <div style="width:60%; text-align: center;">
                            <?php if ($aula['ja_agendado'] > 0 && !empty($aula['meu_aparelho'])):
                                $icone = $aula['modalidade'] === 'Spinning' ? 'fa-bicycle' : 'fa-walking';
                                $nomeAparelho = $aula['modalidade'] === 'Spinning' ? 'Bike' : 'Esteira';
                            ?>
                                <div class="aparelho2 aparelho-click"
                                     onclick='abrirMapa(<?= $aula['id'] ?>, "<?= e($aula['modalidade']) ?>", <?= $aula['vagas_totais'] ?>, <?= $ocupadosAula ?>, <?= $aula['meu_aparelho'] ?>)'
                                     title="Clique para ver localizacao">
                                    <i class="fas <?= $icone ?>" style="color:var(--primary); font-size: 60px;"></i>
                                    <p style="font-size: 20px;"><b><?= $nomeAparelho ?> <?= $aula['meu_aparelho'] ?></b></p>
                                    <small style="color: #666; font-size: 0.7rem;">(Ver no mapa)</small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if ($emAndamento): ?>
                        <button class="btn-agendar btn-em-andamento" disabled>Em Andamento</button>
                    <?php elseif ($aula['ja_agendado'] > 0): ?>
                        <button class="btn-agendar btn-agendado" disabled>Ja Agendado</button>
                    <?php elseif ($aula['vagas_reais'] <= 0): ?>
                        <button class="btn-agendar btn-sem-saldo" disabled>Indisponivel</button>
                    <?php elseif ($user['fichas'] > 0): ?>
                        <button class="btn-agendar" onclick='abrirMapa(<?= $aula['id'] ?>, "<?= e($aula['modalidade']) ?>", <?= $aula['vagas_totais'] ?>, <?= $ocupadosAula ?>)'>
                            Agendar
                        </button>
                    <?php else: ?>
                        <button class="btn-agendar" onclick="abrirModalFichas()">
                            Agendar
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div id="modalMapa" class="modal-aparelhos">
    <div class="modal-content-aparelhos">
        <span onclick="fecharMapa()" style="float: right; font-size: 24px; cursor: pointer;">&times;</span>
        <h2 class="oswald" id="tituloModalMapa">Mapa da Sala</h2>
        <p id="subtituloModalMapa" style="color: #666; margin-bottom: 10px;"></p>
        <div class="legenda" id="legendaMapa">
            <div class="legenda-item"><div class="box-legenda" style="background: white; border: 1px solid #ccc;"></div> Livre</div>
            <div class="legenda-item"><div class="box-legenda" style="background: var(--primary);"></div> Selecionado</div>
            <div class="legenda-item"><div class="box-legenda" style="background: #e0e0e0;"></div> Ocupado</div>
        </div>
        <div id="containerAparelhos"></div>
        <button id="btnConfirmarAparelho" class="btn-confirmar-agendamento" disabled onclick="finalizarAgendamento()">Confirmar Agendamento</button>

        <div id="resultadoAgendamento" style="display:none; text-align:center; padding: 30px 10px;">
            <i id="iconeResultadoAgendamento" class="fas" style="font-size: 60px;"></i>
            <p id="mensagemResultadoAgendamento" style="font-size: 1.2rem; margin: 20px 0; color: #333;"></p>
            <button class="btn-confirmar-agendamento" onclick="fecharResultadoAgendamento()">OK</button>
        </div>
    </div>
</div>

<div id="modalFichas" style="display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); backdrop-filter: blur(5px);">
    <div style="background-color: #fff; margin: 15% auto; padding: 30px; border-radius: 15px; width: 90%; max-width: 400px; text-align: center; position: relative;">
        <span onclick="fecharModalFichas()" style="position: absolute; right: 20px; top: 15px; font-size: 24px; cursor: pointer; color: #777;">&times;</span>
        <h2 class="oswald" style="color: #333;">Total de Fichas</h2>
        <div style="font-size: 2.5rem; font-weight: bold; color: #ff6A00;"><?= (int) $user['fichas'] ?></div>
        <p style="color: #333;">Validade: <strong><?= $user['validade_fichas'] ? date('d/m/Y', strtotime($user['validade_fichas'])) : 'Sem validade' ?></strong></p>
        <br>
        <a href="<?= url('comprar-fichas') ?>" class="btn-auth" style="display: block; background: #ff6A00; color: white; padding: 15px; border-radius: 8px; text-decoration: none; font-weight: bold;">
            Comprar mais fichas
        </a>
    </div>
</div>

<script>
let aulaSelecionadaId = null;
let aparelhoSelecionadoId = null;
let agendamentoDeuCerto = false;

function abrirModalFichas() { document.getElementById("modalFichas").style.display = "block"; }
function fecharModalFichas() { document.getElementById("modalFichas").style.display = "none"; }
function toggleMenu() { document.getElementById('nav-menu').classList.toggle('active'); }
function fecharMapa() { document.getElementById('modalMapa').style.display = 'none'; }

function toggleFiltro() {
    const painel = document.getElementById('painelFiltro');
    painel.style.display = (painel.style.display === 'flex') ? 'none' : 'flex';
}

function limparFiltros() {
    document.getElementById('filtroAula').value = '';
    document.getElementById('filtroInstrutor').value = '';
    document.getElementById('filtroData').value = '';
    aplicarFiltros();
}

function aplicarFiltros() {
    const aula = document.getElementById('filtroAula').value;
    const instrutor = document.getElementById('filtroInstrutor').value;
    const data = document.getElementById('filtroData').value;

    const cards = document.querySelectorAll('#gridAulas .card-aula');
    let visiveis = 0;

    cards.forEach(card => {
        const mostrar = (!aula || card.dataset.modalidade === aula)
            && (!instrutor || card.dataset.professor === instrutor)
            && (!data || card.dataset.data === data);

        card.style.display = mostrar ? '' : 'none';
        if (mostrar) visiveis++;
    });

    document.getElementById('semResultadosFiltro').style.display = (visiveis === 0) ? 'block' : 'none';
}

function abrirMapa(aulaId, modalidade, totalVagas, ocupados, aparelhoPreSelecionado = null) {
    aulaSelecionadaId = aulaId;
    aparelhoSelecionadoId = aparelhoPreSelecionado;

    document.getElementById('resultadoAgendamento').style.display = 'none';
    document.getElementById('containerAparelhos').style.display = '';
    document.getElementById('legendaMapa').style.display = '';

    const btnConfirmar = document.getElementById('btnConfirmarAparelho');
    btnConfirmar.style.display = '';

    if (aparelhoPreSelecionado) {
        btnConfirmar.disabled = true;
        btnConfirmar.innerText = "Voce agendou o Aparelho " + aparelhoPreSelecionado;
    } else {
        btnConfirmar.disabled = true;
        btnConfirmar.innerText = "Confirmar Agendamento";
    }

    document.getElementById('modalMapa').style.display = 'block';
    document.getElementById('subtituloModalMapa').innerText = modalidade;

    const container = document.getElementById('containerAparelhos');
    container.innerHTML = '<p>Carregando mapa...</p>';

    const arquivoSVG = (modalidade === 'Spinning') ? '<?= asset('user-img/sala-spinning.svg') ?>' : '<?= asset('user-img/sala-esteira.svg') ?>';

    fetch(arquivoSVG)
        .then(response => response.text())
        .then(svgData => {
            container.innerHTML = svgData;
            const grupos = container.querySelectorAll('g[id*="bike-"], g[id*="aparelho-"]');

            grupos.forEach((grupo, index) => {
                const numeroAparelho = index + 1;
                const estaOcupado = ocupados.some(id => String(id) === String(numeroAparelho));
                const ehOMeu = (String(numeroAparelho) === String(aparelhoPreSelecionado));

                if (ehOMeu) {
                    grupo.querySelectorAll('path, polygon, circle, rect').forEach(el => el.style.fill = "#ff6A00");
                } else if (estaOcupado) {
                    grupo.querySelectorAll('path, polygon, circle, rect').forEach(el => el.style.fill = "#e0e0e0");
                    grupo.style.cursor = "not-allowed";
                } else if (!aparelhoPreSelecionado) {
                    grupo.style.cursor = "pointer";
                    grupo.onclick = function () {
                        grupos.forEach(g => {
                            if (!ocupados.some(id => String(id) === String(g.id.match(/\d+/)))) {
                                g.querySelectorAll('path, polygon, circle, rect').forEach(el => el.style.fill = "");
                            }
                        });
                        this.querySelectorAll('path, polygon, circle, rect').forEach(el => el.style.fill = "#ff6A00");
                        aparelhoSelecionadoId = numeroAparelho;
                        btnConfirmar.disabled = false;
                    };
                }
            });
        });
}

function finalizarAgendamento() {
    if (!aulaSelecionadaId || !aparelhoSelecionadoId) return;

    const btnConfirmar = document.getElementById('btnConfirmarAparelho');
    const textoOriginal = btnConfirmar.innerText;
    btnConfirmar.disabled = true;
    btnConfirmar.innerText = "Processando...";

    fetch(`<?= url('agendar') ?>?aula=${aulaSelecionadaId}&aparelho=${aparelhoSelecionadoId}`)
        .then(response => response.json())
        .then(data => mostrarResultadoAgendamento(data.sucesso, data.sucesso ? data.mensagem : data.erro))
        .catch(() => mostrarResultadoAgendamento(false, "Erro de conexao. Tente novamente."))
        .finally(() => {
            btnConfirmar.disabled = false;
            btnConfirmar.innerText = textoOriginal;
        });
}

function mostrarResultadoAgendamento(sucesso, mensagem) {
    agendamentoDeuCerto = sucesso;

    document.getElementById('containerAparelhos').style.display = 'none';
    document.getElementById('legendaMapa').style.display = 'none';
    document.getElementById('btnConfirmarAparelho').style.display = 'none';

    const icone = document.getElementById('iconeResultadoAgendamento');
    icone.className = sucesso ? 'fas fa-check-circle' : 'fas fa-times-circle';
    icone.style.color = sucesso ? '#28a745' : '#ff3e3e';
    document.getElementById('mensagemResultadoAgendamento').innerText = mensagem;
    document.getElementById('resultadoAgendamento').style.display = 'block';
}

function fecharResultadoAgendamento() {
    document.getElementById('modalMapa').style.display = 'none';
    if (agendamentoDeuCerto) {
        location.reload();
    }
}
</script>
</body>
</html>
