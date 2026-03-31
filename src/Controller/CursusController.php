<?php

namespace App\Controller;

use App\Entity\Theme;
use App\Entity\Lesson;
use App\Entity\UserLesson;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CursusController extends AbstractController
{
    #[Route('/theme/{id}', name: 'theme_cursus')]
    public function index(Theme $theme, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $validated = 0;
        $total = $em->getRepository(Lesson::class)->countLessonsByTheme($theme);

        if ($user) {
            $validated = $em->getRepository(UserLesson::class)
                ->countValidatedLessons($user, $theme);
        }

        return $this->render('cursus/index.html.twig', [
            'theme' => $theme,
            'cursus' => $theme->getCursus(),
            'isThemeValidated' => $total > 0 && $validated === $total,
        ]);
    }
}