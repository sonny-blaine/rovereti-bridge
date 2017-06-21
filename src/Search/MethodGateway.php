<?php

namespace SonnyBlaine\RoveretiBridge\Search;

use SonnyBlaine\RoveretiBridge\AbstractMethodGateway;
use SonnyBlaine\RoveretiBridge\Search\Method\PagamentoCaixa;

/**
 * Class MethodGateway
 * @package SonnyBlaine\RoveretiBridge\Search
 */
class MethodGateway extends AbstractMethodGateway
{
    /**
     * MethodGateway constructor.
     * @param array|\SonnyBlaine\RoveretiBridge\MethodInterface[] $methods
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
                new PagamentoCaixa()
            ]
        );
    }
}