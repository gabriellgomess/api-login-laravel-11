<?php

namespace App\Http\Controllers\Cidades;

use Illuminate\Http\Request;
use App\Models\Cidade;
use App\Http\Controllers\Controller;
class CidadesController extends Controller
{
    // Função para listar todas as cidades
    public function cidades()
    {
        $cidades = Cidade::all();
        return response()->json($cidades);
    }


    // Função para cadastrar uma nova cidade
    public function cadastrarCidade(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $cidade = Cidade::create([
            'nome' => $request->nome,
        ]);

        return response()->json($cidade, 201);
    }
}
