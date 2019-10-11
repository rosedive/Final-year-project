<?php

/**
 * Authentication
 */

Route::get('login', 'Auth\AuthController@getLogin');

Route::get('staff-login', [ 'as' => 'auth.staff', 'uses' => 'Auth\AuthController@getStaffLogin']);
Route::get('student-login', [ 'as' => 'auth.student', 'uses' => 'Auth\AuthController@getStudentLogin']);

Route::post('staff-login', [ 'as' => 'auth.staff', 'uses' => 'Auth\AuthController@postStaffLogin']);
Route::post('student-login', [ 'as' => 'auth.student', 'uses' => 'Auth\AuthController@postStudentLogin']);

Route::get('logout', [
    'as' => 'auth.logout',
    'uses' => 'Auth\AuthController@getLogout'
]);

// Allow registration routes only if registration is enabled.
if (settings('reg_enabled')) {
    Route::get('register', 'Auth\AuthController@getRegister');
    Route::post('register', 'Auth\AuthController@postRegister');
    Route::get('register/confirmation/{token}', [
        'as' => 'register.confirm-email',
        'uses' => 'Auth\AuthController@confirmEmail'
    ]);
}

// Register password reset routes only if it is enabled inside website settings.
if (settings('forgot_password')) {
    Route::get('password/remind', 'Auth\PasswordController@forgotPassword');
    Route::post('password/remind', 'Auth\PasswordController@sendPasswordReminder');
    Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
    Route::post('password/reset', 'Auth\PasswordController@postReset');
}

