<?php

namespace App\Controller;

use App\Entity\Cursus;
use App\Entity\Lesson;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LessonController extends AbstractController
{
    #[Route('/cursus/{id}', name: 'cursus_lesson')]
    public function index(Cursus $cursus): Response
    {
        return $this->render('lesson/index.html.twig', [
            'cursus' => $cursus,
            'lesson' => $cursus->getLessons(),
            'user' => $this->getUser(), // 👈 AJOUT
        ]);
    }

    #[Route('/lesson/{id}', name: 'lesson_read')]
    public function read(Lesson $lesson): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException();
        }

        $hasAccess = false;

        // Vérifier si la leçon est achetée
        foreach ($user->getLessonsBought() as $boughtLesson) {
            if ($boughtLesson->getId() === $lesson->getId()) {
                $hasAccess = true;
            }
        }

        // Vérifier si le cursus est acheté
        foreach ($lesson->getCursus() as $cursus) {
            foreach ($user->getCursusBought() as $boughtCursus) {
                if ($cursus->getId() === $boughtCursus->getId()) {
                    $hasAccess = true;
                }
            }
        }

        if (!$hasAccess) {
            throw $this->createAccessDeniedException("Vous n'avez pas accès à cette leçon.");
        }

        return $this->render('lessonText/index.html.twig', [
            'lesson' => $lesson,
        ]);
    }
}