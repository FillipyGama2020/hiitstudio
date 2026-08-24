<?php $msg = $_GET['msg'] ?? null; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Pacotes | Admin Hiitstudio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700%7COswald:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= asset('user-css/style-admin.css') ?>">
</head>
<body>

<?php require __DIR__ . '/_menu.php'; ?>

<div class="main-content">
    <header>
        <h2 class="oswald clr-branco">Pacotes</h2>
    </header>

    <div class="container">
        <?php if ($msg): ?><div class="alert sucesso"><?= e($msg) ?></div><?php endif; ?>

        <div class="tabela-container">
            <table>
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Fichas</th>
                    <th>Preco</th>
                    <th>Validade (dias)</th>
                    <th>Max. Parcelas</th>
                    <th>Acoes</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($pacotes as $pacote): ?>
                    <tr>
                        <td><?= e($pacote['nome']) ?></td>
                        <td><?= e(ucfirst($pacote['categoria'])) ?></td>
                        <td><?= (int) $pacote['fichas'] ?></td>
                        <td>R$ <?= number_format($pacote['preco'], 2, ',', '.') ?></td>
                        <td><?= (int) $pacote['validade_dias'] ?></td>
                        <td><?= (int) $pacote['max_parcelas'] ?>x</td>
                        <td>
                            <button type="button" class="btn-acao" onclick='abrirEdicao(<?= json_encode($pacote) ?>)'><i class="fas fa-edit"></i></button>
                            <a href="<?= url('admin/pacotes/excluir?excluir=' . $pacote['id']) ?>" class="btn-acao" style="color:#dc3545;" onclick="return confirm('Excluir este pacote? Assinaturas ativas vinculadas serao canceladas.')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<button class="fab" onclick="abrirNovo()"><i class="fas fa-plus"></i></button>

<div class="modal" id="modal-pacote">
    <div class="modal-content">
        <h3 class="oswald clr-branco" id="titulo-modal-pacote">Novo Pacote</h3>
        <form method="POST" action="<?= url('admin/pacotes') ?>">
            <input type="hidden" name="id_pacote" id="f_id_pacote">

            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="nome" id="f_nome" required>
            </div>
            <div class="form-group">
                <label>Categoria</label>
                <select name="categoria" id="f_categoria" required>
                    <option value="avulso">Avulso</option>
                    <option value="assinatura">Assinatura</option>
                </select>
            </div>
            <div class="form-group">
                <label>Descricao</label>
                <input type="text" name="descricao" id="f_descricao">
            </div>
            <div class="form-group">
                <label>Fichas</label>
                <input type="number" name="fichas" id="f_fichas" min="1" required>
            </div>
            <div class="form-group">
                <label>Preco (R$)</label>
                <input type="text" name="preco" id="f_preco" placeholder="0,00" required>
            </div>
            <div class="form-group">
                <label>Intervalo de Validade</label>
                <input type="number" name="interval_count" id="f_interval_count" min="1" value="1" required>
            </div>
            <div class="form-group">
                <label>Tipo de Intervalo</label>
                <select name="interval_type" id="f_interval_type">
                    <option value="day">Dia(s)</option>
                    <option value="month">Mes(es)</option>
                    <option value="year">Ano(s)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Parcelamento Maximo</label>
                <input type="number" name="max_parcelas" id="f_max_parcelas" min="1" value="1" required>
            </div>
            <button type="submit" class="btn-submit">Salvar</button>
        </form>
    </div>
</div>

<script>
    function abrirNovo() {
        document.getElementById('titulo-modal-pacote').innerText = 'Novo Pacote';
        document.getElementById('f_id_pacote').value = '';
        document.getElementById('f_nome').value = '';
        document.getElementById('f_categoria').value = 'avulso';
        document.getElementById('f_descricao').value = '';
        document.getElementById('f_fichas').value = '';
        document.getElementById('f_preco').value = '';
        document.getElementById('f_interval_count').value = 1;
        document.getElementById('f_interval_type').value = 'day';
        document.getElementById('f_max_parcelas').value = 1;
        document.getElementById('modal-pacote').style.display = 'block';
    }

    function abrirEdicao(pacote) {
        document.getElementById('titulo-modal-pacote').innerText = 'Editar Pacote';
        document.getElementById('f_id_pacote').value = pacote.id;
        document.getElementById('f_nome').value = pacote.nome;
        document.getElementById('f_categoria').value = pacote.categoria;
        document.getElementById('f_descricao').value = pacote.descricao || '';
        document.getElementById('f_fichas').value = pacote.fichas;
        document.getElementById('f_preco').value = String(pacote.preco).replace('.', ',');
        document.getElementById('f_interval_count').value = 1;
        document.getElementById('f_interval_type').value = pacote.mp_interval_type || 'day';
        document.getElementById('f_max_parcelas').value = pacote.max_parcelas;
        document.getElementById('modal-pacote').style.display = 'block';
    }
</script>
</body>
</html>
