<?php

declare(strict_types=1);

namespace App\UI\Http\ApiRest\Controller\Client;

use App\Application\Command\CreatePoint\CreatePointCommand;
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

class IncrementController extends CommandQueryController
{
    /**
     * @Route("/cliente/puntos/incrementar", methods={"POST"},
     *     name="api_client_points_increment",
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
     *                 description="Cantidad de puntos a incrementar"
     *             )
     *         )
     *     )
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="Puntos de descuento incrementados con éxito"
     * )
     * @OA\Response(
     *     response=400,
     *     description="Fallo de petición"
     * )
     */
    public function __invoke(Request $request): JsonResponse
    {
        $params = json_decode($request->getContent(), true);

        $command = new CreatePointCommand(
            $params[Client::NAME],
            $params[Pharmacy::NAME],
            (int) $params[Point::POINTS]
        );

        $this->commandHandler($command);

        $query = new ClientBalanceQuery($params[Client::NAME]);
        $data  = $this->queryHandler($query);

        return new JsonResponse([
            Client::BALANCE => $data,
        ], Response::HTTP_ACCEPTED);
    }
}
