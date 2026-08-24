<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Status do Pagamento | Hiitstudio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700%7COswald:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= asset('user-css/style-user.css') ?>">
    <style>
        :root { --primary: #ff6A00; --secondary: #071a3d; }
        body { background: #05122b; margin: 0; }
        .status-container { max-width: 600px; margin: 100px auto; padding: 40px; background: white; border-radius: 15px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
        .status-icon { font-size: 80px; margin-bottom: 20px; }
        .btn-status { display: inline-block; margin-top: 20px; margin-left: 8px; margin-right: 8px; background: var(--primary); color: white; padding: 15px 40px; border-radius: 8px; text-decoration: none; font-weight: bold; font-family: 'Oswald', sans-serif; text-transform: uppercase; }
        .btn-status.secundario { background: #e9ecef; color: #333; }
    </style>
</head>
<body>

<header style="background: var(--secondary); color: white; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center;">
    <div class="oswald" style="font-size: 1.6rem;"><img src="<?= asset('user-img/logo-l.png') ?>" width="100px"></div>
    <a href="<?= url('dashboard') ?>" style="color: white; text-decoration: none;"><i class="fas fa-home"></i> Dashboard</a>
</header>

<div class="main-container" style="padding: 0 5%;">
    <div class="status-container">
        <div class="status-icon" style="color: <?= $cor ?>;">
            <i class="fas <?= $icone ?>"></i>
        </div>
        <h1 class="oswald" style="color: <?= $cor ?>;"><?= e($titulo) ?></h1>
        <p style="color: #666; font-size: 1.1rem;"><?= e($subtitulo) ?></p>
        <div>
            <?php if ($mostrarBotao): ?>
                <a href="<?= url('comprar-fichas') ?>" class="btn-status">Tentar Novamente</a>
                <a href="<?= url('dashboard') ?>" class="btn-status secundario">Ir para Dashboard</a>
            <?php else: ?>
                <a href="<?= url('dashboard') ?>" class="btn-status">Ir para Dashboard</a>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
