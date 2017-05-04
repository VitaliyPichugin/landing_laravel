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

Route::group(['middleware'=>'web'], function (){

    Route::match(['get', 'post'], '/', ['uses'=>'IndexController@execute', 'as'=>'home']);
    Route::get('/page/{alias}', ['uses'=>'PageController@execute', 'as'=>'page']);

    //система аутентификации пользователей
    Route::auth();

});


//закрытые пути для админа
Route::group(['prefix'=>'admin', 'middleware'=>'auth'], function(){

    Route::get('/',  function(){

        if(view()->exists('admin.index')){
            $data = ['title' => 'Panel of Boss'];
            return view('admin.index', $data);
        }

    });

    //admin/pages
    Route::group(['prefix'=>'pages'], function(){

        //admin/pages
        Route::get('/', ['uses'=>'PagesController@execute', 'as'=>'pages']);

        //admin/pages/add
        Route::match(['get', 'post'], '/add', ['uses'=>'PagesAddController@execute', 'as'=>'PagesAdd']);
        //admin/edit/2
        Route::match(['get', 'post', 'delete'], '/edit/{page}', ['uses'=>'PagesEditController@execute', 'as'=>'pagesEdit']);

    });

    //admin/portfolios
    Route::group(['prefix'=>'portfolios'], function(){

        //admin/portfolios
        Route::get('/', ['uses'=>'PortfolioController@execute', 'as'=>'portfolio']);

        //admin/Portfolio/add
        Route::match(['get', 'post'], '/add', ['uses'=>'PortfolioAddController@execute', 'as'=>'PortfolioAdd']);
        //admin/edit/2
        Route::match(['get', 'post', 'delete'], '/edit/{portfolio}', ['uses'=>'PortfolioEditController@execute', 'as'=>'PortfolioEdit']);

    });

    //admin/Service
    Route::group(['prefix'=>'services'], function(){

        //admin/portfolios
        Route::get('/', ['uses'=>'ServiceController@execute', 'as'=>'services']);

        //admin/Service/add
        Route::match(['get', 'post'], '/add', ['uses'=>'ServiceAddController@execute', 'as'=>'ServiceAdd']);
        //admin/edit/2
        Route::match(['get', 'post', 'delete'], '/edit/{service}', ['uses'=>'ServiceEditController@execute', 'as'=>'ServiceEdit']);

    });
});
Auth::routes();

Route::get('/home', 'HomeController@index');
