<?php

/**
 * Authentication
 */

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Vanguard\Http\Controllers\ChartController;
use Vanguard\Models\LogCallback;
use Vanguard\Models\RefApiStatus;

Route::get('login', 'Auth\LoginController@show');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('auth.logout');

Route::get('insert-bank', function () {
    $response = Http::get('https://raw.githubusercontent.com/mul14/gudang-data/master/bank/bank.json');
    // dd(json_decode($response));
    foreach (json_decode($response) as $value) {
        echo $value->name . '<br>';
    }
});


Route::group(['middleware' => ['registration', 'guest']], function () {
    Route::get('register', 'Auth\RegisterController@show');
    Route::post('register', 'Auth\RegisterController@register');
});

Route::emailVerification();

Route::group(['middleware' => ['password-reset', 'guest']], function () {
    Route::resetPassword();
});

/**
 * Two-Factor Authentication
 */
Route::group(['middleware' => 'two-factor'], function () {
    Route::get('auth/two-factor-authentication', 'Auth\TwoFactorTokenController@show')->name('auth.token');
    Route::post('auth/two-factor-authentication', 'Auth\TwoFactorTokenController@update')->name('auth.token.validate');
});

/**
 * Social Login
 */
Route::get('auth/{provider}/login', 'Auth\SocialAuthController@redirectToProvider')->name('social.login');
Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');

//Overbooking
Route::get('overbooking', 'Overbooking\OverbookingController@index');
Route::get('overbooking-pdf', 'PDF\PdfOverbookingController@generatePDF');

/**
 * Impersonate Routes
 */
