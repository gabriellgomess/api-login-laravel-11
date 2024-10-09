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

    // Função para atualizar uma categoria existente
    public function atualizarCategoria(Request $request, $id)
    {
        // Validação dos dados recebidos
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        // Encontrar a categoria pelo ID
        $categoria = Categoria::find($id);

        // Verificar se a categoria existe
        if (!$categoria) {
            return response()->json(['message' => 'Categoria não encontrada'], 404); // Retorna erro 404 se a categoria não existir
        }

        // Atualizar os dados da categoria
        $categoria->nome = $request->nome;
        $categoria->save();

        return response()->json($categoria); // Retorna a categoria atualizada
    }
}
