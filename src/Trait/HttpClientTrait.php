<?php

namespace Pest\Symfony\Trait;

use Symfony\Component\HttpClient\DataCollector\HttpClientDataCollector;

trait HttpClientTrait
{
    public static function getHttpClientDataCollector(): HttpClientDataCollector
    {
        $container = static::getContainer();
        if ($container->has('data_collector.http_client')) {
            return $container->get('data_collector.http_client');
        }

        static::fail('"http_client" in config/packages/framework.yaml must be setup to make http client assertions.');
    }
}