Route::group(['middleware' => 'auth'], function () {

    /**
     * Dashboard
     */

    Route::get('/', [
        'as' => 'dashboard',
        'uses' => 'DashboardController@index'
    ]);


     /**
     * upload
     */



//  Route::get('/upload',[

//   'as' => 'add-edit',
//   'uses' => 'UploadController@index'
// ]
// );

//   Route::Post('/upload',[

//   'as' => 'add-edit',
//   'uses' => 'UploadController@upload'
// ]
// );

    /**
     * User Profile
     */




    Route::get('profile', [
        'as' => 'profile',
        'uses' => 'ProfileController@index'
    ]);

    Route::get('profile/activity', [
        'as' => 'profile.activity',
        'uses' => 'ProfileController@activity'
    ]);

    Route::put('profile/details/update', [
        'as' => 'profile.update.details',
        'uses' => 'ProfileController@updateDetails'
    ]);

    Route::post('profile/avatar/update', [
        'as' => 'profile.update.avatar',
        'uses' => 'ProfileController@updateAvatar'
    ]);

    Route::post('profile/avatar/update/external', [
        'as' => 'profile.update.avatar-external',
        'uses' => 'ProfileController@updateAvatarExternal'
    ]);

    Route::put('profile/login-details/update', [
        'as' => 'profile.update.login-details',
        'uses' => 'ProfileController@updateLoginDetails'
    ]);

    Route::post('profile/two-factor/enable', [
        'as' => 'profile.two-factor.enable',
        'uses' => 'ProfileController@enableTwoFactorAuth'
    ]);

    Route::post('profile/two-factor/disable', [
        'as' => 'profile.two-factor.disable',
        'uses' => 'ProfileController@disableTwoFactorAuth'
    ]);

    Route::get('profile/sessions', [
        'as' => 'profile.sessions',
        'uses' => 'ProfileController@sessions'
    ]);

    Route::delete('profile/sessions/{session}/invalidate', [
        'as' => 'profile.sessions.invalidate',
        'uses' => 'ProfileController@invalidateSession'
    ]);

    /**
     * User Management
     */
    Route::get('user', [
        'as' => 'user.list',
        'uses' => 'UsersController@index'
    ]);

    Route::get('user/create', [
        'as' => 'user.create',
        'uses' => 'UsersController@create'
    ]);

    Route::post('user/create', [
        'as' => 'user.store',
        'uses' => 'UsersController@store'
    ]);

    Route::get('user/create/student/options', [
        'as' => 'user.create.student.options',
        'uses' => 'UsersController@getOptions'
    ]);

    Route::put('user/{user}/student/details', [
        'as' => 'user.update.student.details',
        'uses' => 'UsersController@sd'
    ]);

    Route::get('user/{user}/show', [
        'as' => 'user.show',
        'uses' => 'UsersController@view'
    ]);

    Route::get('user/{user}/edit', [
        'as' => 'user.edit',
        'uses' => 'UsersController@edit'
    ]);

    Route::put('user/{user}/update/details', [
        'as' => 'user.update.details',
        'uses' => 'UsersController@updateDetails'
    ]);

    Route::put('user/{user}/update/login-details', [
        'as' => 'user.update.login-details',
        'uses' => 'UsersController@updateLoginDetails'
    ]);

    Route::delete('user/{user}/delete', [
        'as' => 'user.delete',
        'uses' => 'UsersController@delete'
    ]);

    Route::post('user/{user}/update/avatar', [
        'as' => 'user.update.avatar',
        'uses' => 'UsersController@updateAvatar'
    ]);

    Route::post('user/{user}/update/avatar/external', [
        'as' => 'user.update.avatar.external',
        'uses' => 'UsersController@updateAvatarExternal'
    ]);

    Route::get('user/{user}/sessions', [
        'as' => 'user.sessions',
        'uses' => 'UsersController@sessions'
    ]);

    Route::delete('user/{user}/sessions/{session}/invalidate', [
        'as' => 'user.sessions.invalidate',
        'uses' => 'UsersController@invalidateSession'
    ]);

    Route::post('user/{user}/two-factor/enable', [
        'as' => 'user.two-factor.enable',
        'uses' => 'UsersController@enableTwoFactorAuth'
    ]);

    Route::post('user/{user}/two-factor/disable', [
        'as' => 'user.two-factor.disable',
        'uses' => 'UsersController@disableTwoFactorAuth'
    ]);

    /**
     * Roles & Permissions
     */

    Route::get('role', [
        'as' => 'role.index',
        'uses' => 'RolesController@index'
    ]);

    Route::get('role/create', [
        'as' => 'role.create',
        'uses' => 'RolesController@create'
    ]);

    Route::post('role/store', [
        'as' => 'role.store',
        'uses' => 'RolesController@store'
    ]);

    Route::get('role/{role}/edit', [
        'as' => 'role.edit',
        'uses' => 'RolesController@edit'
    ]);

    Route::put('role/{role}/update', [
        'as' => 'role.update',
        'uses' => 'RolesController@update'
    ]);

    Route::delete('role/{role}/delete', [
        'as' => 'role.delete',
        'uses' => 'RolesController@delete'
    ]);


    Route::post('permission/save', [
        'as' => 'permission.save',
        'uses' => 'PermissionsController@saveRolePermissions'
    ]);

    Route::resource('permission', 'PermissionsController');




    /**
     * Clearance
     */

    Route::get('clearance', [ 'as' => 'student.clearance', 'uses' => 'ClearancesController@index' ]);
    Route::get('clearance/send_request', ['as' => 'clearance.create', 'uses' => 'ClearancesController@create']);
    Route::post('clearance/store', ['as' => 'clearance.store', 'uses' => 'ClearancesController@store']);
    Route::get('clearance/{clearance}/edit_request', ['as' => 'clearance.edit', 'uses' => 'ClearancesController@edit']);
    Route::put('clearance/{clearance}/update_request', ['as' => 'clearance.update', 'uses' => 'ClearancesController@update']);
    Route::delete('clearance/{clearance}/delete_request', ['as' => 'clearance.delete', 'uses' => 'ClearancesController@delete']);

    Route::get('clearance/request/tracking', [ 'as' => 'student.clearance.request.track', 'uses' => 'ClearancesController@tracking' ]);


    Route::get('clearance/request', [ 'as' => 'student.clearance.request', 'uses' => 'RequestsController@index' ]);
    Route::get('clearance/view', ['as' => 'request.view', 'uses' => 'RequestsController@view']);
    Route::post('clearance/updating_request', ['as' => 'request.update', 'uses' => 'RequestsController@store']);


    Route::get('clearance/{clearance}/download', [ 'as' => 'clearance.download.document', 'uses' => 'ClearancesController@generatePDFfile' ]);


    /**
     * Result
     */

    Route::get('results', [ 'as' => 'result.index', 'uses' => 'ResultsController@index' ]);
    Route::get('result/create', ['as' => 'result.create', 'uses' => 'ResultsController@create']);
    Route::post('result/store', ['as' => 'result.store', 'uses' => 'ResultsController@store']);
    Route::get('result/{result}/edit', ['as' => 'result.edit', 'uses' => 'ResultsController@edit']);
    Route::put('result/{result}/update', ['as' => 'result.update', 'uses' => 'ResultsController@update']);
    Route::delete('result/{result}/delete', ['as' => 'result.delete', 'uses' => 'ResultsController@delete']);


    /**
     * Department
     */

    Route::get('department', [ 'as' => 'department.index', 'uses' => 'DepartmentsController@index' ]);
    Route::get('department/create', ['as' => 'department.create', 'uses' => 'DepartmentsController@create']);
    Route::post('department/store', ['as' => 'department.store', 'uses' => 'DepartmentsController@store']);
    Route::get('department/{department}/edit', ['as' => 'department.edit', 'uses' => 'DepartmentsController@edit']);
    Route::put('department/{department}/update', ['as' => 'department.update', 'uses' => 'DepartmentsController@update']);
    Route::delete('department/{department}/delete', ['as' => 'department.delete', 'uses' => 'DepartmentsController@delete']);

    /**
     * Option
     */

    Route::get('option', [ 'as' => 'option.index', 'uses' => 'OptionsController@index' ]);
    Route::get('option/create', ['as' => 'option.create', 'uses' => 'OptionsController@create']);
    Route::post('option/store', ['as' => 'option.store', 'uses' => 'OptionsController@store']);
    Route::get('option/{option}/edit', ['as' => 'option.edit', 'uses' => 'OptionsController@edit']);
    Route::put('option/{option}/update', ['as' => 'option.update', 'uses' => 'OptionsController@update']);
    Route::delete('option/{option}/delete', ['as' => 'option.delete', 'uses' => 'OptionsController@delete']);



    /**
     * Finance
     */

    Route::get('finance', [ 'as' => 'finance.index', 'uses' => 'FinancesController@index' ]);
    Route::get('finance/create', ['as' => 'finance.create', 'uses' => 'FinancesController@create']);
    Route::post('finance/store', ['as' => 'finance.store', 'uses' => 'FinancesController@store']);
    Route::get('finance/{finance}/edit', ['as' => 'finance.edit', 'uses' => 'FinancesController@edit']);
    Route::put('finance/{finance}/update', ['as' => 'finance.update', 'uses' => 'FinancesController@update']);
    Route::delete('finance/{finance}/delete', ['as' => 'finance.delete', 'uses' => 'FinancesController@delete']);
    
    /**
     * Registration
     */

    Route::get('registration', [ 'as' => 'registration.index', 'uses' => 'RegistrationsController@index' ]);
    Route::get('registration/create', ['as' => 'registration.create', 'uses' => 'RegistrationsController@create']);
    Route::post('registration/store', ['as' => 'registration.store', 'uses' => 'RegistrationsController@store']);
    Route::get('registration/{registration}/edit', ['as' => 'registration.edit', 'uses' => 'RegistrationsController@edit']);
    Route::put('registration/{registration}/update', ['as' => 'registration.update', 'uses' => 'RegistrationsController@update']);
    Route::delete('registration/{registration}/delete', ['as' => 'registration.delete', 'uses' => 'RegistrationsController@delete']);

    Route::get('registration/student', [ 'as' => 'registration.student', 'uses' => 'RegistrationsController@index' ]);

    /**
     * Hostel
     */

    Route::get('hostel', [ 'as' => 'hostel.index', 'uses' => 'HostelsController@index' ]);
    Route::get('hostel/create', ['as' => 'hostel.create', 'uses' => 'HostelsController@create']);
    Route::post('hostel/store', ['as' => 'hostel.store', 'uses' => 'HostelsController@store']);
    Route::get('hostel/{hostel}/edit', ['as' => 'hostel.edit', 'uses' => 'HostelsController@edit']);
    Route::put('hostel/{hostel}/update', ['as' => 'hostel.update', 'uses' => 'HostelsController@update']);
    Route::delete('hostel/{hostel}/delete', ['as' => 'hostel.delete', 'uses' => 'HostelsController@delete']);

    /**
     * Library
     */

    Route::get('library', [ 'as' => 'library.index', 'uses' => 'LibrariesController@index' ]);
    Route::get('library/book', ['as' => 'library.create', 'uses' => 'LibrariesController@create']);
    Route::get('library/final-book', ['as' => 'library.finalbook', 'uses' => 'LibrariesController@finalbook']);
    Route::post('library/store', ['as' => 'library.store', 'uses' => 'LibrariesController@store']);
    Route::get('library/{library}/edit', ['as' => 'library.edit', 'uses' => 'LibrariesController@edit']);
    Route::put('library/{library}/update', ['as' => 'library.update', 'uses' => 'LibrariesController@update']);
    Route::delete('library/{library}/delete', ['as' => 'library.delete', 'uses' => 'LibrariesController@delete']);

    Route::get('library/borrow-book', [ 'as' => 'library.borrow', 'uses' => 'LibrariesController@index' ]);
    Route::get('library/finalbook', [ 'as' => 'library.finalbook', 'uses' => 'LibrariesController@index' ]);
    Route::get('library/finalbook/submit', [ 'as' => 'library.create.finalbook', 'uses' => 'LibrariesController@index' ]);


    /**
     * Settings
     */

    Route::get('settings', [
        'as' => 'settings.general',
        'uses' => 'SettingsController@general',
        'middleware' => 'permission:settings.general'
    ]);

    Route::post('settings/general', [
        'as' => 'settings.general.update',
        'uses' => 'SettingsController@update',
        'middleware' => 'permission:settings.general'
    ]);

    Route::get('settings/auth', [
        'as' => 'settings.auth',
        'uses' => 'SettingsController@auth',
        'middleware' => 'permission:settings.auth'
    ]);

    Route::post('settings/auth', [
        'as' => 'settings.auth.update',
        'uses' => 'SettingsController@update',
        'middleware' => 'permission:settings.auth'
    ]);

// Only allow managing 2FA if AUTHY_KEY is defined inside .env file
    if (env('AUTHY_KEY')) {
        Route::post('settings/auth/2fa/enable', [
            'as' => 'settings.auth.2fa.enable',
            'uses' => 'SettingsController@enableTwoFactor',
            'middleware' => 'permission:settings.auth'
        ]);

        Route::post('settings/auth/2fa/disable', [
            'as' => 'settings.auth.2fa.disable',
            'uses' => 'SettingsController@disableTwoFactor',
            'middleware' => 'permission:settings.auth'
        ]);
    }

    Route::post('settings/auth/registration/captcha/enable', [
        'as' => 'settings.registration.captcha.enable',
        'uses' => 'SettingsController@enableCaptcha',
        'middleware' => 'permission:settings.auth'
    ]);

    Route::post('settings/auth/registration/captcha/disable', [
        'as' => 'settings.registration.captcha.disable',
        'uses' => 'SettingsController@disableCaptcha',
        'middleware' => 'permission:settings.auth'
    ]);

    Route::get('settings/notifications', [
        'as' => 'settings.notifications',
        'uses' => 'SettingsController@notifications',
        'middleware' => 'permission:settings.notifications'
    ]);

    Route::post('settings/notifications', [
        'as' => 'settings.notifications.update',
        'uses' => 'SettingsController@update',
        'middleware' => 'permission:settings.notifications'
    ]);

    /**
     * Activity Log
     */

    Route::get('activity', [
        'as' => 'activity.index',
        'uses' => 'ActivityController@index'
    ]);

    Route::get('activity/user/{user}/log', [
        'as' => 'activity.user',
        'uses' => 'ActivityController@userActivity'
    ]);

});


/**
 * Installation
 */

$router->get('install', [
    'as' => 'install.start',
    'uses' => 'InstallController@index'
]);

$router->get('install/requirements', [
    'as' => 'install.requirements',
    'uses' => 'InstallController@requirements'
]);

$router->get('install/permissions', [
    'as' => 'install.permissions',
    'uses' => 'InstallController@permissions'
]);

$router->get('install/database', [
    'as' => 'install.database',
    'uses' => 'InstallController@databaseInfo'
]);

$router->get('install/start-installation', [
    'as' => 'install.installation',
    'uses' => 'InstallController@installation'
]);

$router->post('install/start-installation', [
    'as' => 'install.installation',
    'uses' => 'InstallController@installation'
]);

$router->post('install/install-app', [
    'as' => 'install.install',
    'uses' => 'InstallController@install'
]);

$router->get('install/complete', [
    'as' => 'install.complete',
    'uses' => 'InstallController@complete'
]);

$router->get('install/error', [
    'as' => 'install.error',
    'uses' => 'InstallController@error'
]);


