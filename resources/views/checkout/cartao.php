<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Pagamento | Hiitstudio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700%7COswald:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= asset('user-css/style-user.css') ?>">
    <style>
        :root { --primary: #ff6A00; --secondary: #071a3d; }
        body { background: #05122b; margin: 0; }
        .checkout-box { max-width: 480px; margin: 60px auto; background: white; border-radius: 15px; padding: 35px; box-shadow: 0 4px 20px rgba(0,0,0,0.3); }
        .resumo-pacote { background: #f6f7fb; border-radius: 10px; padding: 15px 20px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; }
        .resumo-pacote .nome { font-family: 'Oswald', sans-serif; color: var(--secondary); }
        .resumo-pacote .preco { font-size: 1.4rem; font-weight: bold; color: var(--primary); }
        .tabs-pagamento { display: flex; margin-bottom: 20px; border-radius: 8px; overflow: hidden; border: 1px solid #ddd; }
        .tab-btn { flex: 1; padding: 12px; text-align: center; cursor: pointer; background: #f6f7fb; font-weight: bold; color: #555; }
        .tab-btn.active { background: var(--primary); color: white; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 0.85rem; color: #555; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        .form-row { display: flex; gap: 10px; }
        .btn-pagar { width: 100%; background: var(--primary); color: white; border: none; padding: 16px; border-radius: 8px; font-weight: bold; text-transform: uppercase; font-family: 'Oswald', sans-serif; cursor: pointer; margin-top: 10px; }
        .cupom-row { display: flex; gap: 8px; margin-bottom: 15px; }
        .cupom-row input { flex: 1; }
        .btn-cupom { background: var(--secondary); color: white; border: none; padding: 0 18px; border-radius: 8px; cursor: pointer; }
        .cupom-msg { font-size: 0.85rem; margin-top: 6px; }
        #pix-tab { display: none; text-align: center; }
        .aviso-assinatura { background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; padding: 12px 15px; font-size: 0.85rem; color: #856404; margin-bottom: 20px; }
    </style>
</head>
<body>

<header style="background: var(--secondary); color: white; padding: 10px 5%; display: flex; justify-content: space-between; align-items: center;">
    <div class="oswald" style="font-size: 1.6rem;"><img src="<?= asset('user-img/logo-l.png') ?>" width="100px"></div>
    <a href="<?= url('comprar-fichas') ?>" style="color: white; font-size: 1.2rem;"><i class="fas fa-times"></i></a>
</header>

<div class="checkout-box">
    <div class="resumo-pacote">
        <span class="nome"><?= e($pacote['nome']) ?></span>
        <span class="preco" id="valor-exibido">R$ <?= number_format($pacote['preco'], 2, ',', '.') ?></span>
    </div>

    <?php if ($ehAssinatura): ?>
        <div class="aviso-assinatura">
            <i class="fas fa-info-circle"></i> Esta e uma assinatura com renovacao automatica mensal. As proximas cobrancas serao feitas automaticamente no seu cartao.
        </div>
    <?php endif; ?>

    <div class="cupom-row">
        <input type="text" id="cupom_codigo" placeholder="Cupom de desconto (opcional)">
        <button type="button" class="btn-cupom" onclick="aplicarCupom()">Aplicar</button>
    </div>
    <div id="cupom-msg" class="cupom-msg"></div>

    <div class="tabs-pagamento">
        <div class="tab-btn active" id="tab-cartao" onclick="mostrarAba('cartao')">Cartao de Credito</div>
        <div class="tab-btn" id="tab-pix" onclick="mostrarAba('pix')">Pix</div>
    </div>

    <div id="cartao-tab">
        <form action="<?= url('checkout/cartao') ?>" method="POST" id="form-cartao">
            <input type="hidden" name="checkout_token" value="<?= e($checkoutToken) ?>">
            <input type="hidden" name="pacote_id" value="<?= $pacote['id'] ?>">
            <input type="hidden" name="cupom_codigo" id="cupom_codigo_cartao">

            <div class="form-group">
                <label>Numero do Cartao</label>
                <input type="text" name="card_number" maxlength="19" placeholder="0000 0000 0000 0000" required>
            </div>
            <div class="form-group">
                <label>Nome no Cartao</label>
                <input type="text" name="card_holder_name" placeholder="Como esta impresso no cartao" required>
            </div>
            <div class="form-row">
                <div class="form-group" style="flex: 1;">
                    <label>Validade (MM/AA)</label>
                    <input type="text" name="card_exp" maxlength="5" placeholder="MM/AA" required>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>CVV</label>
                    <input type="text" name="card_cvv" maxlength="4" placeholder="000" required>
                </div>
            </div>

            <?php if (($pacote['max_parcelas'] ?? 1) > 1): ?>
                <div class="form-group">
                    <label>Parcelas</label>
                    <select name="parcelas">
                        <?php for ($i = 1; $i <= $pacote['max_parcelas']; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?>x de R$ <?= number_format($pacote['preco'] / $i, 2, ',', '.') ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn-pagar">Pagar Agora</button>
        </form>
    </div>

    <div id="pix-tab">
        <p style="color: #666;">Gere um QR Code Pix para pagamento instantaneo.</p>
        <button type="button" class="btn-pagar" onclick="pagarComPix()">Gerar Pix</button>
    </div>
</div>

<script>
    const pacoteId = <?= $pacote['id'] ?>;

    function mostrarAba(aba) {
        document.getElementById('tab-cartao').classList.toggle('active', aba === 'cartao');
        document.getElementById('tab-pix').classList.toggle('active', aba === 'pix');
        document.getElementById('cartao-tab').style.display = aba === 'cartao' ? 'block' : 'none';
        document.getElementById('pix-tab').style.display = aba === 'pix' ? 'block' : 'none';
    }

    function aplicarCupom() {
        const codigo = document.getElementById('cupom_codigo').value.trim();
        const msg = document.getElementById('cupom-msg');

        if (!codigo) {
            msg.textContent = '';
            return;
        }

        fetch('<?= url('validar-cupom') ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'codigo=' + encodeURIComponent(codigo) + '&pacote_id=' + pacoteId,
        })
            .then((r) => r.json())
            .then((data) => {
                if (data.sucesso) {
                    msg.style.color = '#28a745';
                    msg.textContent = 'Cupom aplicado! Desconto de ' + data.desconto_formatado + '.';
                    document.getElementById('valor-exibido').textContent = 'R$ ' + data.valor_final.toFixed(2).replace('.', ',');
                    document.getElementById('cupom_codigo_cartao').value = codigo;
                } else {
                    msg.style.color = '#dc3545';
                    msg.textContent = data.erro;
                    document.getElementById('cupom_codigo_cartao').value = '';
                }
            });
    }

    function pagarComPix() {
        const codigo = document.getElementById('cupom_codigo_cartao').value;
        let destino = '<?= url('checkout/pix') ?>?pacote=' + pacoteId;
        if (codigo) {
            destino += '&cupom_codigo=' + encodeURIComponent(codigo);
        }
        window.location.href = destino;
    }
</script>
</body>
</html>
