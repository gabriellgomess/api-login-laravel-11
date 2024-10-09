<?php

namespace App\Http\Controllers\Bairros;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bairro;

class BairrosController extends Controller
{
    public function bairros()
    {
        $bairros = Bairro::with('cidade')->get(); // Carregar a cidade relacionada com o bairro
        return response()->json($bairros);
    }
    public function cadastrarBairro(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cidade_id' => 'required|exists:cidades,id', // Verifica se a cidade existe
        ]);

        $bairro = Bairro::create([
            'nome' => $request->nome,
            'cidade_id' => $request->cidade_id,
        ]);

        return response()->json($bairro, 201);
    }
}
