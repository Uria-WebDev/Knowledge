<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\CursusRepository;

class CartService
{
    private $session;
    private $cursusRepository;

    public function __construct(RequestStack $requestStack, CursusRepository $cursusRepository)
    {
        $this->session = $requestStack->getSession();
        $this->cursusRepository = $cursusRepository;
    }

    // Ajout d'un cursus au panier
    public function add(int $cursusId)
    {
        $cart = $this->session->get('cart', []);

        $key = $cursusId;

        $cart[$key] = [
            'cursus_id' => $cursusId,
        ];

        $this->session->set('cart', $cart);
    }

    // Recuperation des cursus du panier
    public function getCart()
    {
        $cart = $this->session->get('cart', []);
        $items = [];
        $total = 0;

        foreach ($cart as $item) {

            $cursus = $this->cursusRepository->find($item['cursus_id']);

            $items[] = [
                'cursus' => $cursus,
                'price' => $cursus->getPrice(),
            ];

            $total += $cursus->getPrice();
        }

        return ['items' => $items, 'total' => $total];
    }

    // Suppression d'un cursus du panier
    public function remove(string $key)
    {
        $cart = $this->session->get('cart', []);
        
        if (isset($cart[$key])) {
            unset($cart[$key]);
        }

        $this->session->set('cart', $cart);
    }
}