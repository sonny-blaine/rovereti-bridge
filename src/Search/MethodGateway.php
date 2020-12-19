<?php

namespace SonnyBlaine\RoveretiBridge\Search;

use SonnyBlaine\RoveretiBridge\AbstractMethodGateway;
use SonnyBlaine\RoveretiBridge\MethodInterface;
use SonnyBlaine\RoveretiBridge\Search\Method;

/**
 * Class MethodGateway
 * @package SonnyBlaine\RoveretiBridge\Search
 */
class MethodGateway extends AbstractMethodGateway
{
    /**
     * MethodGateway constructor.
     * @param array|MethodInterface[] $methods
     */
    protected function __construct($methods)
    {
        parent::__construct($methods);
    }

    /**
     * @return MethodGateway
     */
    public static function getInstance()
    {
        return new self(
            [
                new Method\PagamentoCaixa(),
                new Method\DisponibilidadeFinanceira()
            ]
        );
    }
}