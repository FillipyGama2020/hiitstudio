<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Hiitstudio</title>
    <meta content="" name="description">
    <meta content="" name="author">
    <meta content="" name="keywords">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="<?= asset('css/plugins.css') ?>" media="all" rel="stylesheet" type="text/css">
    <link href="<?= asset('css/style.css') ?>" media="all" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700%7COswald:300,400,700" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="preloader-bg"></div>
    <div id="preloader">
        <div id="preloader-status">
            <div class="preloader-position loader">
                <span></span>
            </div>
        </div>
    </div>
    <div class="vertical-lines-out">
        <div class="vertical-lines-wrapper-e">
            <div class="vertical-lines-e"></div>
        </div>
    </div>
    <a class="logo" href="#">
        <div class="logo-img"></div>
    </a>
    <div class="round-menu-wrapper">
        <div class="round-menu navigation-fire">
            <span class="dot-1"></span><span class="dot-2"></span><span class="dot-3"></span>
        </div>
    </div>
    <div class="panel-overlay-from-left">
    </div>
    <div class="panel-from-right">
        <nav class="navigation-menu">
            <div class="dots dots-wider">
                <div class="the-dots the-dots-menu"></div>
            </div>
            <div class="dots-reverse dots-reverse-wider">
                <div class="the-dots the-dots-menu"></div>
            </div>
            <div class="center-container-menu">
                <div class="center-block-menu">
                    <ul class="menu">
                        <li>
                            <a class="navigation-state" href="#page-home">Home</a>
                        </li>
                        <li>
                            <a class="navigation-state" href="#page-about">Quem somos</a>
                        </li>
                        <li>
                            <a class="navigation-state" href="#page-news">Serviços</a>
                        </li>
                        <li>
                            <a class="navigation-state" href="#page-gallery">Galeria</a>
                        </li>
                        <li>
                            <a class="navigation-state" href="#page-contact">Contato</a>
                        </li>
                        <br>
                        <li>
                            <a href="<?= url('login') ?>" class="navigation-state submit-btn-custom">Entrar</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <svg class="goo" viewBox="0 0 100 100">
            <defs>
                <filter id='goo'>
                    <feGaussianBlur in='SourceGraphic' result='blur' stdDeviation='4' />
                    <feColorMatrix in='blur' result='goo' values='1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7' />
                </filter>
            </defs>
            <g filter="url(#goo)">
                <circle cx=35 cy=35 r=12>
                    <animateTransform attributeName="transform" attributeType="XML" repeatCount="indefinite"
                        type="rotate"
                        from="0 60 50"
                        to="360 50 50"
                        dur="8s" />
                    <animate attributeName="fill" attributeType="XML" repeatCount="indefinite"
                        values="Gray; DimGray; Gray"
                        keyTimes="0; 0.5; 1"
                        dur="6s" />
                </circle>
                <circle cx=40 cy=35 r=12>
                    <animateTransform attributeName="transform" attributeType="XML" repeatCount="indefinite"
                        type="rotate"
                        dur="6s"
                        from="0 60 50"
                        to="-360 50 50" />
                    <animate attributeName="fill" attributeType="XML" repeatCount="indefinite"
                        values="DimGray; Gray; DimGray"
                        keyTimes="0; 0.5; 1"
                        dur="8s" />
                </circle>
                <circle cx=45 cy=45 r=25>
                    <animateTransform attributeName="transform" attributeType="XML" repeatCount="indefinite"
                        dur="4s"
                        from="0 50 50"
                        to="360 50 50"
                        type="rotate" />
                    <animate attributeName="fill" attributeType="XML" repeatCount="indefinite"
                        values="DimGray; Gray; DimGray"
                        keyTimes="0; 0.5; 1"
                        dur="6s" />
                </circle>
                <circle cx=30 cy=60 r=20>
                    <animateTransform attributeName="transform" attributeType="XML" repeatCount="indefinite"
                        dur="10s"
                        from="0 50 50"
                        to="-360 50 50"
                        type="rotate" />
                    <animate attributeName="fill" attributeType="XML" repeatCount="indefinite"
                        values="DimGray; Gray; DimGray"
                        keyTimes="0; 0.5; 1"
                        dur="9s" />
                </circle>
                <circle cx=60 cy=40 r=15>
                    <animateTransform attributeName="transform" attributeType="XML" repeatCount="indefinite"
                        dur="8s"
                        from="0 40 40"
                        to="360 40 40"
                        type="rotate" />
                    <animate attributeName="fill" attributeType="XML" repeatCount="indefinite"
                        values="DimGray; Gray; DimGray"
                        keyTimes="0; 0.5; 1"
                        dur="7s" />
                </circle>
            </g>
        </svg>
    </div>
    <div class="upper-page" id="page-home">
        <div class="dots dots-wider">
            <div class="the-dots the-dots-home"></div>
        </div>
        <div class="dots-reverse dots-reverse-wider">
            <div class="the-dots the-dots-home"></div>
        </div>
        <div class="center-container pointer-events-ON">
            <div class="center-block">
                <h1 class="hero-heading">
                    HIIT STUDIO
                </h1>
                <div class="text-center testimonials-signature-all testimonials-signature-center testimonials-signature-home">
                    Aulas de HIIT com esteira e bicicleta em um ambiente moderno, motivador e focado em resultados.
                </div>
                <div class="divider-m"></div>
                <div class="more-wraper-center more-wraper-center-home">
                    <a href="<?= url('cadastro') ?>">
                        <div class="more-button-bg-center more-button-circle"></div>
                        <div class="more-button-txt-center">
                            <span>Iniciar agora</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="hero-fullscreen">
            <div class="hero-fullscreen-FIX">
                <div class="hero-bg">
                    <div class="swiper-container-wrapper">
                        <div class="swiper-container swiper1">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="swiper-slide-inner" data-swiper-parallax="50%">
                                        <div class="swiper-slide-inner-bg bg-img-1 overlay overlay-dark"></div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="swiper-slide-inner" data-swiper-parallax="50%">
                                        <div class="swiper-slide-inner-bg bg-img-2 overlay overlay-dark">
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="swiper-slide-inner" data-swiper-parallax="50%">
                                        <div class="swiper-slide-inner-bg bg-img-3 overlay overlay-dark"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="social-wrapper-home">
            <div class="social-icons social-icons-dark">
                <ul>
                    <li>
                        <a class="ion-social-instagram" href="#"><span>Instagram</span></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="scroll-indicator">
            <div class="scroll-indicator-wrapper">
                <div class="scroll-line"></div>
            </div>
        </div>
    </div>
    <div class="lower-page bg-color-1">
        <div class="container-fluid nopadding">
            <div class="extra-margin-container">
                <div class="dots">
                    <div class="the-dots"></div>
                </div>
                <div class="dots-reverse">
                    <div class="the-dots"></div>
                </div>
                <div class="divider-xl"></div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="built-item">
                            <div class="built-item-inner">
                                <span class="ion-android-bicycle"></span>
                                <div class="divider-m"></div>
                                <div class="built-item-title">Equipamentos modernos</div>
                                <div class="divider-m"></div>
                                <p>Treine com esteiras e bicicletas de alta performance, garantindo segurança, conforto e máximo rendimento em cada sessão.</p>
                                <div class="divider-l visible-mobile-only"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="built-item">
                            <div class="built-item-inner">
                                <span class="ion-android-favorite-outline"></span>
                                <div class="divider-m"></div>
                                <div class="built-item-title">Resultados em Pouco Tempo</div>
                                <div class="divider-m"></div>
                                <p>45 minutos de treino inteligente e alta performance.</p>
                                <div class="divider-l visible-mobile-only"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="built-item">
                            <div class="built-item-inner">
                                <span class="ion-ios-pulse-strong"></span>
                                <div class="divider-m"></div>
                                <div class="built-item-title">Treinos de Alta Intensidade</div>
                                <div class="divider-m"></div>
                                <p>Método HIIT estruturado para elevar seus batimentos, acelerar o metabolismo e potencializar a queima de gordura.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divider-xl"></div>
            </div>
        </div>
    </div>
    <div class="lower-page bg-color-2" id="page-about">
        <div class="container-fluid nopadding">
            <div class="extra-margin-container">
                <div class="dots">
                    <div class="the-dots"></div>
                </div>
                <div class="dots-reverse">
                    <div class="the-dots"></div>
                </div>
                <div class="divider-xl"></div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-heading section-heading-dot">
                            <div class="section-heading-span">
                                <div class="dot"></div>
                            </div>
                            <div class="move-up-dot">Quem somos</div>
                        </div>
                        <div class="divider-l"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-text-l">
                            <span>Evolua em</span><br>
                            cada treino
                        </div>
                        <div class="divider-l"></div>
                        <div class="testimonials-signature">
                            Impulsionando você a ir além.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="divider-l"></div>
                        <div class="intro-2 go-left-xs">
                            No HIIT Studio Integrado, cada aula é estrategicamente planejada para maximizar sua performance, elevar seu condicionamento físico e acelerar sua transformação de forma inteligente e segura.
                            Utilizamos o método HIIT aliado a equipamentos modernos para entregar treinos intensos, dinâmicos e altamente eficientes, proporcionando evolução constante a cada sessão.
                        </div>
                    </div>
                </div>
                <div class="divider-xl hidden-mobile-devices-xs"></div>
            </div>
        </div>
    </div>
    <div class="lower-page bg-color-1">
        <div class="container-fluid nopadding">
            <div class="extra-margin-owl">
                <div class="dots">
                    <div class="the-dots"></div>
                </div>
                <div class="dots-reverse">
                    <div class="the-dots"></div>
                </div>
                <div class="divider-xl"></div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="carousel-item-img-wrapper carousel-item-img-wrapper-all">
                            <div class="owl-carousel owl-carousel-all">
                                <div class="post-box">
                                    <div class="team-item">
                                        <div class="team-item-inner">
                                            <div class="team-box">
                                                <div class="item-grid-size">
                                                    <div class="image-works">
                                                        <div class="hover-effect hover-effect-team"></div>
                                                        <div class="description">
                                                            <div class="post-description-works">
                                                                Treinos Rápidos
                                                            </div>
                                                            <div class="divider-xxs"></div>
                                                            <div class="post-description-2-works">
                                                                Resultados reais em sessões dinâmicas
                                                            </div>
                                                            <div class="divider-m-2"></div>
                                                        </div>
                                                        <img alt="Img" src="<?= asset('img/about/team/t1.png') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="post-box">
                                    <div class="team-item">
                                        <div class="team-item-inner">
                                            <div class="team-box">
                                                <div class="item-grid-size">
                                                    <div class="image-works">
                                                        <div class="hover-effect hover-effect-team"></div>
                                                        <div class="description">
                                                            <div class="post-description-works">
                                                                Método Estruturado
                                                            </div>
                                                            <div class="divider-xxs"></div>
                                                            <div class="post-description-2-works">
                                                                Planejado para evolução constante
                                                            </div>
                                                            <div class="divider-m-2"></div>
                                                        </div>
                                                        <img alt="Img" src="<?= asset('img/about/team/t2.png') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="post-box">
                                    <div class="team-item">
                                        <div class="team-item-inner">
                                            <div class="team-box">
                                                <div class="item-grid-size">
                                                    <div class="image-works">
                                                        <div class="hover-effect hover-effect-team"></div>
                                                        <div class="description">
                                                            <div class="post-description-works">
                                                                Ambiente Motivador
                                                            </div>
                                                            <div class="divider-xxs"></div>
                                                            <div class="post-description-2-works">
                                                                Cercado de pessoas com o mesmo foco
                                                            </div>
                                                            <div class="divider-m-2"></div>
                                                        </div>
                                                        <img alt="Img" src="<?= asset('img/about/team/t3.png') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divider-xl"></div>
            </div>
        </div>
        <div class="timeline-wrapper-2"></div>
    </div>
    <div class="lower-page bg-color-1" id="page-news">
        <div class="container-fluid nopadding">
            <div class="extra-margin-container">
                <div class="dots">
                    <div class="the-dots"></div>
                </div>
                <div class="dots-reverse">
                    <div class="the-dots"></div>
                </div>
                <div class="row row-eq">
                    <div class="col-md-4">
                        <div class="divider-xl hidden-mobile-devices-xs"></div>
                        <div class="center-content">
                            <div class="built-item">
                                <div class="built-item-inner">
                                    <span class="ion-android-bicycle"></span>
                                    <div class="divider-m"></div>
                                    <div class="built-item-title">Equipamentos modernos</div>
                                </div>
                                <div class="divider-l"></div>
                                <div class="built-item-inner">
                                    <span class="ion-android-favorite-outline"></span>
                                    <div class="divider-m"></div>
                                    <div class="built-item-title">Treino monitorado</div>
                                </div>
                                <div class="divider-l"></div>
                                <div class="built-item-inner">
                                    <span class="ion-android-contact"></span>
                                    <div class="divider-m"></div>
                                    <div class="built-item-title">Ambiente tecnológico</div>
                                </div>
                            </div>
                        </div>
                        <div class="divider-xl hidden-mobile-devices-xs hidden-mobile-devices-xs-991"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="divider-xl visible-mobile-only"></div>
                        <div class="section-heading section-heading-color-2 section-heading-center-true section-heading-dot">
                            <div class="section-heading-span">
                                <div class="dot dot-dark"></div>
                            </div>
                            <div class="move-up-dot">Serviços</div>
                        </div>
                        <div class="divider-l"></div>
                        <div class="main-text-l main-text-l-dark">
                            <span>Feito</span><br>
                            para<br>
                            <span>Você</span>
                        </div>
                        <div class="divider-xl visible-mobile-only"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="divider-xl hidden-mobile-only"></div>
                        <div class="center-content">
                            <div class="built-item">
                                <div class="built-item-inner">
                                    <span class="ion-android-checkmark-circle"></span>
                                    <div class="divider-m"></div>
                                    <div class="built-item-title">Treinamento intervalado</div>
                                </div>
                                <div class="divider-l"></div>
                                <div class="built-item-inner">
                                    <span class="ion-battery-charging"></span>
                                    <div class="divider-m"></div>
                                    <div class="built-item-title">Treino metabólico</div>
                                </div>
                                <div class="divider-l"></div>
                                <div class="built-item-inner">
                                    <span class="ion-ios-pulse-strong"></span>
                                    <div class="divider-m"></div>
                                    <div class="built-item-title">Alta queima calórica</div>
                                </div>
                            </div>
                        </div>
                        <div class="divider-xl hidden-mobile-devices-xs"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="lower-page bg-color-1">
        <div class="container-fluid nopadding">
            <div class="extra-margin-container">
                <div class="dots">
                    <div class="the-dots"></div>
                </div>
                <div class="dots-reverse">
                    <div class="the-dots"></div>
                </div>
                <div class="divider-xl"></div>
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="intro intro-dark go-left-xs">
                            Criamos o cenário ideal para você desafiar seus limites, ganhar confiança e alcançar resultados consistentes.
                        </div>
                        <div class="divider-m"></div>
                        <div class="testimonials-signature testimonials-signature-dark testimonials-signature-all testimonials-signature-center go-left-xs">
                            A transformação começa quando você começa.
                        </div>
                    </div>
                </div>
                <div class="divider-xl"></div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="circle-wrapper-full">
                            <div class="carousel-item-all">
                                <img alt="Img" src="<?= asset('img/about/1.jpeg') ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divider-xl"></div>
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="intro go-left-xs">
                            No HIIT Studio Integrado, oferecemos o ambiente, o método e a intensidade necessária para transformar seu esforço em evolução real.
                        </div>
                        <div class="divider-m"></div>
                        <div class="testimonials-signature testimonials-signature-all testimonials-signature-center go-left-xs">
                            Nada muda até você decidir mudar.
                        </div>
                    </div>
                </div>
                <div class="divider-xl"></div>
            </div>
        </div>
        <div class="timeline-wrapper"></div>
    </div>
    <div class="lower-page bg-color-2">
        <div class="container-fluid nopadding">
            <div class="extra-margin-container">
                <div class="divider-xl"></div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-heading section-heading-center section-heading-dot">
                            <div class="section-heading-span"><div class="dot"></div></div>
                            <div class="move-up-dot">Perguntas Frequentes</div>
                        </div>
                        <div class="divider-l"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="faq-tabs-container">
                            <div class="faq-tab active" data-target="cat-estudio">O Estúdio</div>
                            <div class="faq-tab" data-target="cat-spinning">Spinning</div>
                            <div class="faq-tab" data-target="cat-corrida">Corrida + Funcional</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-3">
                        <div id="cat-estudio" class="faq-content-pane active">
                            <div class="faq-item">
                                <div class="faq-question">Como funciona o estúdio? <i class="ion ion-plus"></i></div>
                                <div class="faq-answer">
                                    Nosso estúdio possui dois andares exclusivos:<br>
                                    • Um andar dedicado ao Spinning (Biking Indoor).<br>
                                    • Um andar exclusivo para Corrida + Funcional.<br>
                                    Ambientes organizados para oferecer foco total na experiência da aula.
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-question">As aulas acontecem ao mesmo tempo? <i class="ion ion-plus"></i></div>
                                <div class="faq-answer">
                                    Sim. As modalidades possuem horários próprios, com controle de vagas para manter qualidade e segurança.
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-question">Para quem são as aulas? <i class="ion ion-plus"></i></div>
                                <div class="faq-answer">
                                    Nossas aulas são indicadas para iniciantes, intermediários e avançados. Cada aluno treina no seu ritmo, com adaptações individuais.
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-question">Quantas vezes por semana devo treinar? <i class="ion ion-plus"></i></div>
                                <div class="faq-answer">
                                    Recomendamos de 3 a 5 vezes por semana para melhores resultados.
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-question">Posso fazer as duas modalidades? <i class="ion ion-plus"></i></div>
                                <div class="faq-answer">
                                    Sim. Muitos alunos alternam Spinning e Corrida + Funcional para potencializar resultados.
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-question">O que preciso levar? <i class="ion ion-plus"></i></div>
                                <div class="faq-answer">
                                    Roupas confortáveis, tênis adequado e garrafinha de água.
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-question">Como funciona o pagamento? <i class="ion ion-plus"></i></div>
                                <div class="faq-answer">
                                    Pix, cartão de débito ou crédito, realizado diretamente pelo site.
                                </div>
                            </div>
                        </div>
                        <div id="cat-spinning" class="faq-content-pane">
                            <div class="faq-item">
                                <div class="faq-question">Quanto tempo dura a aula de Spinning? <i class="ion ion-plus"></i></div>
                                <div class="faq-answer">
                                    A aula tem duração média de 45 minutos.
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-question">Como funciona a aula? <i class="ion ion-plus"></i></div>
                                <div class="faq-answer">
                                    É um treino intervalado na bike, com variação de intensidade, simulação de subidas, sprints e momentos de recuperação, sempre guiado pelo professor e ao ritmo da música.
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-question">Para que serve o Spinning? <i class="ion ion-plus"></i></div>
                                <div class="faq-answer">
                                    • Alto gasto calórico<br>
                                    • Melhora do condicionamento cardiovascular<br>
                                    • Definição de pernas e glúteos<br>
                                    • Redução de peso e gordura corporal
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-question">Iniciantes podem fazer? <i class="ion ion-plus"></i></div>
                                <div class="faq-answer">
                                    Sim. A intensidade é ajustada individualmente na carga da bike.
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-question">Precisa ter preparo físico? <i class="ion ion-plus"></i></div>
                                <div class="faq-answer">
                                    Não. Você evolui conforme seu ritmo.
                                </div>
                            </div>
                        </div>
                        <div id="cat-corrida" class="faq-content-pane">
                            <div class="faq-item">
                                <div class="faq-question">Quanto tempo dura essa aula? <i class="ion ion-plus"></i></div>
                                <div class="faq-answer">
                                    A aula dura em média 45 minutos.
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-question">Como funciona a aula? <i class="ion ion-plus"></i></div>
                                <div class="faq-answer">
                                    É um treino híbrido que intercala estímulos de corrida (esteira) com exercícios funcionais de força, core e resistência.
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-question">Para que serve esse tipo de treino? <i class="ion ion-plus"></i></div>
                                <div class="faq-answer">
                                    • Acelera o metabolismo<br>
                                    • Aumenta resistência cardiovascular<br>
                                    • Melhora força muscular<br>
                                    • Define o corpo<br>
                                    • Potencializa o emagrecimento
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-question">É muito intenso? <i class="ion ion-plus"></i></div>
                                <div class="faq-answer">
                                    É desafiador, mas adaptável. O professor ajusta intensidade conforme o nível do aluno.
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-question">Quem quer ganhar condicionamento para corrida pode fazer? <i class="ion ion-plus"></i></div>
                                <div class="faq-answer">
                                    Sim. O treino melhora velocidade, resistência e técnica.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divider-xl"></div>
            </div>
        </div>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const tabs = document.querySelectorAll('.faq-tab');
        const panes = document.querySelectorAll('.faq-content-pane');

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const target = this.getAttribute('data-target');

                tabs.forEach(t => t.classList.remove('active'));
                panes.forEach(p => p.classList.remove('active'));

                this.classList.add('active');
                document.getElementById(target).classList.add('active');
            });
        });

        const questions = document.querySelectorAll('.faq-question');

        questions.forEach(q => {
            q.addEventListener('click', function() {
                const parent = this.parentElement;

                document.querySelectorAll('.faq-item').forEach(item => {
                    if (item !== parent) item.classList.remove('open');
                });

                parent.classList.toggle('open');
            });
        });
    });
    </script>
    <div class="lower-page bg-color-2" id="page-pricing">
        <div class="container-fluid nopadding">
            <div class="extra-margin-container">
                <div class="dots">
                    <div class="the-dots"></div>
                </div>
                <div class="dots-reverse">
                    <div class="the-dots"></div>
                </div>
                <div class="divider-xl"></div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-heading section-heading-dot">
                            <div class="section-heading-span">
                                <div class="dot"></div>
                            </div>
                            <div class="move-up-dot">Preço</div>
                        </div>
                        <div class="divider-l"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="section-header section-header-color section-half">
                            Mais saúde<br>
                            <span>treino intenso</span><br>
                            <span>Queima de gordura</span> Condicionamento físico<br>
                            <span>Defina seu treino.</span>
                        </h1>
                    </div>
                </div>
                <div class="divider-xl"></div>
            </div>
        </div>
    </div>
    <div class="lower-page bg-color-2">
        <div class="container-fluid nopadding">
            <div class="extra-margin-container">
                <div id="swiper-avulsos" class="swiper-container swiper-avulsos" style="overflow: hidden; padding-bottom: 50px;">
                    <div class="swiper-wrapper">
                        <?php foreach ($pacotes as $p): ?>
                        <div class="swiper-slide">
                            <div class="pricing-item">
                                <div class="pricing-item-title"><?= e($p['nome']) ?></div>
                                <div class="pricing-item-price">
                                    <h2>R$ <?= number_format($p['preco'], 2, ',', '.') ?></h2>
                                </div>
                                <ul>
                                    <li><?= (int) $p['fichas'] ?> Fichas</li>
                                    <li>Válido por <?= e((string) ($p['validade_dias'] ?? '')) ?> dias</li>
                                    <li>Treino monitorado</li>
                                    <li>Acesso total ao estúdio</li>
                                </ul>
                                <div class="divider-m"></div>
                                <div class="read-more-wrapper">
                                    <a class="read-more-btn" href="<?= url('comprar-fichas?pacote=' . $p['id']) ?>"><span>Comprar</span></a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="divider-xl"></div>
            </div>
        </div>
    </div>
    <div class="lower-page bg-color-1" id="page-gallery">
        <div class="container-fluid nopadding">
            <div class="extra-margin-container">
                <div class="dots">
                    <div class="the-dots"></div>
                </div>
                <div class="dots-reverse">
                    <div class="the-dots"></div>
                </div>
                <div class="divider-xl"></div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-heading section-heading-color-2 section-heading-dot">
                            <div class="section-heading-span">
                                <div class="dot dot-dark"></div>
                            </div>
                            <div class="move-up-dot">Galeria</div>
                        </div>
                        <div class="divider-l"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-text-l main-text-l-dark-2">
                            <span>Nosso<br>
                            </span>Studio
                        </div>
                        <div class="divider-l"></div>
                        <div class="testimonials-signature testimonials-signature-dark">
                            Conheça de perto a estrutura que vai elevar seu treino.
                        </div>
                    </div>
                </div>
                <div class="divider-xl hidden-mobile-devices-xs"></div>
            </div>
        </div>
    </div>
    <div class="lower-page bg-color-1">
        <div class="container-fluid nopadding">
            <div class="extra-margin-container">
                <div class="dots">
                    <div class="the-dots"></div>
                </div>
                <div class="dots-reverse">
                    <div class="the-dots"></div>
                </div>
                <div class="divider-xl"></div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="works-section section-100vh section-gallery popup-photo-gallery">
                            <div class="container-fluid force-height no-mrg-pdg">
                                <div class="row no-gutter">
                                    <div class="col-md-12 works-section-col">
                                        <a class="popup-photo-gallery-open" href="<?= asset('img/gallery/1.jpeg') ?>" title="IMG Description">
                                            <div class="works-section-gallery-box img-1 item item-grid-size">
                                                <div class="box-img image-works">
                                                    <div class="hover-effect hover-effect-works"></div>
                                                    <div class="description">
                                                        <h3>
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </h3>
                                                        <div class="divider-xxs"></div>
                                                    </div>
                                                    <div class="img-fullwidth-all">
                                                        <img alt="Image" src="<?= asset('img/gallery/1.jpeg') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="popup-photo-gallery-open" href="<?= asset('img/gallery/3.jpeg') ?>" title="IMG Description">
                                            <div class="works-section-gallery-box img-2 item item-grid-size">
                                                <div class="box-img image-works">
                                                    <div class="hover-effect hover-effect-works"></div>
                                                    <div class="description">
                                                        <h3>
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </h3>
                                                        <div class="divider-xxs"></div>
                                                    </div>
                                                    <div class="img-fullwidth-all">
                                                        <img alt="Image" src="<?= asset('img/gallery/3.jpeg') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="popup-photo-gallery-open" href="<?= asset('img/gallery/8.jpeg') ?>" title="IMG Description">
                                            <div class="works-section-gallery-box img-3 item item-grid-size">
                                                <div class="box-img image-works">
                                                    <div class="hover-effect hover-effect-works"></div>
                                                    <div class="description">
                                                        <h3>
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </h3>
                                                        <div class="divider-xxs"></div>
                                                    </div>
                                                    <div class="img-fullwidth-all">
                                                        <img alt="Image" src="<?= asset('img/gallery/8.jpeg') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="popup-photo-gallery-open" href="<?= asset('img/gallery/4.jpeg') ?>" title="IMG Description">
                                            <div class="works-section-gallery-box img-4 item item-grid-size">
                                                <div class="box-img image-works">
                                                    <div class="hover-effect hover-effect-works"></div>
                                                    <div class="description">
                                                        <h3>
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </h3>
                                                        <div class="divider-xxs"></div>
                                                    </div>
                                                    <div class="img-fullwidth-all">
                                                        <img alt="Image" src="<?= asset('img/gallery/4.jpeg') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="popup-photo-gallery-open" href="<?= asset('img/gallery/5.jpeg') ?>" title="IMG Description">
                                            <div class="works-section-gallery-box img-5 item item-grid-size">
                                                <div class="box-img image-works">
                                                    <div class="hover-effect hover-effect-works"></div>
                                                    <div class="description">
                                                        <h3>
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </h3>
                                                        <div class="divider-xxs"></div>
                                                    </div>
                                                    <div class="img-fullwidth-all">
                                                        <img alt="Image" src="<?= asset('img/gallery/5.jpeg') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="popup-photo-gallery-open" href="<?= asset('img/gallery/6.jpeg') ?>" title="IMG Description">
                                            <div class="works-section-gallery-box img-6 item item-grid-size">
                                                <div class="box-img image-works">
                                                    <div class="hover-effect hover-effect-works"></div>
                                                    <div class="description">
                                                        <h3>
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </h3>
                                                        <div class="divider-xxs"></div>
                                                    </div>
                                                    <div class="img-fullwidth-all">
                                                        <img alt="Image" src="<?= asset('img/gallery/6.jpeg') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="popup-photo-gallery-open" href="<?= asset('img/gallery/7.jpeg') ?>" title="IMG Description">
                                            <div class="works-section-gallery-box img-7 item item-grid-size">
                                                <div class="box-img image-works">
                                                    <div class="hover-effect hover-effect-works"></div>
                                                    <div class="description">
                                                        <h3>
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </h3>
                                                        <div class="divider-xxs"></div>
                                                    </div>
                                                    <div class="img-fullwidth-all">
                                                        <img alt="Image" src="<?= asset('img/gallery/7.jpeg') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="popup-photo-gallery-open" href="<?= asset('img/gallery/2.jpeg') ?>" title="IMG Description">
                                            <div class="works-section-gallery-box img-8 item item-grid-size">
                                                <div class="box-img image-works">
                                                    <div class="hover-effect hover-effect-works"></div>
                                                    <div class="description">
                                                        <h3>
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </h3>
                                                        <div class="divider-xxs"></div>
                                                    </div>
                                                    <div class="img-fullwidth-all">
                                                        <img alt="Image" src="<?= asset('img/gallery/2.jpeg') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divider-xl hidden-mobile-devices-xs"></div>
            </div>
        </div>
    </div>
    <div class="lower-page bg-color-1">
        <div class="container-fluid nopadding">
            <div class="extra-margin-container">
                <div class="dots">
                    <div class="the-dots"></div>
                </div>
                <div class="dots-reverse">
                    <div class="the-dots"></div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="intro go-left-xs">
                            Cada detalhe foi pensado para apoiar seus objetivos, sua rotina e sua jornada rumo à força, confiança e desempenho duradouro.
                        </div>
                        <div class="divider-m"></div>
                        <div class="testimonials-signature testimonials-signature-all testimonials-signature-center go-left-xs">
                            Não espere a motivação chegar. Entre em contato e construa sua melhor versão agora.
                        </div>
                    </div>
                </div>
                <div class="divider-xl"></div>
                <div class="section-heading section-heading-color-2 section-heading-dot">
                    <div class="section-heading-span">
                        <div class="dot dot-dark"></div>
                    </div>
                    <div class="move-up-dot">Contato</div>
                </div>
                <div class="divider-xl"></div>
            </div>
        </div>
    </div>
    <div class="lower-page bg-color-1" id="page-contact">
        <div class="container-fluid nopadding">
            <div class="extra-margin-container">
                <div class="dots">
                    <div class="the-dots"></div>
                </div>
                <div class="dots-reverse">
                    <div class="the-dots"></div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="">
                            <div class="img-fullwidth-all img-fullwidth-all-full-size" style="padding-bottom: 150px;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pricing-item">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h4 class="contact-title" style="text-align:left;">Vamos treinar <span>juntos?</span></h4>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="contact-methods">
                                                        <a href="https://wa.me/5527000000000" target="_blank" class="method-item">
                                                            <div class="method-icon"><i class="fa fa-whatsapp"></i></div>
                                                            <div class="method-text">
                                                                <strong>(27) 00000-0000</strong>
                                                            </div>
                                                        </a>
                                                        <a href="mailto:contato@hiitstudio.com.br" class="method-item">
                                                            <div class="method-icon"><i class="fa fa-envelope-o"></i></div>
                                                            <div class="method-text">
                                                                <strong>contato@hiitstudio.com.br</strong>
                                                            </div>
                                                        </a>
                                                        <div class="method-item">
                                                            <div class="method-icon"><i class="fa fa-map-marker"></i></div>
                                                            <div class="method-text">
                                                                <strong>Rua Quinze de Novembro, 461, Vitória - ES</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <form action="#" id="form" method="post" name="send">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <input class="requiredField name custom-input" id="name" name="name" placeholder="Seu Nome" type="text">
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <input class="requiredField email custom-input" id="email" name="email" placeholder="Seu E-mail" type="text">
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <textarea class="requiredField message custom-input" id="message" name="message" cols="6" placeholder="Como podemos te ajudar?"></textarea>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="more-wraper-center-form">
                                                                    <button class="submit-btn-custom" id="submit" type="submit">
                                                                        Enviar Mensagem
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-md-12" style="margin-top: 20px;">
                                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3741.1513763526223!2d-40.29038021465468!3d-20.335364202430345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xb81646319c3743%3A0x938babad8bef7e57!2sR.%20Quinze%20de%20Novembro%2C%20461%20-%20Centro%20de%20Vila%20Velha%2C%20Vila%20Velha%20-%20ES%2C%2029100-031!5e0!3m2!1spt-BR!2sbr!4v1772059209633!5m2!1spt-BR!2sbr" style="border-radius:20px;" width="100%" height="200" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="timeline-wrapper"></div>
    </div>
    <div class="footer-end">
        <p class="gray">Todos os direitos reservados a HIIT STUDIO - 2026</p>
    </div>
    <a href="#page-home">
        <div class="to-top-arrow">
            <span class="ion-ios-arrow-up"></span>
        </div>
    </a>
    <a href="https://wa.me/5527000000000" class="whats" target="_blank">
        <i style="margin-top:16px" class="fa fa-whatsapp"></i>
    </a>
    <script src="<?= asset('js/plugins.js') ?>"></script>
    <script src="<?= asset('js/main.js') ?>"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const swiperConfig = {
            slidesPerView: 3,
            spaceBetween: 30,
            slidesPerGroup: 1,
            loop: false,
            observer: true,
            observeParents: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                    spaceBetween: 10
                },
                768: {
                    slidesPerView: 1,
                    spaceBetween: 20
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30
                }
            }
        };

        if (document.querySelector('.swiper-avulsos')) {
            new Swiper('.swiper-avulsos', swiperConfig);
        }

        if (document.querySelector('.swiper-trimestral')) {
            new Swiper('.swiper-trimestral', swiperConfig);
        }
    });
    </script>
</body>
</html>
