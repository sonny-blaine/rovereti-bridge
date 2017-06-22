<?php

namespace SonnyBlaine\RoveretiBridge\Search\Method;

use GuzzleHttp\Client;
use SonnyBlaine\IntegratorBridge\RequestInterface;
use SonnyBlaine\RoveretiBridge\MethodInterface;
use Simonetti\Rovereti as SDK;

/**
 * Class PagamentoCaixa
 * @package SonnyBlaine\RoveretiBridge\Search\Method
 */
class PagamentoCaixa implements MethodInterface
{
    const PAGAMENTO_CAIXA_METHOD = 'BuscarPagamentoCaixa';
    const URL = 'Caixa/' . self::PAGAMENTO_CAIXA_METHOD;

    /**
     * @param RequestInterface $request
     * @return bool
     */
    public function validateMethod(RequestInterface $request)
    {
        return self::PAGAMENTO_CAIXA_METHOD == $request->getMethodIdentifier();
    }

    /**
     * @param Client $client
     * @param RequestInterface $request
     * @return SDK\SearchResponse
     * @throws \Exception
     */
    public function execute(Client $client, RequestInterface $request)
    {
        $data = $request->getData();

        if (empty($data->codEmpresa)) {
            throw new \Exception("Sorry, codEmpresa is empty!");
        }

        if (empty($data->datPagamento)) {
            throw new \Exception("Sorry, datPagamento is empty!");
        }

        $datPagamento = \DateTime::createFromFormat("d-m-Y", $data->datPagamento);
        if (empty($datPagamento)) {
            throw new \Exception("Sorry, incorrect date format!");
        }

        $buscarPagamentoCaixa = new SDK\BuscarPagamentoCaixa($client);

        return $buscarPagamentoCaixa->execute(self::PAGAMENTO_CAIXA_METHOD, $data->codEmpresa, $datPagamento);
    }
}