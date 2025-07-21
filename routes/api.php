<?php

use App\Http\Controllers\Common\AuthController;
use App\Http\Controllers\CapsuleController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "v0.1"], function () {
    Route::group(["middleware" => "auth:api"], function () {

        //AUTHENTICATED APIs
        Route::post("/create_capsule", [CapsuleController::class, "create"]);
        Route::get("/tags", [TagController::class, "getAll"]);
        Route::get("/private/revealed", [CapsuleController::class, "getPrivateRevealed"]);
        Route::get("/private/upcoming", [CapsuleController::class, "getPrivateUpcoming"]);
        Route::get("/public/revealed", [CapsuleController::class, "getPublicRevealed"]);
        Route::get("/public/upcoming", [CapsuleController::class, "getPublicUpcoming"]);

    });

    //UNAUTHENTICATED APIs
    Route::group(["prefix" => "guest"], function () {
        Route::post("/login", [AuthController::class, "login"]);
        Route::post("/register", [AuthController::class, "register"]);

    });
});
