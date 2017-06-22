<?php

namespace SonnyBlaine\RoveretiBridge;

use Simonetti\Rovereti\Client;
use SonnyBlaine\IntegratorBridge\RequestInterface;

interface MethodInterface
{
    public function validateMethod(RequestInterface $request);

    public function execute(Client $client, RequestInterface $request);
}