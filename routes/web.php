<?php

use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\CouponController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ShippingController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::controller(IndexController::class)->group(function () {
    Route::get("/", "index")->name("index");
    Route::get("/login", "login")->name("login");
    Route::post("/login", "doLogin");
});

Route::middleware(['auth'])->prefix("dashboard")->group(function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get("/", "index")->name("dashboard");
        Route::post("/logout", "logout")->name("logout");        
    });

    Route::resource("products", ProductController::class);
    Route::get("/products/{id}/history", [ProductController::class, "history"])->name("products.history");        
    Route::post("/products/massUpdate", [ProductController::class, "massUpdate"])->name("products.massUpdate");        

    Route::resource("orders", OrderController::class, [
        'except' => ['show']
    ]);

    Route::resource("coupons", CouponController::class, [
        'except' => ['show']
    ]);

    Route::resource("shipping", ShippingController::class, [
        'only' => ['index', 'store', 'destroy']
    ]);

    Route::resource("clients", ClientController::class, [
        'only' => ['index']
    ]);
});
