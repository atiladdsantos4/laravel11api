<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;


//reset password//

Route::get('reset-password', [App\Http\Controllers\UsuarioController::class, 'resetPassword'])->name('password.reset');
Route::post('reset-password', [App\Http\Controllers\UsuarioController::class, 'submitResetPasswordForm'])->name('password.change');
Route::post('api/login', [App\Http\Controllers\LoginController::class, 'loginApi'])->name('login.api');  

//forgot password//
Route::get('forgot-password', function () {
    return view('sb.forgot-password');
})->name('password.request');



/*
Route::post('forgot-password', function (Request $request) {

    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(

        $request->only('email')

    );

    return $status === Password::ResetLinkSent

        ? back()->with(['status' => __($status)])

        : back()->withErrors(['email' => __($status)]);

})->middleware('guest')->name('password.email');
*/

Route::post('user-notify', [App\Http\Controllers\UsuarioController::class, 'email'])->name('password.notify');
//Route::get('user-notify', [App\Http\Controllers\UsuarioController::class, 'email'])->name('password.notify');

Route::get('/', function () {
    //Route::post('/', [App\Http\Controllers\LoginController::class, 'login'])->name('login.login');  
    //$teste = DB::select('select * from esc_escopo'); 
    //return view('welcome');
    return view('sb.page_login');
})->name('index.login');

Route::prefix('dashboard')->group(function () {
    Route::post('/', [App\Http\Controllers\LoginController::class, 'login'])->name('login.login'); 
    //Route::post('/login', [App\Http\Controllers\LoginController::class, 'loginApi'])->name('login.api');  
//Route::get('login', function () {
    // $teste = DB::select('select * from esc_escopo'); 
    // //return view('welcome');
    // //Route::('/', [App\Http\Controllers\LoginController::class, 'login'])->name('login.login');  
    // Route::get('/', [App\Http\Controllers\EscopoController::class, 'teste']);
});



Route::prefix('menu')->group(function () {
    Route::get('/', [App\Http\Controllers\MenuController::class, 'api'])->name('manu.api');  
    /*
    $routes->get('', 'LoginController::login');
    $routes->get('error', 'LoginController::login');
    $routes->post('','LoginController::post_login');
    $routes->post('api/get_token','LoginController::get_token');
    $routes->post('auth','LoginController::auth'); 
    $routes->post('save','LoginController::save'); 
    $routes->get('splash','LoginController::splash'); 
    //C:\Apache24\htdocs\projetos\crud_teste\app\Views\sb\splash\splash.php
    */
});

Route::prefix('/comp')->group(function () {
    //Route::get('/novo/{contrato?}', [App\Http\Controllers\PagamentoController::class, 'novo'])->name('pagamento.novo');  
    Route::get('/tables', function () {  return view('sb.site_componentes.tables');  })->name('main.table');
    Route::get('/billing', function () {  return view('sb.site_componentes.billing');  })->name('main.billing');
    Route::get('/notifications', function () {  return view('sb.site_componentes.notifications');  })->name('main.notifications');
    Route::get('/profile', function () {  return view('sb.site_componentes.profile');  })->name('main.profile');
    Route::get('/sign_in', function () {  return view('sb.site_componentes.sign_in');  })->name('main.sign_in');
    Route::get('/sign_up', function () {  return view('sb.site_componentes.sign_up');  })->name('main.sign_up');
    Route::get('/cards', function () {  return view('sb.site_componentes.cards');  })->name('main.cards');
    Route::get('/buttons', function () {  return view('sb.site_componentes.buttons');  })->name('main.buttons');
    Route::get('/color', function () {  return view('sb.site_componentes.color');  })->name('main.color');
    Route::get('/borders', function () {  return view('sb.site_componentes.border');  })->name('main.border');
    Route::get('/animation', function () {  return view('sb.site_componentes.animation');  })->name('main.animation');
    Route::get('/other', function () {  return view('sb.site_componentes.other');  })->name('main.other');
    Route::get('/page_login', function () {  return view('sb.site_componentes.page_login');  })->name('main.page_login');
    Route::get('/page_register', function () {  return view('sb.site_componentes.page_register');  })->name('main.page_register');
    Route::get('/forgot_password', function () {  return view('sb.site_componentes.forgot_password');  })->name('main.forgot_password');
    Route::get('/page_404', function () {  return view('sb.site_componentes.404');  })->name('main.page_404');
    Route::get('/blank', function () {  return view('sb.site_componentes.blank');  })->name('main.blank');
    Route::get('/chart', function () {  return view('sb.site_componentes.chart');  })->name('main.chart');
    Route::get('/tables', function () {  return view('sb.site_componentes.tables');  })->name('main.table');
    //forgot_password
    //Route::get('/', function () { return view('dashboard'); })->name('main.page');
    Route::get('/', function () { return view('index'); })->name('main.index');
    
});

Route::prefix('react')->group(function () {
    Route::get('/intro', function () {  return view('react.intro');  })->name('react.introducao');  
    Route::get('/example/{param}', [App\Http\Controllers\ReactController::class, 'index'])->name('react.index');  
});

/* Front-End
   Route::get('/react-app/{any}', function () {
      return file_get_contents(public_path('react-app/index.html'));
   })->where('any', '.*');
*/

