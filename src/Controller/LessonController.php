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
        ]);
    }

    #[Route('/lesson/{id}', name: 'lesson_read')]
    public function read(Lesson $lesson): Response
    {
        return $this->render('lessonText/index.html.twig', [
            'lesson' => $lesson,
        ]);
    }
}