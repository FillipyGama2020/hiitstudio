<?php $msg = $_GET['msg'] ?? null; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Cupons | Admin Hiitstudio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700%7COswald:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= asset('user-css/style-admin.css') ?>">
</head>
<body>

<?php require __DIR__ . '/_menu.php'; ?>

<div class="main-content">
    <header>
        <h2 class="oswald clr-branco">Cupons</h2>
    </header>

    <div class="container">
        <?php if ($msg): ?><div class="alert sucesso"><?= e($msg) ?></div><?php endif; ?>

        <div class="tabela-container">
            <table>
                <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Tipo</th>
                    <th>Valor</th>
                    <th>Validade</th>
                    <th>Usos</th>
                    <th>Status</th>
                    <th>Acoes</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($cupons as $cupom): ?>
                    <tr>
                        <td><strong><?= e($cupom['codigo']) ?></strong></td>
                        <td><?= $cupom['tipo'] === 'porcentagem' ? 'Percentual' : 'Valor Fixo' ?></td>
                        <td><?= $cupom['tipo'] === 'porcentagem' ? ((int) $cupom['valor'] . '%') : ('R$ ' . number_format($cupom['valor'], 2, ',', '.')) ?></td>
                        <td><?= $cupom['validade'] ? date('d/m/Y', strtotime($cupom['validade'])) : 'Sem validade' ?></td>
                        <td><?= (int) $cupom['uso_contagem'] ?> / <?= $cupom['uso_limite'] ?? '&infin;' ?></td>
                        <td>
                            <?php if ($cupom['status'] === 'ativo'): ?>
                                <span class="status-badge status-1">Ativo</span>
                            <?php else: ?>
                                <span class="status-badge status-2">Inativo</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button type="button" class="btn-acao" onclick='abrirEdicao(<?= json_encode($cupom) ?>)'><i class="fas fa-edit"></i></button>
                            <a href="<?= url('admin/cupons/excluir?excluir=' . $cupom['id']) ?>" class="btn-acao" style="color:#dc3545;" onclick="return confirm('Excluir este cupom?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<button class="fab" onclick="abrirNovo()"><i class="fas fa-plus"></i></button>

<div class="modal" id="modal-cupom">
    <div class="modal-content">
        <h3 class="oswald clr-branco" id="titulo-modal-cupom">Novo Cupom</h3>
        <form method="POST" action="<?= url('admin/cupons') ?>">
            <input type="hidden" name="id_cupom" id="f_id_cupom">

            <div class="form-group">
                <label>Codigo</label>
                <input type="text" name="codigo" id="f_codigo" style="text-transform: uppercase;" required>
            </div>
            <div class="form-group">
                <label>Tipo de Desconto</label>
                <select name="tipo" id="f_tipo">
                    <option value="porcentagem">Percentual</option>
                    <option value="fixo">Valor Fixo</option>
                </select>
            </div>
            <div class="form-group">
                <label>Valor</label>
                <input type="text" name="valor" id="f_valor" placeholder="Ex: 10 ou 10,00" required>
            </div>
            <div class="form-group">
                <label>Validade (opcional)</label>
                <input type="date" name="validade" id="f_validade">
            </div>
            <div class="form-group">
                <label>Limite de Usos (opcional)</label>
                <input type="number" name="uso_limite" id="f_uso_limite" min="1" placeholder="Deixe em branco para ilimitado">
            </div>
            <button type="submit" class="btn-submit">Salvar</button>
        </form>
    </div>
</div>

<script>
    function abrirNovo() {
        document.getElementById('titulo-modal-cupom').innerText = 'Novo Cupom';
        document.getElementById('f_id_cupom').value = '';
        document.getElementById('f_codigo').value = '';
        document.getElementById('f_tipo').value = 'percentual';
        document.getElementById('f_valor').value = '';
        document.getElementById('f_validade').value = '';
        document.getElementById('f_uso_limite').value = '';
        document.getElementById('modal-cupom').style.display = 'block';
    }

    function abrirEdicao(cupom) {
        document.getElementById('titulo-modal-cupom').innerText = 'Editar Cupom';
        document.getElementById('f_id_cupom').value = cupom.id;
        document.getElementById('f_codigo').value = cupom.codigo;
        document.getElementById('f_tipo').value = cupom.tipo;
        document.getElementById('f_valor').value = String(cupom.valor).replace('.', ',');
        document.getElementById('f_validade').value = cupom.validade ? cupom.validade.substring(0, 10) : '';
        document.getElementById('f_uso_limite').value = cupom.uso_limite || '';
        document.getElementById('modal-cupom').style.display = 'block';
    }
</script>
</body>
</html>
