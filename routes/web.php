<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PratoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\IngredienteController;


// ============ ROTAS PÚBLICAS ============
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ============ AUTENTICAÇÃO ============
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============ ROTAS DO SISTEMA ============
Route::get('/scan', [ScanController::class, 'index'])->name('scan');
Route::post('/scan', [ScanController::class, 'store'])->name('scan.store');

Route::get('/menu', [MenuController::class, 'index'])->name('menu');

Route::match(['get', 'post'], '/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/finalizar', [CheckoutController::class, 'store'])->name('checkout.store');

Route::get('/order/success/{orderId}', function ($orderId) {
    return view('order-success', compact('orderId'));
})->name('order.success');

// ============ ROTAS FUTURAS ============
use Laravel\Socialite\Facades\Socialite;
Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('auth.google');

Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::post('/mesa/login', [MesaController::class, 'loginMesa'])->name('mesa.login');

// ============ PAINEL ADMIN (protegido) ============
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // Clientes - CRUD Completo
    Route::get('/clientes', [AdminController::class, 'clientes'])->name('clientes');
    Route::get('/clientes/create', [AdminController::class, 'createCliente'])->name('clientes.create');
    Route::post('/clientes', [AdminController::class, 'storeCliente'])->name('clientes.store');
    Route::get('/clientes/{id}/edit', [AdminController::class, 'editCliente'])->name('clientes.edit');
    Route::put('/clientes/{id}', [AdminController::class, 'updateCliente'])->name('clientes.update');
    Route::delete('/clientes/{id}', [AdminController::class, 'deleteCliente'])->name('clientes.delete');

    // Buscar cidades via AJAX
    Route::get('/buscar-cidades', [AdminController::class, 'buscarCidades'])->name('buscar.cidades');

    // ========== PRATOS - CRUD Completo ==========
    Route::prefix('pratos')->name('pratos.')->group(function () {
        Route::get('/', [PratoController::class, 'index'])->name('index');
        Route::get('/create', [PratoController::class, 'create'])->name('create');
        Route::post('/', [PratoController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PratoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PratoController::class, 'update'])->name('update');
        Route::delete('/{id}', [PratoController::class, 'destroy'])->name('destroy');
    });

    // ========== PEDIDOS - CRUD Completo ==========
    Route::prefix('pedidos')->name('pedidos.')->group(function () {
        Route::get('/', [PedidoController::class, 'index'])->name('index');
        Route::get('/{id}', [PedidoController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [PedidoController::class, 'edit'])->name('edit'); // NOVO
        Route::put('/{id}', [PedidoController::class, 'update'])->name('update'); // NOVO
        Route::post('/{id}/encerrar', [PedidoController::class, 'encerrar'])->name('encerrar');
        Route::post('/{id}/cancelar', [PedidoController::class, 'cancelar'])->name('cancelar'); // NOVO
        Route::delete('/{id}', [PedidoController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('mesas')->name('mesas.')->group(function () {
        Route::get('/', [MesaController::class, 'index'])->name('index');
        Route::get('/qrcodes', [MesaController::class, 'qrcodes'])->name('qrcodes');
        Route::get('/create', [MesaController::class, 'create'])->name('create');
        Route::post('/', [MesaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [MesaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MesaController::class, 'update'])->name('update');
        Route::delete('/{id}', [MesaController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/ativar', [MesaController::class, 'ativar'])->name('ativar');
    });

    // Fornecedores - CRUD Completo
    Route::get('/fornecedores', [FornecedorController::class, 'index'])->name('fornecedores');
    Route::get('/fornecedores/create', [FornecedorController::class, 'create'])->name('fornecedores.create');
    Route::post('/fornecedores', [FornecedorController::class, 'store'])->name('fornecedores.store');
    Route::get('/fornecedores/{id}/edit', [FornecedorController::class, 'edit'])->name('fornecedores.edit');
    Route::put('/fornecedores/{id}', [FornecedorController::class, 'update'])->name('fornecedores.update');
    Route::delete('/fornecedores/{id}', [FornecedorController::class, 'destroy'])->name('fornecedores.destroy');

    // Ingredientes - CRUD Completo
    Route::get('/ingredientes', [IngredienteController::class, 'index'])->name('ingredientes');
    Route::get('/ingredientes/create', [IngredienteController::class, 'create'])->name('ingredientes.create');
    Route::post('/ingredientes', [IngredienteController::class, 'store'])->name('ingredientes.store');
    Route::get('/ingredientes/{id}/edit', [IngredienteController::class, 'edit'])->name('ingredientes.edit');
    Route::put('/ingredientes/{id}', [IngredienteController::class, 'update'])->name('ingredientes.update');
    Route::delete('/ingredientes/{id}', [IngredienteController::class, 'destroy'])->name('ingredientes.destroy');
    Route::post('/ingredientes/{id}/adicionar-estoque', [IngredienteController::class, 'adicionarEstoque'])->name('ingredientes.adicionar-estoque');
});