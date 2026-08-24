<?php

use App\Controllers\Admin\ClassController as AdminClassController;
use App\Controllers\Admin\CouponController;
use App\Controllers\Admin\PackageController as AdminPackageController;
use App\Controllers\Admin\StudentController;
use App\Controllers\AuthController;
use App\Controllers\CheckoutController;
use App\Controllers\DashboardController;
use App\Controllers\GoogleAuthController;
use App\Controllers\PasswordResetController;
use App\Controllers\PaymentController;
use App\Controllers\ProfileController;
use App\Controllers\SiteController;
use App\Controllers\SubscriptionController;
use App\Controllers\WebhookController;
use App\Core\Router;

$router = new Router();

$router->get('/', [SiteController::class, 'home']);

$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/cadastro', [AuthController::class, 'showCadastro']);
$router->post('/cadastro', [AuthController::class, 'cadastrar']);
$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/recuperar-senha', [PasswordResetController::class, 'show']);
$router->post('/recuperar-senha', [PasswordResetController::class, 'send']);
$router->get('/redefinir-senha', [PasswordResetController::class, 'showReset']);
$router->post('/redefinir-senha', [PasswordResetController::class, 'reset']);

$router->get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle']);
$router->get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/agendar', [DashboardController::class, 'agendar']);
$router->get('/cancelar-agendamento', [DashboardController::class, 'cancelar']);
$router->get('/minha-agenda', [DashboardController::class, 'agenda']);

$router->get('/editar-perfil', [ProfileController::class, 'show']);
$router->post('/editar-perfil', [ProfileController::class, 'update']);

$router->get('/comprar-fichas', [CheckoutController::class, 'pacotes']);
$router->get('/pagar-cartao', [CheckoutController::class, 'formularioCartao']);
$router->post('/validar-cupom', [CheckoutController::class, 'validarCupom']);
$router->get('/status-pagamento', [CheckoutController::class, 'status']);
$router->get('/pagar-pix', [CheckoutController::class, 'pagarPix']);

$router->post('/checkout/cartao', [PaymentController::class, 'cartaoAvulso']);
$router->get('/checkout/pix', [PaymentController::class, 'pix']);
$router->get('/checkout/pix/status', [PaymentController::class, 'statusPix']);

$router->post('/assinaturas/ativar', [SubscriptionController::class, 'ativar']);
$router->get('/assinaturas/cancelar', [SubscriptionController::class, 'cancelar']);

$router->post('/webhooks/mercadopago', [WebhookController::class, 'mercadoPago']);
$router->post('/webhooks/pagarme/assinatura', [WebhookController::class, 'pagarmeAssinatura']);

$router->get('/admin/alunos', [StudentController::class, 'index']);
$router->get('/admin/alunos/ativar', [StudentController::class, 'ativar']);
$router->get('/admin/alunos/inativar', [StudentController::class, 'inativar']);
$router->post('/admin/alunos', [StudentController::class, 'atualizar']);

$router->get('/admin/aulas', [AdminClassController::class, 'index']);
$router->post('/admin/aulas', [AdminClassController::class, 'salvar']);
$router->get('/admin/aulas/excluir', [AdminClassController::class, 'excluir']);
$router->get('/admin/aulas/{id}', [AdminClassController::class, 'detalhes']);
$router->post('/admin/aulas/{id}', [AdminClassController::class, 'detalhes']);

$router->get('/admin/pacotes', [AdminPackageController::class, 'index']);
$router->post('/admin/pacotes', [AdminPackageController::class, 'salvar']);
$router->get('/admin/pacotes/excluir', [AdminPackageController::class, 'excluir']);

$router->get('/admin/cupons', [CouponController::class, 'index']);
$router->post('/admin/cupons', [CouponController::class, 'salvar']);
$router->get('/admin/cupons/excluir', [CouponController::class, 'excluir']);

return $router;
