<?php

declare(strict_types=1);

namespace App\UI\Http\ApiRest\Controller;

use App\Application\Command\CreatePoint\CreatePointsCommand;
use App\UI\Http\ApiRest\Controller\Base\CommandQueryController;
use Assert\AssertionFailedException;
use Swagger\Annotations as SWG;
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
     *      "cliente": "\w+",
     *      "farmacia": "\w+",
     *      "puntos": "\d+"
     *     }
     * )
     *
     * @SWG\Response(
     *     response=202,
     *     description="Puntos de descuento incrementados con éxito"
     * )
     *
     * @SWG\Response(
     *     response=400,
     *     description="Fallo de petición"
     * )
     *
     * @SWG\Parameter(
     *     name="datos requeridos",
     *     type="object",
     *     in="body",
     *     schema=@SWG\Schema(type="object",
     *         @SWG\Property(property="cliente", type="string"),
     *         @SWG\Property(property="farmacia", type="string"),
     *         @SWG\Property(property="puntos", type="integer")
     *     )
     * )
     *
     * @SWG\Tag(name="Cliente")
     *
     * @param Request $request
     * @throws AssertionFailedException
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $params = json_decode($request->getContent(), true);

        $command = new CreatePointsCommand(
            $params['cliente'],
            $params['farmacia'],
            (int) $params['puntos']
        );

        $this->handleCommand($command);

        return JsonResponse::create([], Response::HTTP_ACCEPTED);
    }
}
