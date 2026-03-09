<?php

namespace App\Controller;

use App\Entity\Theme;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CursusController extends AbstractController
{
    #[Route('/theme/{id}', name: 'theme_cursus')]
    public function index(Theme $theme): Response
    {
        return $this->render('cursus/index.html.twig', [
            'theme' => $theme,
            'cursus' => $theme->getCursus(),
        ]);
    }
}