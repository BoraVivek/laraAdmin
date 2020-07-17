<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin','Admin\AdminController@index')->name('admin');


Route::get('/admin/users/all', 'Admin\UsersController@allUsers')->name('admin.users.all');
Route::get('/admin/roles/all', 'Admin\RolesController@allRoles')->name('admin.roles.all');
Route::get('/admin/blog/posts/all', 'Admin\PostsController@allPosts')->name('admin.posts.all');
Route::get('/admin/categories/all','Admin\CategoriesController@allCategories')->name('admin.categories.all');

Route::post('/admin/users/mass', 'Admin\UsersController@mass')->name('admin.users.mass');
Route::post('/admin/roles/mass', 'Admin\RolesController@mass')->name('admin.roles.mass');
Route::post('/admin/categories/mass', 'Admin\CategoriesController@mass')->name('admin.categories.mass');




Route::name('admin.')->group(function () {

    Route::resource('admin/users', 'Admin\UsersController');

    Route::resource('admin/roles', 'Admin\RolesController');

    Route::resource('admin/blog/posts', 'Admin\PostsController');

    Route::resource('admin/categories','Admin\CategoriesController');
});
