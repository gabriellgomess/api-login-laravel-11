<?php
namespace App\Http\Controllers\Links;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Link;
use Illuminate\Support\Facades\Validator;

class LinksController extends Controller
{
    /**
     * @OA\Schema(
     *     schema="Categoria",
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="nome", type="string", example="Nome da Categoria"),
     * )
     */

    /**
     * @OA\Schema(
     *     schema="Cidade",
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="nome", type="string", example="Nome da Cidade"),
     * )
     */

    /**
     * @OA\Schema(
     *     schema="Bairro",
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="nome", type="string", example="Nome do Bairro"),
     *     @OA\Property(property="cidade_id", type="integer", example=1),
     * )
     */

    /**
     * @OA\Post(
     *     path="/api/links",
     *     summary="Criar um novo link",
     *     description="Adiciona um novo link.",
     *     tags={"Links"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"url", "descricao", "categoria_id", "cidade_id", "bairro_id"},
     *             @OA\Property(property="url", type="string", example="https://wa.me/5511999999999"),
     *             @OA\Property(property="descricao", type="string", example="Descrição do link"),
     *             @OA\Property(property="categoria_id", type="integer", example=1),
     *             @OA\Property(property="cidade_id", type="integer", example=1),
     *             @OA\Property(property="bairro_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Link criado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Link criado com sucesso"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="url", type="string", example="https://wa.me/5511999999999"),
     *                 @OA\Property(property="descricao", type="string", example="Descrição do link"),
     *                 @OA\Property(property="categoria_id", type="integer", example=1),
     *                 @OA\Property(property="cidade_id", type="integer", example=1),
     *                 @OA\Property(property="bairro_id", type="integer", example=1),
     *                 @OA\Property(property="created_at", type="string", example="2024-10-07T15:51:05.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", example="2024-10-07T15:51:05.000000Z")
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
     *                 @OA\Property(property="url", type="array", @OA\Items(type="string", example="URL é obrigatório")),
     *                 @OA\Property(property="descricao", type="array", @OA\Items(type="string", example="Descrição é obrigatória"))
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            $validateLink = Validator::make($request->all(), [
                'url' => 'required|url',
                'descricao' => 'required|string',
                'categoria_id' => 'required|integer',
                'cidade_id' => 'required|integer',
                'bairro_id' => 'required|integer',
            ]);

            if ($validateLink->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation Errors',
                    'erros' => $validateLink->errors()
                ], 400);
            }

            $link = Link::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Link created successfully',
                'data' => $link
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Internal Server Error',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/categorias",
     *     summary="Listar todas as categorias",
     *     description="Retorna uma lista de todas as categorias.",
     *     tags={"Categorias"},
     *     @OA\Response(
     *         response=200,
     *         description="Categorias recuperadas com sucesso",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Categoria"))
     *     )
     * )
     */

    /**
     * @OA\Post(
     *     path="/api/categorias",
     *     summary="Criar uma nova categoria",
     *     description="Adiciona uma nova categoria.",
     *     tags={"Categorias"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nome"},
     *             @OA\Property(property="nome", type="string", example="Nome da Categoria")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Categoria criada com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Categoria")
     *     )
     * )
     */

    /**
     * @OA\Put(
     *     path="/api/categorias/{id}",
     *     summary="Atualizar uma categoria existente",
     *     description="Atualiza os dados de uma categoria.",
     *     tags={"Categorias"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da categoria",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nome"},
     *             @OA\Property(property="nome", type="string", example="Nome Atualizado da Categoria")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoria atualizada com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Categoria")
     *     )
     * )
     */

    /**
     * @OA\Delete(
     *     path="/api/categorias/{id}",
     *     summary="Deletar uma categoria",
     *     description="Remove uma categoria do sistema.",
     *     tags={"Categorias"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da categoria",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Categoria deletada com sucesso"
     *     )
     * )
     */

    /**
     * @OA\Get(
     *     path="/api/cidades",
     *     summary="Listar todas as cidades",
     *     description="Retorna uma lista de todas as cidades.",
     *     tags={"Cidades"},
     *     @OA\Response(
     *         response=200,
     *         description="Cidades recuperadas com sucesso",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Cidade"))
     *     )
     * )
     */

    /**
     * @OA\Post(
     *     path="/api/cidades",
     *     summary="Criar uma nova cidade",
     *     description="Adiciona uma nova cidade.",
     *     tags={"Cidades"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nome"},
     *             @OA\Property(property="nome", type="string", example="Nome da Cidade")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Cidade criada com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Cidade")
     *     )
     * )
     */

    /**
     * @OA\Put(
     *     path="/api/cidades/{id}",
     *     summary="Atualizar uma cidade existente",
     *     description="Atualiza os dados de uma cidade.",
     *     tags={"Cidades"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da cidade",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nome"},
     *             @OA\Property(property="nome", type="string", example="Nome Atualizado da Cidade")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cidade atualizada com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Cidade")
     *     )
     * )
     */

