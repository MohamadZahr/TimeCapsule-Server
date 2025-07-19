<?php

use App\Http\Controllers\Common\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "v0.1"], function () {
    Route::group(["middleware" => "auth:api"], function () {

        //AUTHENTICATED APIs

        // Route::get("/tasks", [TaskController::class, "getAllTasks"]);
        // Route::post("/add_update_task/{id?}", [TaskController::class, "addOrUpdateTask"]);
    });

    //UNAUTHENTICATED APIs
    Route::group(["prefix" => "guest"], function () {
        Route::post("/login", [AuthController::class, "login"]);
        Route::post("/register", [AuthController::class, "register"]);
    });
});
