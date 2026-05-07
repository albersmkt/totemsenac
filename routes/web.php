<?php

use App\Http\Controllers\Admin\ActionController as AdminActionController;
use App\Http\Controllers\Admin\AreaController as AdminAreaController;
use App\Http\Controllers\Admin\ApprovalController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EntrepreneurController as AdminEntrepreneurController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\IntegratorProjectController as AdminProjectController;
use App\Http\Controllers\Admin\UnidadeController as AdminUnidadeController;
use App\Http\Controllers\Admin\UnitContextController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Totem\ActionController;
use App\Http\Controllers\Totem\BemestarController;
use App\Http\Controllers\Totem\CoursesController;
use App\Http\Controllers\Totem\EntrepreneurController;
use App\Http\Controllers\Totem\EventController;
use App\Http\Controllers\Totem\ExternalLinkController;
use App\Http\Controllers\Totem\HomeController;
use App\Http\Controllers\Totem\ProjectController;
use App\Http\Controllers\Totem\SenacProxyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('totem.home');

Route::get('/acoes', [ActionController::class, 'index'])->name('totem.actions.index');
Route::get('/acoes/{action}', [ActionController::class, 'show'])->name('totem.actions.show');

Route::get('/eventos', [EventController::class, 'index'])->name('totem.events.index');
Route::get('/eventos/{event}', [EventController::class, 'show'])->name('totem.events.show');

Route::get('/projetos', [ProjectController::class, 'index'])->name('totem.projects.index');
Route::get('/projetos/{project}', [ProjectController::class, 'show'])->name('totem.projects.show');

Route::get('/empreendedores', [EntrepreneurController::class, 'index'])->name('totem.entrepreneurs.index');
Route::get('/empreendedores/{entrepreneur}', [EntrepreneurController::class, 'show'])->name('totem.entrepreneurs.show');
Route::get('/cursos', [CoursesController::class, 'index'])->name('totem.courses');
Route::get('/bemestar', [BemestarController::class, 'index'])->name('totem.bemestar');
Route::get('/externo', [ExternalLinkController::class, 'show'])->name('totem.external');
Route::get('/senac-proxy/{path?}', [SenacProxyController::class, 'handle'])
    ->where('path', '.*')
    ->name('senac.proxy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:super_admin|admin_unidade|operador|estudante'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::middleware('role:super_admin|admin_unidade|operador')->group(function () {
            Route::resource('acoes', AdminActionController::class)
                ->parameters(['acoes' => 'action'])
                ->except(['show'])
                ->names('actions');
            Route::resource('eventos', AdminEventController::class)
                ->parameters(['eventos' => 'event'])
                ->except(['show'])
                ->names('events');
        });

        Route::middleware('role:super_admin|admin_unidade|estudante')->group(function () {
            Route::resource('projetos', AdminProjectController::class)
                ->parameters(['projetos' => 'project'])
                ->except(['show'])
                ->names('projects');
            Route::resource('empreendedores', AdminEntrepreneurController::class)
                ->parameters(['empreendedores' => 'entrepreneur'])
                ->except(['show'])
                ->names('entrepreneurs');
        });

        Route::middleware('role:super_admin')->group(function () {
            Route::post('/unidade-contexto', [UnitContextController::class, 'update'])->name('unit-context.update');

            Route::resource('unidades', AdminUnidadeController::class)
                ->parameters(['unidades' => 'unidade'])
                ->except(['show']);
        });

        Route::middleware('role:super_admin|admin_unidade')->group(function () {
            Route::get('/aprovacoes', [ApprovalController::class, 'index'])->name('approvals.index');
            Route::get('/aprovacoes/acoes/{action}', [ApprovalController::class, 'showAction'])->name('approvals.actions.show');
            Route::get('/aprovacoes/eventos/{event}', [ApprovalController::class, 'showEvent'])->name('approvals.events.show');
            Route::get('/aprovacoes/empreendedores/{entrepreneur}', [ApprovalController::class, 'showEntrepreneur'])->name('approvals.entrepreneurs.show');
            Route::get('/aprovacoes/projetos/{project}', [ApprovalController::class, 'showProject'])->name('approvals.projects.show');

            Route::resource('usuarios', AdminUserController::class)
                ->parameters(['usuarios' => 'user'])
                ->names('users')
                ->except(['show']);

            Route::resource('areas', AdminAreaController::class)
                ->parameters(['areas' => 'area'])
                ->except(['show']);

            Route::post('/aprovacoes/empreendedores/{entrepreneur}/aprovar', [ApprovalController::class, 'approveEntrepreneur'])
                ->name('approvals.entrepreneurs.approve');
            Route::post('/aprovacoes/empreendedores/{entrepreneur}/reprovar', [ApprovalController::class, 'rejectEntrepreneur'])
                ->name('approvals.entrepreneurs.reject');

            Route::post('/aprovacoes/acoes/{action}/aprovar', [ApprovalController::class, 'approveAction'])
                ->name('approvals.actions.approve');
            Route::post('/aprovacoes/acoes/{action}/reprovar', [ApprovalController::class, 'rejectAction'])
                ->name('approvals.actions.reject');

            Route::post('/aprovacoes/eventos/{event}/aprovar', [ApprovalController::class, 'approveEvent'])
                ->name('approvals.events.approve');
            Route::post('/aprovacoes/eventos/{event}/reprovar', [ApprovalController::class, 'rejectEvent'])
                ->name('approvals.events.reject');

            Route::post('/aprovacoes/projetos/{project}/aprovar', [ApprovalController::class, 'approveProject'])
                ->name('approvals.projects.approve');
            Route::post('/aprovacoes/projetos/{project}/reprovar', [ApprovalController::class, 'rejectProject'])
                ->name('approvals.projects.reject');
        });
    });

require __DIR__.'/auth.php';
