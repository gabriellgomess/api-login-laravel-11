<?php
namespace App\Http\Controllers\Links;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Link;
use Illuminate\Support\Facades\Validator;

class LinksController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/links/{id}",
     *     summary="Exibir Link",
     *     description="Retorna um link específico.",
     *     tags={"Links"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Link encontrado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="url", type="string", example="https://example.com"),
     *                 @OA\Property(property="descricao", type="string", example="Descrição do link"),
     *                 @OA\Property(property="categoria_id", type="integer", example=1),
     *                 @OA\Property(property="cidade_id", type="integer", example=1),
     *                 @OA\Property(property="bairro_id", type="integer", example=1),
     *                 @OA\Property(property="created_at", type="string", example="2024-10-03T15:51:05.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", example="2024-10-03T15:51:05.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Link não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Link not found")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $link = Link::find($id);

        if (!$link) {
            return response()->json([
                'status' => 'error',
                'message' => 'Link not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $link
        ], 200);
    }
    /**
     * @OA\Delete(
     *     path="/api/links/{id}",
     *     summary="Excluir Link",
     *     description="Remove um link específico.",
     *     tags={"Links"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Link excluído com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Link não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Link not found")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $link = Link::find($id);

        if (!$link) {
            return response()->json([
                'status' => 'error',
                'message' => 'Link not found'
            ], 404);
        }

        $link->delete();

        return response()->json([], 204);
    }
    /**
     * @OA\Get(
     *     path="/api/links",
     *     summary="Listar Links",
     *     description="Retorna uma lista de links com opções de filtro.",
     *     tags={"Links"},
     *     @OA\Parameter(
     *         name="categoria_id",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="cidade_id",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="bairro_id",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de links recuperada com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="url", type="string", example="https://example.com"),
     *                     @OA\Property(property="descricao", type="string", example="Descrição do link"),
     *                     @OA\Property(property="categoria_id", type="integer", example=1),
     *                     @OA\Property(property="cidade_id", type="integer", example=1),
     *                     @OA\Property(property="bairro_id", type="integer", example=1),
     *                     @OA\Property(property="created_at", type="string", example="2024-10-03T15:51:05.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", example="2024-10-03T15:51:05.000000Z")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function links(Request $request)
    {
        $query = Link::query();

        // Filtros opcionais
        if ($request->has('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }
        if ($request->has('cidade_id')) {
            $query->where('cidade_id', $request->cidade_id);
        }
        if ($request->has('bairro_id')) {
            $query->where('bairro_id', $request->bairro_id);
        }

        $links = $query->get();
        return response()->json($links);
    }
    /**
     * @OA\Post(
     *     path="/api/links",
     *     summary="Cadastrar Link",
     *     description="Adiciona um novo link.",
     *     tags={"Links"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"url", "descricao", "categoria_id", "cidade_id", "bairro_id"},
     *             @OA\Property(property="url", type="string", format="url", example="https://example.com"),
     *             @OA\Property(property="descricao", type="string", example="Descrição do link"),
     *             @OA\Property(property="categoria_id", type="integer", example=1),
     *             @OA\Property(property="cidade_id", type="integer", example=1),
     *             @OA\Property(property="bairro_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Link cadastrado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="url", type="string", example="https://example.com"),
     *                 @OA\Property(property="descricao", type="string", example="Descrição do link"),
     *                 @OA\Property(property="categoria_id", type="integer", example=1),
     *                 @OA\Property(property="cidade_id", type="integer", example=1),
     *                 @OA\Property(property="bairro_id", type="integer", example=1),
     *                 @OA\Property(property="created_at", type="string", example="2024-10-03T15:51:05.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", example="2024-10-03T15:51:05.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro de validação",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Erro de Validação"),
     *             @OA\Property(property="erros", type="object",
     *                 @OA\Property(property="url", type="array", @OA\Items(type="string", example="A URL é obrigatória")),
     *                 @OA\Property(property="descricao", type="array", @OA\Items(type="string", example="A descrição é obrigatória")),
     *                 @OA\Property(property="categoria_id", type="array", @OA\Items(type="string", example="A categoria é obrigatória")),
     *                 @OA\Property(property="cidade_id", type="array", @OA\Items(type="string", example="A cidade é obrigatória")),
     *                 @OA\Property(property="bairro_id", type="array", @OA\Items(type="string", example="O bairro é obrigatório"))
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|url',
            'descricao' => 'required|string',
            'categoria_id' => 'required|integer',
            'cidade_id' => 'required|integer',
            'bairro_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erro de Validação',
                'erros' => $validator->errors()
            ], 400);
        }

        $link = Link::create($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $link
        ], 201);
    }
    /**
     * @OA\Put(
     *     path="/api/links/{id}",
     *     summary="Atualizar Link",
     *     description="Atualiza um link existente.",
     *     tags={"Links"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"url", "descricao", "categoria_id", "cidade_id", "bairro_id"},
     *             @OA\Property(property="url", type="string", format="url", example="https://example.com"),
     *             @OA\Property(property="descricao", type="string", example="Descrição do link"),
     *             @OA\Property(property="categoria_id", type="integer", example=1),
     *             @OA\Property(property="cidade_id", type="integer", example=1),
     *             @OA\Property(property="bairro_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Link atualizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="url", type="string", example="https://example.com"),
     *                 @OA\Property(property="descricao", type="string", example="Descrição do link"),
     *                 @OA\Property(property="categoria_id", type="integer", example=1),
     *                 @OA\Property(property="cidade_id", type="integer", example=1),
     *                 @OA\Property(property="bairro_id", type="integer", example=1),
     *                 @OA\Property(property="created_at", type="string", example="2024-10-03T15:51:05.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", example="2024-10-03T15:51:05.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Link não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Link not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro de validação",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Erro de Validação"),
     *             @OA\Property(property="erros", type="object",
     *                 @OA\Property(property="url", type="array", @OA\Items(type="string", example="A URL é obrigatória")),
     *                 @OA\Property(property="descricao", type="array", @OA\Items(type="string", example="A descrição é obrigatória")),
     *                 @OA\Property(property="categoria_id", type="array", @OA\Items(type="string", example="A categoria é obrigatória")),
     *                 @OA\Property(property="cidade_id", type="array", @OA\Items(type="string", example="A cidade é obrigatória")),
     *                 @OA\Property(property="bairro_id", type="array", @OA\Items(type="string", example="O bairro é obrigatório"))
     *             )
     *         )
     *     )
     * )
     */
    public function atualizarLink(Request $request, $id)
    {
        $link = Link::find($id);

        if (!$link) {
            return response()->json([
                'status' => 'error',
                'message' => 'Link not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'url' => 'required|url',
            'descricao' => 'required|string',
            'categoria_id' => 'required|integer',
            'cidade_id' => 'required|integer',
            'bairro_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erro de Validação',
                'erros' => $validator->errors()
            ], 400);
        }

        $link->update($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $link
        ], 200);
    }
}
