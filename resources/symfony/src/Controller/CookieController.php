<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class CookieController
{
    #[Route('/cookie', name: 'app_cookie')]
    public function __invoke(): Response
    {
        $response = new Response();
        $response->headers->setCookie(new Cookie('name', 'value'));

        return $response;
    }
}
