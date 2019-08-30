<?php

declare(strict_types=1);

namespace App\UI\Http\ApiRest\Controller\Client;

use App\Application\Command\ExchangePoint\ExchangePointCommand;
use App\Application\Query\ClientBalance\ClientBalanceQuery;
use App\UI\Http\ApiRest\Controller\Base\CommandQueryController;
use Assert\AssertionFailedException;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExchangeController extends CommandQueryController
{
    /**
     * @Route("/cliente/puntos/canjear", methods={"PUT"},
     *     name="api_client_points_exchange",
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
     *     required=true,
     *     description="cliente: Identificador del cliente<br>farmacia: Identificador de la farmacia<br>puntos: Cantidad de puntos a incrementar",
     *     schema=@SWG\Schema(type="object",
     *         @SWG\Property(property="cliente", type="string", description="Identificador del cliente"),
     *         @SWG\Property(property="farmacia", type="string", description="Identificador de la farmacia"),
     *         @SWG\Property(property="puntos", type="integer", description="Cantidad de puntos a incrementar")
     *     )
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Puntos canjeados con éxito"
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

        $command = new ExchangePointCommand(
            $params['cliente'],
            $params['farmacia'],
            $params['puntos']
        );

        $this->handleCommand($command);

        $query = new ClientBalanceQuery($params['cliente']);

        return JsonResponse::create([
            'saldo' => $this->handleQuery($query)
        ], Response::HTTP_OK);
    }
}
