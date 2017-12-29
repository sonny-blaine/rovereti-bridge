<?php

namespace SonnyBlaine\RoveretiBridge\Search\Method;

use SonnyBlaine\IntegratorBridge\RequestInterface;
use SonnyBlaine\RoveretiBridge\MethodInterface;
use Simonetti\Rovereti as SDK;

class DisponibilidadeFinanceira implements MethodInterface
{
    private const URI = '/Api/ContaPagar/DisponibilidadeFinanceira/jsonData';
    private const METHOD_NAME = 'BuscarDisponibilidadeFinanceira';

    public function validateMethod(RequestInterface $request)
    {
        return self::METHOD_NAME === $request->getMethodIdentifier();
    }

    public function execute(SDK\Client $client, RequestInterface $request)
    {
        $codEmpresa = intval($request->getData()->codEmpresa);
        if (!$codEmpresa) {
            throw new \Exception("Sorry, codEmpresa is empty!");
        }

        $anoMes = \DateTime::createFromFormat("!Ym", $request->getData()->anoMes);
        if (!$anoMes) {
            throw new \Exception("Sorry, data is empty os invalid!");
        }

        $centrosCusto = $request->getData()->centrosCusto;
        if (is_string($centrosCusto)) {
            $centrosCusto = json_decode($centrosCusto);
        }
        if (empty($centrosCusto)) {
            $centrosCusto = [];
        }

        $buscarDisp = new SDK\BuscarDisponibilidadeFinanceira($client);
        return $buscarDisp->execute(self::URI, $codEmpresa, $anoMes, $centrosCusto);
    }
}