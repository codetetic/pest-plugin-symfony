<?php

declare(strict_types=1);

namespace Pest\Symfony\Constraint;

use Symfony\Component\HttpClient\DataCollector\HttpClientDataCollector;

trait HttpClientTraceTrait
{
    private function getTraces(HttpClientDataCollector $collector): ?array
    {
        if (0 === count($collector->getClients())) {
            $collector->lateCollect();
        }

        return $collector->getClients()[$this->httpClientId]['traces'];
    }
}