Route::prefix('recurso')->group(function () {
    Route::get('/validation', function () {  return view('recurso.validate');  })->name('recurso.validate');  
});

Route::prefix('escopo')->group(function () {
    
    Route::get('/index', [App\Http\Controllers\EscopoController::class, 'index'])->name('escopo.index');  
    Route::get('/novo', [App\Http\Controllers\EscopoController::class, 'novo'])->name('escopo.novo');  
    Route::get('/editar/{editar}', [App\Http\Controllers\EscopoController::class, 'editar'])->name('escopo.editar');  
    Route::post('/save', [App\Http\Controllers\EscopoController::class, 'save'])->name('escopo.save');  
    Route::post('/edit', [App\Http\Controllers\EscopoController::class, 'edit'])->name('escopo.edit');  
    Route::post('/delete', [App\Http\Controllers\EscopoController::class, 'delete'])->name('escopo.delete');  
    Route::post('/api/save', [App\Http\Controllers\EscopoController::class, 'SaveApi'])->name('escopo.saveapi');  
    //Route::get('/novo/{contrato?}', [App\Http\Controllers\PagamentoController::class, 'novo'])->name('pagamento.novo');  
    // Route::get('/tables', function () {  return view('tables');  })->name('main.table');
    // Route::get('/billing', function () {  return view('billing');  })->name('main.billing');
    // Route::get('/notifications', function () {  return view('notifications');  })->name('main.notifications');
    // Route::get('/profile', function () {  return view('profile');  })->name('main.profile');
    // Route::get('/sign_in', function () {  return view('sign_in');  })->name('main.sign_in');
    // Route::get('/sign_up', function () {  return view('sign_up');  })->name('main.sign_up');
    // Route::get('/', function () { return view('dashboard'); })->name('main.page');
});

Route::prefix('menu')->group(function () {
    Route::get('/api/listar', [App\Http\Controllers\MenuController::class, 'api'])->name('manu.api');  
    Route::get('/index', [App\Http\Controllers\MenuController::class, 'index'])->name('menu.index');  
    Route::get('/novo', [App\Http\Controllers\MenuController::class, 'novo'])->name('menu.novo');  
    Route::get('/editar/{editar}', [App\Http\Controllers\MenuController::class, 'editar'])->name('menu.editar');  
    Route::post('/save', [App\Http\Controllers\MenuController::class, 'save'])->name('menu.save');  
    Route::post('/edit/{menu}', [App\Http\Controllers\MenuController::class, 'edit'])->name('menu.edit');  
    Route::post('/delete', [App\Http\Controllers\MenuController::class, 'delete'])->name('menu.delete');  
    //Route::get('/novo/{contrato?}', [App\Http\Controllers\PagamentoController::class, 'novo'])->name('pagamento.novo');  
    // Route::get('/tables', function () {  return view('tables');  })->name('main.table');
    // Route::get('/billing', function () {  return view('billing');  })->name('main.billing');
    // Route::get('/notifications', function () {  return view('notifications');  })->name('main.notifications');
    // Route::get('/profile', function () {  return view('profile');  })->name('main.profile');
    // Route::get('/sign_in', function () {  return view('sign_in');  })->name('main.sign_in');
    // Route::get('/sign_up', function () {  return view('sign_up');  })->name('main.sign_up');
    // Route::get('/', function () { return view('dashboard'); })->name('main.page');
});

Route::prefix('usuario')->group(function () {
    Route::get('/api/listar', [App\Http\Controllers\UsuarioController::class, 'api'])->name('usuario.api');  
    //Route::get('/index/{editar}', [App\Http\Controllers\UsuarioController::class, 'index'])->name('usuario.index');  
    Route::get('/index', [App\Http\Controllers\UsuarioController::class, 'index'])->name('usuario.index');  
    Route::get('/novo', [App\Http\Controllers\UsuarioController::class, 'novo'])->name('usuario.novo');  
    Route::get('/tokens/{show?}', [App\Http\Controllers\PersonalAccessTokensController::class, 'index'])->name('token.listar');  
    Route::get('/editar/{editar}', [App\Http\Controllers\UsuarioController::class, 'editar'])->name('usuario.editar');  
    Route::post('/save', [App\Http\Controllers\UsuarioController::class, 'save'])->name('usuario.save');  
    // Route::post('/edit/{menu}', [App\Http\Controllers\MenuController::class, 'edit'])->name('menu.edit');  
    Route::post('/delete', [App\Http\Controllers\UsuarioController::class, 'delete'])->name('usuario.delete');  
    Route::post('/gettoken', [App\Http\Controllers\UsuarioController::class, 'generatePwd'])->name('usuario.pwd'); 
    //Route::post('/resetsenha', [App\Http\Controllers\UsuarioController::class, 'resetSenha'])->name('usuario.reset'); 
    Route::post('/resetsenha', [App\Http\Controllers\UsuarioController::class, 'resetPassword'])->name('usuario.reset_password'); 
});


Route::prefix('ajax')->group(function () {
    Route::get('/listaAjax/{param?}/{param1?}/{param2?}', [App\Http\Controllers\AjaxController::class, 'index'])->name('ajax.lista');  
});


// Route::prefix('ajax')->group(function () {

// });

