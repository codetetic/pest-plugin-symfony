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
    public function __invoke(HttpClientInterface $httpClient, HttpClientInterface $symfonyHttpClient): Response
    {
        $httpClient->request('GET', 'https://symfony.com/');

        $symfonyHttpClient->request('GET', '/');
        $symfonyHttpClient->request('POST', '/', ['body' => 'foo']);
        $symfonyHttpClient->request('POST', '/', ['body' => ['foo' => 'bar']]);
        $symfonyHttpClient->request('POST', '/', ['json' => ['foo' => 'bar']]);
        $symfonyHttpClient->request('POST', '/', [
            'headers' => ['X-Test-Header' => 'foo'],
            'json' => ['foo' => 'bar'],
        ]);
        $symfonyHttpClient->request('GET', '/doc/current/index.html');

        return new Response();
    }
}
