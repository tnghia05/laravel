<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin');
});
Route::get('/cookra', 'App\Http\Controllers\AdminController@cook');
Route::get('/admin', 'App\Http\Controllers\AdminController@index'); 
Route::get('/dashboard', 'App\Http\Controllers\AdminController@show_dashboard');
Route::post('/admin-dashboard','App\Http\Controllers\AdminController@dashboard'); 
Route::get('/logout','App\Http\Controllers\AdminController@logout'); 
Route::get('/add-category-product','App\Http\Controllers\CategoryProductController@add_category_product'); 
Route::get('/all-category-product','App\Http\Controllers\CategoryProductController@all_category_product'); 
Route::post('/save-category-product','CategoryProductController@save_category_product'); 
Route::get('/tintuc','App\Http\Controllers\NewController@index');

Route::get('/gioithieu','App\Http\Controllers\HomeController@index');
Route::get('/home','App\Http\Controllers\HomeController@index');

Route::get('/add-category-product', [
    'uses' => 'App\Http\Controllers\CategoryProductController@add_category_product'
]);

Route::post('/save-category-product', [
    'uses' => 'App\Http\Controllers\CategoryProductController@save_category_product'
]);

Route::get('/all-category-product', [
    'uses' => 'App\Http\Controllers\CategoryProductController@all_category_product'
]);

Route::get('/unactive-category-product/{category_product_id}', [
    'uses' => 'App\Http\Controllers\CategoryProductController@unactive_category_product'
]);

Route::get('/active-category-product/{category_product_id}', [
    'uses' => 'App\Http\Controllers\CategoryProductController@active_category_product'
]);

Route::get('/delete-category-product/{category_product_id}', [
    'uses' => 'App\Http\Controllers\CategoryProductController@delete_category_product'
]);
Route::get('/add-brand-product','App\Http\Controllers\BrandProduct@add_brand_product'); 
Route::get('/all-brand-product','App\Http\Controllers\BrandProduct@all_brand_product'); 
Route::post('/save-brand-product','App\Http\Controllers\BrandProduct@save_brand_product'); 
Route::get('/unactive-brand-product/{brand_product_id}','App\Http\Controllers\BrandProduct@unactive_brand_product'); 
Route::get('/active-brand-product/{brand_product_id}','App\Http\Controllers\BrandProduct@active_brand_product'); 
Route::get('add-product','App\Http\Controllers\ProductController@add_product');
Route::get('all-product','App\Http\Controllers\ProductController@all_product');
Route::post('save-product','App\Http\Controllers\ProductController@save_product');
Route::get('unactive-product/{product_id}','App\Http\Controllers\ProductController@unactive_product');
Route::get('active-product/{product_id}','App\Http\Controllers\ProductController@active_product');
Route::get('/danh-muc-san-pham/{slug_category_product}','App\Http\Controllers\CategoryProductController@show_category_home');
Route::get('/thuong-hieu-san-pham/{brand_slug}','App\Http\Controllers\BrandProduct@show_brand_home'); 