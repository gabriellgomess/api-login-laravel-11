<?php

namespace App\Http\Controllers\Categorias;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Http\Controllers\Controller;


class CategoriasController extends Controller
{
    // Função para listar todas as categorias

    public function categorias()
    {
        $categorias = Categoria::all();
        return response()->json($categorias);
    }
    // Função para cadastrar uma nova categoria
    public function cadastrarCategoria(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $categoria = Categoria::create([
            'nome' => $request->nome,
        ]);

        return response()->json($categoria, 201); // Retorna a categoria criada com status 201 (Created)
    }
}
