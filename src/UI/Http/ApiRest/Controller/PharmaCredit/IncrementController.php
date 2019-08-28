<?php

declare(strict_types=1);

namespace App\UI\Http\ApiRest\Controller\PharmaCredit;

use App\UI\Http\ApiRest\Controller\CommandQueryController;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IncrementController extends CommandQueryController
{
    /**
     * @Route("/user/card-credit", methods={"POST"},
     *     name="api_user_card_credit_increment",
     *     requirements={
     *      "farmacia": "\w+",
     *      "cliente": "\w+",
     *      "creditos": "\d+"
     *     }
     * )
     *
     * @SWG\Response(
     *     response=202,
     *     description="Creditos incrementados con éxito"
     * )
     *
     * @SWG\Response(
     *     response=400,
     *     description="Bad request"
     * )
     *
     * @SWG\Parameter(
     *     name="datos requeridos",
     *     type="object",
     *     in="body",
     *     schema=@SWG\Schema(type="object",
     *         @SWG\Property(property="farmacia", type="string"),
     *         @SWG\Property(property="cliente", type="string"),
     *         @SWG\Property(property="creditos", type="integer")
     *     )
     * )
     *
     * @SWG\Tag(name="Incrementa creditos")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $params = json_decode($request->getContent(), true);

        dump($params);

        return JsonResponse::create([], Response::HTTP_ACCEPTED);
    }
}
