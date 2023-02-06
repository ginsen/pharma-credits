<?php

declare(strict_types=1);

namespace App\UI\Http\ApiRest\Controller\Pharmacy;

use App\Application\Query\AwardPointDates\AwardPointDatesQuery;
use App\Domain\Entity\Pharmacy;
use App\Domain\Entity\Point;
use App\UI\Http\ApiRest\Controller\Base\CommandQueryController;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DispensingBetweenDatesController extends CommandQueryController
{
    /**
     * @Route("/farmacia/puntos/otorgados/{pharmacy}/{from}/{to}", methods={"GET"},
     *     name="api_pharmacy_points_dispensing_between_dates"
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
     *     name="from",
     *     in="path",
     *     description="fecha de inicio, formato 'aaaa-mm-dd'",
     *     required=true,
     *     @OA\Schema(type="string")
     * )
     * @OA\Parameter(
     *     name="to",
     *     in="path",
     *     description="fecha de fin, formato 'aaaa-mm-dd'",
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
        $dateInit = $request->get(Point::FROM);
        $dateEnd  = $request->get(Point::TO);

        $query = new AwardPointDatesQuery($pharmacy, $dateInit, $dateEnd);

        return new JsonResponse([
            Pharmacy::NAME        => $pharmacy,
            Point::FROM           => $dateInit,
            Point::TO             => $dateEnd,
            Point::AWARDED_POINTS => $this->queryHandler($query),
        ], Response::HTTP_OK);
    }
}
