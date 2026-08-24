<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Comprar Fichas | Hiitstudio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700%7COswald:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= asset('user-css/style-user.css') ?>">
    <style>
        :root { --primary: #ff6A00; --secondary: #071a3d; }
        body { background: #05122b; margin: 0; }
        .pricing-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; max-width: 1200px; margin: 0 auto; }
        .card-pacote { background: white; border-radius: 15px; padding: 30px 20px; text-align: center; transition: all 0.3s ease; position: relative; display: flex; flex-direction: column; border-top: 6px solid var(--primary); overflow: hidden; }
        .card-pacote:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,0.5); }
        .pacote-nome { font-family: 'Oswald', sans-serif; font-size: 1.4rem; color: var(--secondary); text-transform: uppercase; }
        .pacote-fichas { font-size: 3rem; font-weight: bold; color: var(--primary); margin: 10px 0; }
        .pacote-preco { font-size: 1.8rem; font-weight: bold; color: #333; margin: 15px 0; }
        .btn-comprar { background: var(--primary); color: white; text-decoration: none; padding: 15px; border-radius: 8px; font-weight: bold; margin-top: auto; transition: 0.3s; text-transform: uppercase; border: none; cursor: pointer; width: 100%; }
        .section-header-vendas { text-align: center; margin-bottom: 30px; }
    </style>
</head>
<body>

<header style="background: var(--secondary); color: white; padding: 10px 5%; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 1000;">
    <div class="oswald" style="font-size: 1.6rem;"><img src="<?= asset('user-img/logo-l.png') ?>" width="100px"></div>
    <?php if ($user): ?>
        <a href="<?= url('dashboard') ?>" style="color: white; font-size: 1.2rem;"><i class="fas fa-times"></i></a>
    <?php else: ?>
        <a href="<?= url('login') ?>" style="color: white; text-decoration: none; font-weight: bold; background: var(--primary); padding: 8px 20px; border-radius: 5px;">LOGIN</a>
    <?php endif; ?>
</header>

<div class="main-container" style="padding: 40px 5%;">
    <div class="section-header-vendas">
        <h1 class="oswald" style="font-size: 3rem; color:#ff6A00">NOSSOS PACOTES</h1>
        <p style="color:#fff">Escolha a melhor forma de treinar com a gente</p>
    </div>

    <div class="pricing-grid">
        <?php foreach ($avulsos as $p): ?>
            <div class="card-pacote">
                <div class="pacote-nome"><?= e($p['nome']) ?></div>
                <div class="pacote-fichas"><?= $p['fichas'] ?> <small>Fichas</small></div>
                <div class="pacote-preco"><small>R$</small> <?= number_format($p['preco'], 2, ',', '.') ?></div>
                <a href="<?= url('pagar-cartao?pacote=' . $p['id']) ?>" class="btn-comprar">Comprar Agora</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
