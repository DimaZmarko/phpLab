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

Route::group(['middleware' => 'web'], function () {

    Route::match(['get', 'post'], '/', 'IndexController@execute')->name('home');

});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {

    //admin
    Route::get('/', function () {

        if(view()->exists('admin.index')) {
            $data = ['title' => 'Dashboard'];

            return view('admin.index', $data);
        }

    });

    //admin/books
    Route::group(['prefix' => 'books'], function () {

        Route::get('/', 'BooksController@execute')->name('books');

        //admin/books/add
        Route::match(['get', 'post'], '/add', 'BooksAddController@execute')->name('BooksAdd');
        //admin/books/edit
        Route::match(['get', 'post'], '/edit/{book}', 'BooksEditController@execute')->name('BooksEdit');
        //admin/books/delete
        Route::post('/delete/{book}', 'BooksDeleteController@execute')->name('BooksDelete');
    });

    //admin/tags
    Route::group(['prefix' => 'tags'], function () {

        Route::get('/', 'TagsController@execute')->name('tags');

        //admin/tags/add
        Route::match(['get', 'post'], '/add', 'TagsAddController@execute')->name('TagsAdd');
        //admin/tags/edit
        Route::match(['get', 'post'], '/edit/{tag}', 'TagsEditController@execute')->name('TagsEdit');
        //admin/tags/delete
        Route::post('/delete/{tag}', 'TagsDeleteController@execute')->name('TagsDelete');
    });

});

Auth::routes();
