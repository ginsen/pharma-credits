<?php

declare(strict_types=1);

namespace App\UI\Http\ApiRest\Controller\Client;

use App\Application\Command\RedeemPoint\RedeemPointCommand;
use App\Application\Query\ClientBalance\ClientBalanceQuery;
use App\Domain\Entity\Client;
use App\Domain\Entity\Pharmacy;
use App\Domain\Entity\Point;
use App\UI\Http\ApiRest\Controller\Base\CommandQueryController;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RedeemController extends CommandQueryController
{
    /**
     * @Route("/cliente/puntos/canjear", methods={"PUT"},
     *     name="api_client_points_redeem",
     *     requirements={
     *      "client": "\w+",
     *      "pharmacy": "\w+",
     *      "points": "\d+"
     *     }
     * )
     * @OA\Tag(name="Cliente")
     *
     * @OA\RequestBody(
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             required={"client", "pharmacy", "points"},
     *             @OA\Property(
     *                 property="client",
     *                 type="string",
     *                 description="Identificador del cliente"
     *             ),
     *             @OA\Property(
     *                 property="pharmacy",
     *                 type="string",
     *                 description="Identificador de la farmacia"
     *             ),
     *             @OA\Property(
     *                 property="points",
     *                 type="integer",
     *                 description="Cantidad de puntos a canjear"
     *             )
     *         )
     *     )
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Puntos canjeados con éxito"
     * )
     * @OA\Response(
     *     response=400,
     *     description="Fallo de petición"
     * )
     */
    public function __invoke(Request $request): JsonResponse
    {
        $params = json_decode($request->getContent(), true);

        $this->redeemPoints($params);

        $query   = new ClientBalanceQuery($params[Client::NAME]);
        $balance = $this->queryHandler($query);

        return new JsonResponse([
            Client::BALANCE => $balance,
        ], Response::HTTP_OK);
    }


    private function redeemPoints(array $params): void
    {
        $command = new RedeemPointCommand(
            $params[Client::NAME],
            $params[Pharmacy::NAME],
            $params[Point::POINTS]
        );

        $this->commandHandler($command);
    }
}
