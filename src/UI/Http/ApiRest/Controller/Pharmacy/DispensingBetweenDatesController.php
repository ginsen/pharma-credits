<?php

declare(strict_types=1);

namespace App\UI\Http\ApiRest\Controller\Pharmacy;

use App\Application\Query\AwardPointDates\AwardPointDatesQuery;
use App\UI\Http\ApiRest\Controller\Base\CommandQueryController;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DispensingBetweenDatesController extends CommandQueryController
{
    /**
     * @Route("/farmacia/puntos/otorgados/{farmacia}/{desde}/{hasta}", methods={"GET"},
     *     name="api_pharmacy_points_dispensing_between_dates"
     * )
     *
     * @SWG\Tag(name="Farmacia")
     *
     * @SWG\Parameter(
     *     name="farmacia",
     *     type="string",
     *     in="path",
     *     description="Identificador de la farmacia",
     *     required=true
     * )
     *
     * @SWG\Parameter(
     *     name="desde",
     *     type="string",
     *     in="path",
     *     description="fecha de inicio, formato 'aaaa-mm-dd'",
     *     required=true
     * )
     *
     * @SWG\Parameter(
     *     name="hasta",
     *     type="string",
     *     in="path",
     *     description="fecha de fin, formato 'aaaa-mm-dd'",
     *     required=true
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Consulta de puntos otorgados exitosa"
     * )
     *
     * @SWG\Response(
     *     response=400,
     *     description="Fallo de petición"
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $pharmacy = $request->get('farmacia');
        $dateInit = $request->get('desde');
        $dateEnd  = $request->get('hasta');

        $query = new AwardPointDatesQuery($pharmacy, $dateInit, $dateEnd);

        return JsonResponse::create([
            'farmacia' => $pharmacy,
            'desde' => $dateInit,
            'hasta' => $dateEnd,
            'puntos_otorgados' => $this->handleQuery($query),
        ], Response::HTTP_OK);
    }
}
