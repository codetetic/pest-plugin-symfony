<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class UnprocessableController
{
    #[Route('/unprocessable', name: 'app_unprocessable')]
    public function __invoke(): Response
    {
        return new Response(status: 422);
    }
}
