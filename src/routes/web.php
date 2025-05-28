<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

//商品一覧画面
Route::get('/product',[ProductController::class,'index']);
Route::get('search',[ProductController::class,'search']);
Route::get('sort',[ProductController::class,'sort']);

// 商品登録画面
Route::get('/product/register',[ProductController::class,'register']);
Route::post('/product/add',[ProductController::class,'store']);

//商品詳細画面
Route::get('/product/{id}',[ProductController::class,'edit'])->name('product.edit');
Route::post('/product/{id}/update',[ProductController::class,'update']);
Route::delete('product/{id}/delete',[ProductController::class,'delete']);
