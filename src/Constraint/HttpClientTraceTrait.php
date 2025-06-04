<?php

declare(strict_types=1);

namespace Pest\Symfony\Constraint;

use Symfony\Component\HttpClient\DataCollector\HttpClientDataCollector;

trait HttpClientTraceTrait
{
    private function getTraces(HttpClientDataCollector $collector, string $httpClientId): ?array
    {
        if (0 === count($collector->getClients())) {
            $collector->lateCollect();
        }

        return $collector->getClients()[$httpClientId]['traces'];
    }
}