Route::group(['middleware' => 'auth'], function () {
    Route::impersonate();
});
Route::get('/testing_view',  'DashboardController@testing_view');
Route::post('/testing',  'DashboardController@testing')->name('testing.nama');
Route::group(['middleware' => ['auth', 'verified']], function () {

    /**
     * Dashboard
     */

    Route::get('/', 'DashboardController@index')->name('dashboard');

    /**
     * User Profile
     */

    Route::group(['prefix' => 'profile', 'namespace' => 'Profile'], function () {
        Route::get('/', 'ProfileController@show')->name('profile');
        Route::get('activity', 'ActivityController@show')->name('profile.activity');
        Route::put('details', 'DetailsController@update')->name('profile.update.details');

        Route::post('avatar', 'AvatarController@update')->name('profile.update.avatar');
        Route::post('avatar/external', 'AvatarController@updateExternal')
            ->name('profile.update.avatar-external');

        Route::put('login-details', 'LoginDetailsController@update')
            ->name('profile.update.login-details');

        Route::get('sessions', 'SessionsController@index')
            ->name('profile.sessions')
            ->middleware('session.database');

        Route::delete('sessions/{session}/invalidate', 'SessionsController@destroy')
            ->name('profile.sessions.invalidate')
            ->middleware('session.database');
    });

    /**
     * Two-Factor Authentication Setup
     */

    Route::group(['middleware' => 'two-factor'], function () {
        Route::post('two-factor/enable', 'TwoFactorController@enable')->name('two-factor.enable');

        Route::get('two-factor/verification', 'TwoFactorController@verification')
            ->name('two-factor.verification')
            ->middleware('verify-2fa-phone');

        Route::post('two-factor/resend', 'TwoFactorController@resend')
            ->name('two-factor.resend')
            ->middleware('throttle:1,1', 'verify-2fa-phone');

        Route::post('two-factor/verify', 'TwoFactorController@verify')
            ->name('two-factor.verify')
            ->middleware('verify-2fa-phone');

        Route::post('two-factor/disable', 'TwoFactorController@disable')->name('two-factor.disable');
    });



    /**
     * User Management
     */
    Route::resource('users', 'Users\UsersController')
        ->except('update')->middleware('permission:users.manage');

    Route::get('province', 'Users\UsersController@getProvince')->name('users.province')->middleware('permission:users.manage');
    Route::get('regency', 'Users\UsersController@getRegency')->name('users.regency')->middleware('permission:users.manage');

    Route::group(['prefix' => 'users/{user}', 'middleware' => 'permission:users.manage'], function () {
        Route::put('update/details', 'Users\DetailsController@update')->name('users.update.details');
        Route::put('update/login-details', 'Users\LoginDetailsController@update')
            ->name('users.update.login-details');

        Route::post('update/avatar', 'Users\AvatarController@update')->name('user.update.avatar');
        Route::post('update/avatar/external', 'Users\AvatarController@updateExternal')
            ->name('user.update.avatar.external');

        Route::get('sessions', 'Users\SessionsController@index')
            ->name('user.sessions')->middleware('session.database');

        Route::delete('sessions/{session}/invalidate', 'Users\SessionsController@destroy')
            ->name('user.sessions.invalidate')->middleware('session.database');

        Route::post('two-factor/enable', 'TwoFactorController@enable')->name('user.two-factor.enable');
        Route::post('two-factor/disable', 'TwoFactorController@disable')->name('user.two-factor.disable');
    });

    /**
     * Roles & Permissions
     */
    Route::group(['namespace' => 'Authorization'], function () {
        Route::resource('roles', 'RolesController')->except('show')->middleware('permission:roles.manage');

        Route::post('permissions/save', 'RolePermissionsController@update')
            ->name('permissions.save')
            ->middleware('permission:permissions.manage');

        Route::resource('permissions', 'PermissionsController')->middleware('permission:permissions.manage');
    });

    /**
     * Settings
     */

    Route::get('settings', 'SettingsController@general')->name('settings.general')
        ->middleware('permission:settings.general');

    Route::post('settings/general', 'SettingsController@update')->name('settings.general.update')
        ->middleware('permission:settings.general');

    Route::get('settings/auth', 'SettingsController@auth')->name('settings.auth')
        ->middleware('permission:settings.auth');

    Route::post('settings/auth', 'SettingsController@update')->name('settings.auth.update')
        ->middleware('permission:settings.auth');

    if (config('services.authy.key')) {
        Route::post('settings/auth/2fa/enable', 'SettingsController@enableTwoFactor')
            ->name('settings.auth.2fa.enable')
            ->middleware('permission:settings.auth');

        Route::post('settings/auth/2fa/disable', 'SettingsController@disableTwoFactor')
            ->name('settings.auth.2fa.disable')
            ->middleware('permission:settings.auth');
    }

    Route::post('settings/auth/registration/captcha/enable', 'SettingsController@enableCaptcha')
        ->name('settings.registration.captcha.enable')
        ->middleware('permission:settings.auth');

    Route::post('settings/auth/registration/captcha/disable', 'SettingsController@disableCaptcha')
        ->name('settings.registration.captcha.disable')
        ->middleware('permission:settings.auth');

    Route::get('settings/notifications', 'SettingsController@notifications')
        ->name('settings.notifications')
        ->middleware('permission:settings.notifications');

    Route::post('settings/notifications', 'SettingsController@update')
        ->name('settings.notifications.update')
        ->middleware('permission:settings.notifications');

    /**
     * Activity Log
     */

    Route::get('activity', 'ActivityController@index')->name('activity.index')
        ->middleware('permission:users.activity');

    Route::get('activity/user/{user}/log', 'Users\ActivityController@index')->name('activity.user')
        ->middleware('permission:users.activity');


    /**
     * Transaction Log
     */

    Route::prefix('log-transaction')->group(function () {
        Route::prefix('bank')->group(function () {
            Route::get('/', "TrxLog\LogBank\MainController@index")->name('trxLog.bank')->middleware('auth');
            Route::get('/getData/{rst_id}/{perPage}/{filter?}', "TrxLog\LogBank\MainController@getData");
            Route::get('/render-filter', 'TrxLog\LogBank\MainController@renderFilter');
        });

        Route::prefix('sipd')->group(function () {
            Route::get('/', "TrxLog\LogSIPD\MainController@index")->name('trxLog.sipd')->middleware('auth');
            Route::get('/getData/{rst_id}/{perPage}/{filter?}', "TrxLog\LogSIPD\MainController@getData");
            Route::get('/render-filter', 'TrxLog\LogSIPD\MainController@renderFilter');
        });
    });

    /**
     * History Over Booking
     */
    Route::middleware(['auth'])->group(function () {
        Route::prefix('history-overbooking')->group(function () {
            Route::get('/', 'history_overbooking\MainController@index')->name('historyOverbooking.index');
            Route::get('/column-header', 'history_overbooking\MainController@columnHeader');
            Route::get('/column-data/{column_name}', 'history_overbooking\MainController@columnData');
            Route::get('/render-filter', 'history_overbooking\MainController@renderFilterForm');
        });
    });

    /** CRUD Master Data */
    Route::prefix('master-data')->group(function () {
        // Route::get('/', 'MasterData\MasterDataController@index')->middleware('auth');
        Route::middleware(['permission:master.data_refBank'])->group(function () {
            Route::prefix('bank')->group(function () {
                Route::get('/', 'MasterData\MasterDataController@getRefBank')->name('masterdata.refbank');
                Route::get('get/{id}', 'MasterData\Bank\MainController@getBankData');
                Route::post('/', 'MasterData\Bank\MainController@post');
                Route::put('/', 'MasterData\Bank\MainController@put');
                Route::get('{id}/{checked}/delete', 'MasterData\Bank\MainController@delete');
            });
        });

        Route::middleware(['permission:master.data_bankSecret'])->group(function () {
            Route::prefix('bank-secret')->group(function () {
                Route::get('/', 'MasterData\MasterDataController@getBankSecret')->name('masterdata.bankSecret');
                Route::get('get-avail', 'MasterData\BankSecret\MainController@getAvailBank');
                Route::post('/', 'MasterData\BankSecret\MainController@post');
                Route::get('{id}/{checked}/delete', 'MasterData\BankSecret\MainController@delete');
                Route::put('/', 'MasterData\BankSecret\MainController@put');
                Route::get('deleteToken/{id}', 'MasterData\BankSecret\MainController@deleteToken');
            });
        });

        Route::middleware(['permission:master.data_bankEndpoint'])->group(function () {
            Route::prefix('bank-endpoint')->group(function () {
                Route::get('/', 'MasterData\MasterDataController@getBankEndpoint')->name('masterdata.bankEndpoint');
                Route::get('get-banksecret', 'MasterData\BankEndpoint\MainController@getBankSecret');
                Route::get('get-endpoint', 'MasterData\BankEndpoint\MainController@getEndpointType');
                Route::post('/', 'MasterData\BankEndpoint\MainController@post');
                Route::post('/add-wizard', 'MasterData\BankEndpoint\MainController@postWizard');
                Route::get('{dbs_id}/{id}/delete', 'MasterData\BankEndpoint\MainController@delete');
                Route::put('/', 'MasterData\BankEndpoint\MainController@put');
            });
        });

        Route::middleware(['permission:master.data_refApiStatus'])->group(function () {
            Route::prefix('api-status')->group(function () {
                Route::get('/', 'MasterData\MasterDataController@getApiStatus')->name('masterdata.refApiStatus');
                Route::get('get/{id}', 'MasterData\ApiStatus\MainController@getApiStatus');
                Route::post('/', 'MasterData\ApiStatus\MainController@post');
                Route::put('/', 'MasterData\ApiStatus\MainController@put');
                Route::get('{id}/delete', 'MasterData\ApiStatus\MainController@delete');
            });
        });
    });

    /** Log Callback */
    Route::get('log-callback', 'LogCallback\LogCallbackController@index')->name('logCallback.index');

    /** Crud  Api User */

    Route::get('user-service', 'ApiUser\ApiUserController@index')->name('user-service.index');
    Route::get('user-service/form', 'ApiUser\ApiUserController@form');
    Route::post('user-service/post', 'ApiUser\ApiUserController@post')->name('user-service-post');
    Route::post('user-service/add/save', 'ApiUser\ApiUserController@saveAdd');
    Route::post('user-service/edit/save', 'ApiUser\ApiUserController@saveEdit');

    Route::get('user-service/ip/view/{bank}', 'ApiUser\IpController@getIpByDbs')->name('user-service.ip.index');
    Route::post('user-service/ip/save', 'ApiUser\IpController@saveIp')->name('user-service.ip.save');
    Route::delete('user-service/ip/delete/{id}', 'ApiUser\IpController@deleteDatIp')->name('user-service.ip.delete');

    Route::get('integrasi-bank/add', function () {
        return view('integrasi_bank/index');
    })->name('integrasi-bank');

    // Overbooking New
    Route::get('transaksi', 'Overbooking\OverbookingController@index')->name('transaksi-overbooking');
    Route::get('transaksi/callback/{id}', 'Overbooking\OverbookingController@getCallbackLast');
    Route::post('transaksi/form', 'Overbooking\OverbookingController@data');
    Route::post('transaksi/export/file', 'Overbooking\OverbookingController@exportToFile');

    Route::get('stream-log', function() {
        return view('stream_log/index');
    })->name('stream-log');
});


/**
 * Installation
 */

Route::group(['prefix' => 'install'], function () {
    Route::get('/', 'InstallController@index')->name('install.start');
    Route::get('requirements', 'InstallController@requirements')->name('install.requirements');
    Route::get('permissions', 'InstallController@permissions')->name('install.permissions');
    Route::get('database', 'InstallController@databaseInfo')->name('install.database');
    Route::get('start-installation', 'InstallController@installation')->name('install.installation');
    Route::post('start-installation', 'InstallController@installation')->name('install.installation');
    Route::post('install-app', 'InstallController@install')->name('install.install');
    Route::get('complete', 'InstallController@complete')->name('install.complete');
    Route::get('error', 'InstallController@error')->name('install.error');
});

Route::prefix('chart')->group(function () {
    Route::post('/tx-type', [ChartController::class, 'chartTxType']);
    Route::post('/tx-bank', [ChartController::class, 'chartTxBank']);
    Route::post('/tx-status', [ChartController::class, 'chartTxStatus']);
    Route::post('/tx-daily', [ChartController::class, 'chartTxDaily']);
});
