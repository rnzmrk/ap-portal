<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PoGppoController;
use App\Http\Controllers\JoEvaluationController;

Route::get('/', function () {
    return view('web');
})->name('home');

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.submit');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.submit');
    
    Route::get('/register-employee', [AuthController::class, 'showEmployeeRegister'])
        ->name('register.employee');

    Route::post('/register-employee', [AuthController::class, 'registerEmployee'])
    ->name('register.employee.submit');
});

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('jo-evaluation/{joEvaluation}/file/{index}', [JoEvaluationController::class, 'file'])
        ->name('jo-evaluation.file');

    Route::get('po-gppo/{poGppo}/file/{index}', [PoGppoController::class, 'file'])
        ->name('po-gppo.file');
    Route::middleware('role:supplier')
        ->prefix('supplier')
        ->name('supplier.')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'supplierDashboard'])
                ->name('dashboard');

            Route::resource('po-gppo', PoGppoController::class)
                ->parameters([
                    'po-gppo' => 'poGppo'
                ]);

            Route::resource('jo-evaluation', JoEvaluationController::class)
                ->parameters([
                    'jo-evaluation' => 'joEvaluation'
                ])
                ->except(['edit', 'update']);
        });

    /*
    |--------------------------------------------------------------------------
    | Procurement
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:procurement')
        ->prefix('procurement')
        ->name('procurement.')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'procurementDashboard'])
                ->name('dashboard');

            Route::resource('po-gppo', PoGppoController::class)
                ->only(['index', 'show', 'edit', 'update']);

            Route::resource('jo-evaluation', JoEvaluationController::class)
                ->only(['index', 'show', 'edit', 'update']);
        });

    /*
    |--------------------------------------------------------------------------
    | Finance
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:finance')
        ->prefix('finance')
        ->name('finance.')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'financeDashboard'])
                ->name('dashboard');

            Route::resource('po-gppo', PoGppoController::class)
                ->only(['index', 'show', 'edit', 'update']);

            Route::resource('jo-evaluation', JoEvaluationController::class)
                ->only(['index', 'show', 'edit', 'update']);
        });

    /*
    |--------------------------------------------------------------------------
    | Operations
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:operations')
        ->prefix('operations')
        ->name('operations.')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'operationsDashboard'])
                ->name('dashboard');

            Route::resource('po-gppo', PoGppoController::class)
                ->only(['index', 'show', 'edit', 'update']);

            Route::resource('jo-evaluation', JoEvaluationController::class)
                ->only(['index', 'show', 'edit', 'update']);
        });
});
