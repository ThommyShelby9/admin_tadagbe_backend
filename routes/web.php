<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Models\User;
Route::get('/', function () {           return view('auth.login'); });

Route::group(['middleware' => ['get.menu']], function () {
    Route::resource('notes', 'NotesController');
//to remove
    Auth::routes();

    Route::resource('resource/{table}/resource', 'ResourceController')->names([
        'index'     => 'resource.index',
        'create'    => 'resource.create',
        'store'     => 'resource.store',
        'show'      => 'resource.show',
        'edit'      => 'resource.edit',
        'update'    => 'resource.update',
        'destroy'   => 'resource.destroy'
    ]);
    Route::get('/serverSide', [
    'as'   => 'serverSide',
    'uses' => function () {
        $users = User::all();
        return Datatables::of($users)->make();
    }
]);

    Route::group(['middleware' => ['auth','admin']], function () {
        Route::get('settings',        'SettingsController@index' );
        Route::post('settings',        'SettingsController@update' );
        Route::get('settings/{code}',        'SettingsController@getSettingByCode' );
        Route::resource('students',        'StudentController' );
        Route::get('student/exports', 'StudentController@export');
        Route::post('student/imports', 'StudentController@import');
        Route::post('student/filter', 'StudentController@filter');

        Route::get('dashboard',        'DashboardController@index' );
        Route::resource('users',        'UsersController' );
        Route::resource('admissions',        'AdmissionController' )->except(["destroy"]);
        Route::Post('admissions/{id}',        'AdmissionController@destroy' )->name("admissions.destroy");
        Route::get('/payments/completed/{id}',         'AdmissionController@onCompletePaymentCallback')->name('admissions.onCompletedPayment');
        Route::get('admission/exports', 'AdmissionController@export');

        Route::get('admission/pay/{id}',        'AdmissionController@pay' )->name("admissions.pay");
        Route::post('admission/validate/{id}',        'AdmissionController@validateAdmission' )->name("admissions.validate");


        Route::resource('payments',        'PaymentController' )->except(["destroy"]);
        Route::Post('payments/{id}',        'PaymentController@destroy' )->name("payments.destroy");


        Route::resource('programmes',        'ProgrammeController' )->except(["destroy"]);
        Route::Post('programmes/{id}',        'ProgrammeController@destroy' )->name("programmes.destroy");

        Route::resource('articles',        'ArticleController' )->except(["destroy"]);
        Route::Post('articles/{id}',        'ArticleController@destroy' )->name("articles.destroy");
        Route::get('user/datatables', 'UsersController@datatables')->name('users.datatables');
        Route::resource('roles',        'RolesController');
        Route::resource('mail',        'MailController');
        Route::get('mails/duplicate/{id}',        'MailController@duplicate');
        Route::get('prepareSend/{id}',        'MailController@prepareSend')->name('prepareSend');
        Route::post('mailSend/{id}',        'MailController@send')->name('mailSend');
        Route::get('/roles/move/move-up',      'RolesController@moveUp')->name('roles.up');
        Route::get('/roles/move/move-down',    'RolesController@moveDown')->name('roles.down');
        Route::prefix('menu/element')->group(function () {
            Route::get('/',             'MenuElementController@index')->name('menu.index');
            Route::get('/move-up',      'MenuElementController@moveUp')->name('menu.up');
            Route::get('/move-down',    'MenuElementController@moveDown')->name('menu.down');
            Route::get('/create',       'MenuElementController@create')->name('menu.create');
            Route::post('/store',       'MenuElementController@store')->name('menu.store');
            Route::get('/get-parents',  'MenuElementController@getParents');
            Route::get('/edit',         'MenuElementController@edit')->name('menu.edit');
            Route::post('/update',      'MenuElementController@update')->name('menu.update');
            Route::get('/show',         'MenuElementController@show')->name('menu.show');
            Route::get('/delete',       'MenuElementController@delete')->name('menu.delete');
        });
        Route::prefix('menu/menu')->group(function () {
            Route::get('/',         'MenuController@index')->name('menu.menu.index');
            Route::get('/create',   'MenuController@create')->name('menu.menu.create');
            Route::post('/store',   'MenuController@store')->name('menu.menu.store');
            Route::get('/edit',     'MenuController@edit')->name('menu.menu.edit');
            Route::post('/update',  'MenuController@update')->name('menu.menu.update');
            Route::get('/delete',   'MenuController@delete')->name('menu.menu.delete');
        });
        Route::prefix('media')->group(function () {
            Route::get('/',                 'MediaController@index')->name('media.folder.index');
            Route::get('/folder/store',     'MediaController@folderAdd')->name('media.folder.add');
            Route::post('/folder/update',   'MediaController@folderUpdate')->name('media.folder.update');
            Route::get('/folder',           'MediaController@folder')->name('media.folder');
            Route::post('/folder/move',     'MediaController@folderMove')->name('media.folder.move');
            Route::post('/folder/delete',   'MediaController@folderDelete')->name('media.folder.delete');;

            Route::post('/file/store',      'MediaController@fileAdd')->name('media.file.add');
            Route::get('/file',             'MediaController@file');
            Route::post('/file/delete',     'MediaController@fileDelete')->name('media.file.delete');
            Route::post('/file/update',     'MediaController@fileUpdate')->name('media.file.update');
            Route::post('/file/move',       'MediaController@fileMove')->name('media.file.move');
            Route::post('/file/cropp',      'MediaController@cropp');
            Route::get('/file/copy',        'MediaController@fileCopy')->name('media.file.copy');
        });
    });
});
