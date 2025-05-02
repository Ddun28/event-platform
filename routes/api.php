<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{
    EventController,
    CategoryController,
    TagController,
    UserController,
    NotificationController,
    FileController
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Autenticación
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Auth\LoginController@login');
    
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'Auth\LoginController@logout');
        Route::get('user', 'Auth\LoginController@user');
        Route::put('profile', [UserController::class, 'updateProfile']);
    });
});

// Recuperación de contraseña
Route::group([
    'namespace' => 'Auth',
    'middleware' => 'api',
    'prefix' => 'password'
], function () {
    Route::post('reset', 'ResetPasswordController@reset');
    Route::post('forgot', 'ForgotPasswordController@sendResetLinkEmail');
});

// Archivos
Route::get('files/{any}', [FileController::class, 'show'])->where('any', '.*');

Route::group(['middleware' => 'auth:api'], function() {

    // Configuraciones y datos maestros
    Route::get('event_types', 'InvokeController@eventTypes');
    Route::get('locations', 'InvokeController@locations');
    Route::get('tags_categories', 'InvokeController@tagsAndCategories');
    
    // Archivos
    Route::post('files', [FileController::class, 'store']);
    Route::delete('files/{any}', [FileController::class, 'destroy'])->where('any', '.*');

    // Eventos
    Route::group(['prefix' => 'events'], function() {
        Route::get('calendar', [EventController::class, 'calendarView']);
        Route::post('{event}/register', [EventController::class, 'register']);
        Route::put('{event}/status', [EventController::class, 'updateStatus']);
        Route::get('{event}/participants', [EventController::class, 'participants']);
        Route::post('{event}/notify', [EventController::class, 'sendNotification']);
        Route::get('export/{format}', [EventController::class, 'export']);
    });

    // Notificaciones
    Route::group(['prefix' => 'notifications'], function() {
        Route::get('/', [NotificationController::class, 'index']);
        Route::put('{id}/read', [NotificationController::class, 'markAsRead']);
        Route::delete('{id}', [NotificationController::class, 'destroy']);
    });

    // Reportes y Dashboard
    Route::get('dashboard', 'DashboardController@index');
    Route::get('reports/attendance', 'ReportController@attendanceReport');
    Route::get('reports/events', 'ReportController@eventsReport');

    // CRUD Resources
    Route::apiResources([
        'events' => EventController::class,
        'categories' => CategoryController::class,
        'tags' => TagController::class,
        'users' => UserController::class
    ]);

    // Operaciones batch
    Route::group(['middleware' => 'transaction.db'], function() {
        Route::post('events/batch', [EventController::class, 'batchCreate']);
        Route::put('categories/batch', [CategoryController::class, 'batchUpdate']);
        Route::delete('tags/batch', [TagController::class, 'batchDelete']);
    });

    // Configuraciones avanzadas
    Route::group(['prefix' => 'settings', 'middleware' => 'admin'], function() {
        Route::get('roles', 'RoleController@index');
        Route::put('permissions', 'PermissionController@update');
        Route::get('audit', 'AuditController@index');
    });
});

// Health Check
Route::get('health', function() {
    return response()->json([
        'status' => 'ok',
        'version' => config('app.version'),
        'environment' => config('app.env')
    ]);
});