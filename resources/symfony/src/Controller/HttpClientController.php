<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsController]
class HttpClientController
{
    #[Route('/http-client', name: 'app_http_client')]
    public function __invoke(HttpClientInterface $httpClient): Response
    {
        $httpClient->request('GET', 'https://symfony.com/');

        return new Response();
    }
}
