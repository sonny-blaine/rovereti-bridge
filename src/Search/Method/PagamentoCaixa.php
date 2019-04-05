<?php

namespace SonnyBlaine\RoveretiBridge\Search\Method;

use Simonetti\Rovereti\Client;
use SonnyBlaine\IntegratorBridge\SearchRequestInterface;
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
     * @param SearchRequestInterface $request
     * @return bool
     */
    public function validateMethod(SearchRequestInterface $request)
    {
        return self::PAGAMENTO_CAIXA_METHOD == $request->getMethodIdentifier();
    }

    /**
     * @param Client $client
     * @param SearchRequestInterface $request
     * @return SDK\SearchResponse
     * @throws \Exception
     */
    public function execute(Client $client, SearchRequestInterface $request): SDK\SearchResponse
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

        return (new SDK\BuscarPagamentoCaixa($client))
            ->execute(self::URL, $data->codEmpresa, $datPagamento);
    }
}