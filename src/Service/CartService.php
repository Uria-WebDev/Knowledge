<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\CursusRepository;
use App\Repository\LessonRepository;

class CartService
{
    private $session;
    private $cursusRepository;
    private $lessonRepository;

    public function __construct(RequestStack $requestStack, CursusRepository $cursusRepository, LessonRepository $lessonRepository)
    {
        $this->session = $requestStack->getSession();
        $this->cursusRepository = $cursusRepository;
        $this->lessonRepository = $lessonRepository;
    }

    // Ajout d'un cursus au panier
    public function add(int $cursusId)
    {
        $cart = $this->session->get('cart', []);

        $key = 'cursus_' . $cursusId;

        $cart[$key] = [
            'type' => 'cursus',
            'id' => $cursusId,
        ];

        $this->session->set('cart', $cart);
    }

    // Ajout d'une leçon au panier
    public function addLesson(int $lessonId)
    {
        $cart = $this->session->get('cart', []);

        $key = 'lesson_' . $lessonId;

        $cart[$key] = [
            'type' => 'lesson',
            'id' => $lessonId,
        ];

        $this->session->set('cart', $cart);
    }

    // Recuperation des produits du panier
    public function getCart()
    {
        $cart = $this->session->get('cart', []);
        $items = [];
        $total = 0;

        foreach ($cart as $key => $item) {

            if ($item['type'] === 'cursus') {
                $entity = $this->cursusRepository->find($item['id']);
            } else {
                $entity = $this->lessonRepository->find($item['id']);
            }

            if (!$entity) continue;

            $items[] = [
                'item' => $entity,
                'type' => $item['type'],
                'price' => $entity->getPrice(),
                'key' => $key,
            ];

            $total += $entity->getPrice();
        }

        return ['items' => $items, 'total' => $total];
    }

    // Suppression d'un produit du panier
    public function remove(string $key)
    {
        $cart = $this->session->get('cart', []);
        
        if (isset($cart[$key])) {
            unset($cart[$key]);
        }

        $this->session->set('cart', $cart);
    }
}