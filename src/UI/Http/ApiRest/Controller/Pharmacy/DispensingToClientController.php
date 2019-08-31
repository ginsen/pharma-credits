<?php

declare(strict_types=1);

namespace App\UI\Http\ApiRest\Controller\Pharmacy;

use App\Application\Query\AwardPointClient\AwardPointClientQuery;
use App\UI\Http\ApiRest\Controller\Base\CommandQueryController;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DispensingToClientController extends CommandQueryController
{
    /**
     * @Route("/farmacia/puntos/otorgados/{farmacia}/{cliente}", methods={"GET"},
     *     name="api_pharmacy_points_dispensing_to_client"
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
     *     name="cliente",
     *     type="string",
     *     in="path",
     *     description="Identificador del cliente",
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
        $client   = $request->get('cliente');

        $query = new AwardPointClientQuery($pharmacy, $client);

        return JsonResponse::create([
            'farmacia' => $pharmacy,
            'cliente' => $client,
            'puntos_otorgados' => $this->handleQuery($query),
        ], Response::HTTP_OK);
    }
}
