<?php

namespace SonnyBlaine\RoveretiBridge;

use Simonetti\Rovereti\Client;
use SonnyBlaine\IntegratorBridge\SearchRequestInterface;

interface MethodInterface
{
    public function validateMethod(SearchRequestInterface $request);

    public function execute(Client $client, SearchRequestInterface $request);
}