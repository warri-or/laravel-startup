<?php
use Illuminate\Support\Facades\Route;

Route::get('product-manager-home', 'Web\Admin\Product\DashboardController@index')->name('productManagerHome');

Route::get('category/{id?}','Web\Admin\Product\CategoryController@index')->name('categories');
Route::post('category-edit','Web\Admin\Product\CategoryController@edit')->name('editCategory');
Route::post('category-show','Web\Admin\Product\CategoryController@show')->name('showCategory');
Route::post('category-save','Web\Admin\Product\CategoryController@store')->name('saveCategory');
Route::post('category-delete','Web\Admin\Product\CategoryController@delete')->name('deleteCategory');
Route::post('category-order-update','Web\Admin\Product\CategoryController@categoryOrderUpdate')->name('categoryOrderUpdate');
Route::post('category-order-save','Web\Admin\Product\CategoryController@categoryOrderSave')->name('categoryOrderSave');
Route::post('category-slug-check','Web\Admin\Product\CategoryController@categorySlugCheck')->name('categorySlugCheck');

Route::get('brand','Web\Admin\Product\BrandController@index')->name('brands');
Route::post('brand-edit','Web\Admin\Product\BrandController@edit')->name('editBrand');
Route::post('brand-save','Web\Admin\Product\BrandController@store')->name('saveBrand');
Route::post('brand-slug-check','Web\Admin\Product\BrandController@brandSlugCheck')->name('brandSlugCheck');
Route::post('brand-delete','Web\Admin\Product\BrandController@delete')->name('deleteBrand');


