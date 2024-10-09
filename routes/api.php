<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

use App\Http\Controllers\Categorias\CategoriasController;
use App\Http\Controllers\Cidades\CidadesController;
use App\Http\Controllers\Bairros\BairrosController;
use App\Http\Controllers\Links\LinksController;


// Register
Route::post("register", [ApiController::class, "register"]);

// Login
Route::post("login", [ApiController::class, "login"]);

// Rotas públicas - não precisam de autenticação
// Listar todas as categorias
Route::get(uri: "categorias", action: [CategoriasController::class, "categorias"]);

// Listar todas as cidades
Route::get(uri: "cidades", action: [CidadesController::class, "cidades"]);

// Listar todos os bairros
Route::get(uri: "bairros", action: [BairrosController::class, "bairros"]);

Route::get(uri: "links", action: [LinksController::class, "links"]);

//Nesta rotas de baixo precisa estar autenticado para usa-lás
Route::group([
    "middleware" => ["auth:sanctum"]
], function(){
    // Profile
    Route::get("profile", [ApiController::class, "profile"]);

    // Logout
    Route::post("logout", [ApiController::class, "logout"]);

    // Links
    // Cadastrar um novo link
    Route::post(uri: "links", action: [LinksController::class, "cadastrarLink"]);

    // Atualiza um link
    Route::put(uri: "links", action: [LinksController::class, "atualizarLink"]);
    
    // Cadastrar uma nova categoria
    Route::post(uri: "categorias", action: [CategoriasController::class, "cadastrarCategoria"]);

    // Cadastrar uma nova cidade
    Route::post(uri: "cidades", action: [CidadesController::class, "cadastrarCidade"]);

    // Cadastrar um novo bairro
    Route::post(uri: "bairros", action: [BairrosController::class, "cadastrarBairro"]);
});




