<?php

namespace SonnyBlaine\RoveretiBridge;

use SonnyBlaine\IntegratorBridge\SearchRequestInterface;

abstract class AbstractMethodGateway
{
    /**
     * @var MethodInterface[]
     */
    private $methods;

    /**
     * AbstractMethodGateway constructor.
     * @param MethodInterface[] $methods
     */
    protected function __construct(array $methods)
    {
        $this->methods = $methods;
    }

    /**
     * @param SearchRequestInterface $request
     * @return MethodInterface
     * @throws \Exception
     */
    public function getMethodFromRequest(SearchRequestInterface $request): MethodInterface
    {
        foreach ($this->methods as $method) {
            if ($method->validateMethod($request)) {
                return $method;
            }
        }

        throw new \Exception("Sorry, method not found!");
    }
}