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

Route::get('/', function () {
  return view('homepage');
});

Route::get('/homepage', function () {
  return SSH::into('sitsonar')->run(array(
    "ansible -m ping localhost",
    "ansible -m shell localhost -a 'mkdir testnaja'",
  ), function($line){
    echo $line;
  });
});


Route::post('/newscan','ProjectController@insert');

Route::post('/enterkey','ProjectController@select');

Route::post('/scanproject','ProjectController@scan');


Route::get('/findproject', function () {
  return view('findproject');
});


Route::get('/testcopy', function () {
  return view('testcopy');
});
