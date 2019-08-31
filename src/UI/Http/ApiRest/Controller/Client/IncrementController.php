<?php

declare(strict_types=1);

namespace App\UI\Http\ApiRest\Controller\Client;

use App\Application\Command\CreatePoint\CreatePointsCommand;
use App\Application\Query\ClientBalance\ClientBalanceQuery;
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
     * @SWG\Tag(name="Cliente")
     *
     * @SWG\Parameter(
     *     name="datos requeridos",
     *     type="object",
     *     in="body",
     *     description="cliente: Identificador del cliente<br>farmacia: Identificador de la farmacia<br>puntos: Cantidad de puntos a incrementar",
     *     schema=@SWG\Schema(type="object",
     *         @SWG\Property(property="cliente", type="string", description="Identificador del cliente"),
     *         @SWG\Property(property="farmacia", type="string", description="Identificador de la farmacia"),
     *         @SWG\Property(property="puntos", type="integer", description="Cantidad de puntos a incrementar")
     *     )
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

        $query = new ClientBalanceQuery($params['cliente']);

        return JsonResponse::create([
            'saldo' => $this->handleQuery($query),
        ], Response::HTTP_ACCEPTED);
    }
}
