<?php

declare(strict_types=1);

namespace App\UI\Http\ApiRest\Controller\Client;

use App\Application\Query\ClientBalance\ClientBalanceQuery;
use App\Domain\Entity\Client;
use App\UI\Http\ApiRest\Controller\Base\CommandQueryController;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BalanceController extends CommandQueryController
{
    /**
     * @Route("/cliente/puntos/saldo/{client}", methods={"GET"},
     *     name="api_client_points_balance"
     * )
     * @OA\Tag(name="Cliente")
     * @OA\Parameter(
     *     name="client",
     *     in="path",
     *     description="Identificador del cliente",
     *     required=true,
     *     @OA\Schema(type="string")
     * )
     * @OA\Response(
     *     response=200,
     *     description="Consulta de puntos disponibles exitosa"
     * )
     * @OA\Response(
     *     response=400,
     *     description="Fallo de petición"
     * )
     */
    public function __invoke(Request $request): JsonResponse
    {
        $uuid = $request->get(Client::NAME);

        $query   = new ClientBalanceQuery($uuid);
        $balance = $this->queryHandler($query);

        return new JsonResponse([
            Client::BALANCE => $balance,
        ], Response::HTTP_OK);
    }
}
