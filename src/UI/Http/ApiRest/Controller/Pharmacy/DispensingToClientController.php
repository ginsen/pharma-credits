<?php

declare(strict_types=1);

namespace App\UI\Http\ApiRest\Controller\Pharmacy;

use App\Application\Query\AwardPointClient\AwardPointClientQuery;
use App\Domain\Entity\Client;
use App\Domain\Entity\Pharmacy;
use App\Domain\Entity\Point;
use App\UI\Http\ApiRest\Controller\Base\CommandQueryController;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DispensingToClientController extends CommandQueryController
{
    /**
     * @Route("/farmacia/puntos/otorgados/{pharmacy}/{client}", methods={"GET"},
     *     name="api_pharmacy_points_dispensing_to_client"
     * )
     * @OA\Tag(name="Farmacia")
     * @OA\Parameter(
     *     name="pharmacy",
     *     in="path",
     *     description="Identificador de la farmacia",
     *     required=true,
     *     @OA\Schema(type="string")
     * )
     * @OA\Parameter(
     *     name="client",
     *     in="path",
     *     description="Identificador del cliente",
     *     required=true,
     *     @OA\Schema(type="string")
     * )
     * @OA\Response(
     *     response=200,
     *     description="Consulta de puntos otorgados exitosa"
     * )
     * @OA\Response(
     *     response=400,
     *     description="Fallo de petición"
     * )
     */
    public function __invoke(Request $request): JsonResponse
    {
        $pharmacy = $request->get(Pharmacy::NAME);
        $client   = $request->get(Client::NAME);

        $query = new AwardPointClientQuery($pharmacy, $client);

        return new JsonResponse([
            Pharmacy::NAME        => $pharmacy,
            Client::NAME          => $client,
            Point::AWARDED_POINTS => $this->queryHandler($query),
        ], Response::HTTP_OK);
    }
}