    /**
     * @OA\Delete(
     *     path="/api/cidades/{id}",
     *     summary="Deletar uma cidade",
     *     description="Remove uma cidade do sistema.",
     *     tags={"Cidades"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da cidade",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Cidade deletada com sucesso"
     *     )
     * )
     */

    /**
     * @OA\Get(
     *     path="/api/bairros",
     *     summary="Listar todos os bairros",
     *     description="Retorna uma lista de todos os bairros.",
     *     tags={"Bairros"},
     *     @OA\Response(
     *         response=200,
     *         description="Bairros recuperados com sucesso",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Bairro"))
     *     )
     * )
     */

    /**
     * @OA\Post(
     *     path="/api/bairros",
     *     summary="Criar um novo bairro",
     *     description="Adiciona um novo bairro.",
     *     tags={"Bairros"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nome", "cidade_id"},
     *             @OA\Property(property="nome", type="string", example="Nome do Bairro"),
     *             @OA\Property(property="cidade_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Bairro criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Bairro")
     *     )
     * )
     */

    /**
     * @OA\Put(
     *     path="/api/bairros/{id}",
     *     summary="Atualizar um bairro existente",
     *     description="Atualiza os dados de um bairro.",
     *     tags={"Bairros"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do bairro",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nome", "cidade_id"},
     *             @OA\Property(property="nome", type="string", example="Nome Atualizado do Bairro"),
     *             @OA\Property(property="cidade_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Bairro atualizado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Bairro")
     *     )
     * )
     */

    /**
     * @OA\Delete(
     *     path="/api/bairros/{id}",
     *     summary="Deletar um bairro",
     *     description="Remove um bairro do sistema.",
     *     tags={"Bairros"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do bairro",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Bairro deletado com sucesso"
     *     )
     * )
     */

    /**
     * @OA\Get(
     *     path="/api/links/{id}",
     *     summary="Obter um link específico",
     *     description="Retorna os detalhes de um link.",
     *     tags={"Links"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do link",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Link recuperado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="url", type="string", example="https://wa.me/5511999999999"),
     *                 @OA\Property(property="descricao", type="string", example="Descrição do link"),
     *                 @OA\Property(property="categoria_id", type="integer", example=1),
     *                 @OA\Property(property="cidade_id", type="integer", example=1),
     *                 @OA\Property(property="bairro_id", type="integer", example=1),
     *                 @OA\Property(property="created_at", type="string", example="2024-10-07T15:51:05.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", example="2024-10-07T15:51:05.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Link não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Link não encontrado")
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
     * @OA\Put(
     *     path="/api/links/{id}",
     *     summary="Atualizar um link existente",
     *     description="Atualiza os dados de um link.",
     *     tags={"Links"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do link",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"url", "descricao", "categoria_id", "cidade_id", "bairro_id"},
     *             @OA\Property(property="url", type="string", example="https://wa.me/5511999999999"),
     *             @OA\Property(property="descricao", type="string", example="Descrição atualizada do link"),
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
     *             @OA\Property(property="message", type="string", example="Link updated successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="url", type="string", example="https://wa.me/5511999999999"),
     *                 @OA\Property(property="descricao", type="string", example="Descrição atualizada do link"),
     *                 @OA\Property(property="categoria_id", type="integer", example=1),
     *                 @OA\Property(property="cidade_id", type="integer", example=1),
     *                 @OA\Property(property="bairro_id", type="integer", example=1),
     *                 @OA\Property(property="created_at", type="string", example="2024-10-07T15:51:05.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", example="2024-10-07T15:51:05.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Link não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Link não encontrado")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $link = Link::find($id);

        if (!$link) {
            return response()->json([
                'status' => 'error',
                'message' => 'Link not found'
            ], 404);
        }

        $validateLink = Validator::make($request->all(), [
            'url' => 'required|url',
            'descricao' => 'required|string',
            'categoria_id' => 'required|integer',
            'cidade_id' => 'required|integer',
            'bairro_id' => 'required|integer',
        ]);

        if ($validateLink->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation Errors',
                'erros' => $validateLink->errors()
            ], 400);
        }

        $link->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Link updated successfully',
            'data' => $link
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/links/{id}",
     *     summary="Deletar um link existente",
     *     description="Remove um link do sistema.",
     *     tags={"Links"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do link",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Link deletado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Link não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Link não encontrado")
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

   

    // Função para listar todos os links (com filtros opcionais)
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

    // Função para listar links filtrados (caso queira uma função separada)
    public function linksFiltrados(Request $request)
    {
        return $this->links($request);
    }
    // Função para cadastrar um novo link de WhatsApp
    public function cadastrarLink(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'descricao' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'cidade_id' => 'required|exists:cidades,id',
            'bairro_id' => 'required|exists:bairros,id',
        ]);

        $link = Link::create([
            'url' => $request->url,
            'descricao' => $request->descricao,
            'categoria_id' => $request->categoria_id,
            'cidade_id' => $request->cidade_id,
            'bairro_id' => $request->bairro_id,
        ]);

        return response()->json($link, 201);
    }
}
