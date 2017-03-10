<?php
namespace SonnyBlaine\RoveretiBridge;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class RoveretiBridgeProvider
 * @package SonnyBlaine\RoveretiBridge
 */
class RoveretiBridgeProvider implements ServiceProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app['rovereti.bridge'] = function ($app) {
            return new RoveretiBridge(
                getenv('ROVERETI_BASE_URI'),
                getenv('ROVERETI_USER'),
                getenv('ROVERETI_KEY')
            );
        };
    }
}