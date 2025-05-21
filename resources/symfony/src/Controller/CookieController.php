<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CookieController extends AbstractController
{
    #[Route('/cookie', name: 'app_cookie')]
    public function __invoke(): Response
    {
        $response = new Response();
        $response->headers->setCookie(new Cookie('name', 'value'));

        return $response;
    }
}