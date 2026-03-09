<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Theme;
use Doctrine\ORM\EntityManagerInterface;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $em): Response
    {
        $themes = $em->getRepository(Theme::class)->findAll();

        return $this->render('home/index.html.twig', [
            'themes' => $themes,
        ]);
    }
}
