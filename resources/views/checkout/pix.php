<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Pagamento Pix | Hiitstudio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700%7COswald:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= asset('user-css/style-user.css') ?>">
    <style>
        :root { --primary: #ff6A00; --secondary: #071a3d; }
        body { background: #05122b; margin: 0; }
        .pix-box { max-width: 420px; margin: 60px auto; background: white; border-radius: 15px; padding: 35px; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.3); }
        .pix-valor { font-size: 2rem; font-weight: bold; color: var(--primary); margin-bottom: 5px; }
        .pix-cupom { font-size: 0.85rem; color: #28a745; margin-bottom: 15px; }
        .pix-qr img { width: 220px; height: 220px; border: 8px solid #f6f7fb; border-radius: 10px; }
        .pix-copia-cola { background: #f6f7fb; border-radius: 8px; padding: 12px; font-size: 0.75rem; word-break: break-all; color: #555; margin: 20px 0; max-height: 80px; overflow-y: auto; }
        .btn-copiar { background: var(--secondary); color: white; border: none; padding: 12px 25px; border-radius: 8px; cursor: pointer; font-weight: bold; margin-bottom: 20px; }
        .status-aguardando { color: #888; font-size: 0.9rem; }
        .status-aguardando i { animation: girar 1.5s linear infinite; }
        @keyframes girar { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    </style>
</head>
<body>

<header style="background: var(--secondary); color: white; padding: 10px 5%; display: flex; justify-content: space-between; align-items: center;">
    <div class="oswald" style="font-size: 1.6rem;"><img src="<?= asset('user-img/logo-l.png') ?>" width="100px"></div>
    <a href="<?= url('comprar-fichas') ?>" style="color: white; font-size: 1.2rem;"><i class="fas fa-times"></i></a>
</header>

<div class="pix-box">
    <h2 class="oswald" style="color: var(--secondary);">Pague com Pix</h2>
    <div class="pix-valor">R$ <?= number_format($valorFinal, 2, ',', '.') ?></div>
    <?php if ($cupom): ?>
        <div class="pix-cupom"><i class="fas fa-tag"></i> Cupom <?= e($cupom) ?> aplicado</div>
    <?php endif; ?>

    <div class="pix-qr">
        <?php if ($qrBase64): ?>
            <img src="data:image/png;base64,<?= $qrBase64 ?>" alt="QR Code Pix">
        <?php endif; ?>
    </div>

    <div class="pix-copia-cola" id="copia-cola"><?= e($copiaCola) ?></div>
    <button class="btn-copiar" onclick="copiarCodigo()"><i class="fas fa-copy"></i> Copiar Codigo</button>

    <div class="status-aguardando" id="status-msg">
        <i class="fas fa-sync"></i> Aguardando confirmacao do pagamento...
    </div>
</div>

<script>
    const pixId = <?= json_encode($pixId) ?>;

    function copiarCodigo() {
        const texto = document.getElementById('copia-cola').textContent;
        navigator.clipboard.writeText(texto).then(() => alert('Codigo copiado!'));
    }

    function verificarStatus() {
        fetch('<?= url('checkout/pix/status') ?>?id=' + encodeURIComponent(pixId))
            .then((r) => r.json())
            .then((data) => {
                if (data.status === 'approved') {
                    window.location.href = '<?= url('status-pagamento') ?>?status=sucesso';
                } else if (data.status === 'rejected' || data.status === 'cancelled') {
                    window.location.href = '<?= url('status-pagamento') ?>?status=erro_pix';
                }
            });
    }

    setInterval(verificarStatus, 5000);
</script>
</body>
</html>
