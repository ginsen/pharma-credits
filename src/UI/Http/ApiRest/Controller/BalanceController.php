<?php

declare(strict_types=1);

namespace App\UI\Http\ApiRest\Controller;

use App\Application\Query\ClientBalance\ClientBalanceQuery;
use App\UI\Http\ApiRest\Controller\Base\CommandQueryController;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BalanceController extends CommandQueryController
{
    /**
     * @Route("/cliente/puntos/saldo/{cliente}", methods={"GET"},
     *     name="api_client_points_balance"
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Consulta de puntos disponibles exitosa"
     * )
     *
     * @SWG\Response(
     *     response=400,
     *     description="Fallo de petición"
     * )
     *
     * @SWG\Parameter(
     *     name="cliente",
     *     type="string",
     *     in="path",
     *     description="Identificador del cliente",
     *     required=true
     * )
     *
     * @SWG\Tag(name="Cliente")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $uuid  = $request->get('cliente');
        $query = new ClientBalanceQuery($uuid);

        return JsonResponse::create([
            'saldo' => $this->handleQuery($query),
        ], Response::HTTP_OK);
    }
}