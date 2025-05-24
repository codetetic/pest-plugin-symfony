<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HtmlController extends AbstractController
{
    #[Route('/html', name: 'app_html')]
    public function __invoke(): Response
    {
        return $this->render(
            'html.html.twig',
        );
    }
}
