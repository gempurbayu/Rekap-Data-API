<?php

use Illuminate\Support\Facades\Artisan;

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Route::apiResource('pengeluaran', PengeluaranController::class);
$router->group(['middleware' => 'auth:api','prefix' => 'api'], function () use ($router) {
    $router->get('pengeluaran', 'PengeluaranController@index');
    $router->post('pengeluaran', 'PengeluaranController@store');
    $router->get('pengeluaran/tanggal/{id}', 'PengeluaranController@getPengeluaranByDate');
    $router->get('pengeluaran/{id}', 'PengeluaranController@show');
    $router->put('pengeluaran/{id}', 'PengeluaranController@update');
    $router->delete('pengeluaran/{id}', 'PengeluaranController@destroy');
});

$router->post('api/register','RegisterController');
$router->post('api/login', 'AuthController@login' );
$router->post('api/logout','AuthController@logout');
$router->post('api/me', 'AuthController@me' );

//If you are unable to run above artisan command or project in share hosting then write the below code to your web.php file
Route::get('/clear', function() {

    Artisan::call('cache:clear');

    return "Cleared!";

});

Route::get('/composer-update', function () {
    chdir('../');
    $output=exec('composer update');
  echo "<pre>$output</pre>";
 });
