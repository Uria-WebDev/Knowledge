<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    // Route d'ajout d'un produit au panier
    #[Route('/cart/add', name: 'cart_add', methods: ['POST'])]
    public function add(Request $request, CartService $cartService): Response
    {
        $cursusId = $request->request->get('cursus_id');
        $lessonId = $request->request->get('lesson_id');

        $error = null;

        if ($cursusId) {
            $error = $cartService->add((int) $cursusId);
        } elseif ($lessonId) {
            $error = $cartService->addLesson((int) $lessonId);
        } else {
            throw $this->createNotFoundException('Aucun produit fourni');
        }

        if ($error) {
            $this->addFlash('error', $error);
        } else {
            $this->addFlash('success', 'Produit ajouté au panier');
        }

        return $this->redirectToRoute('app_cart');
    }

    // Route de suppression d'un produit du panier
    #[Route('/cart/remove/{key}', name: 'cart_remove', methods: ['POST'])]
    public function remove(string $key, CartService $cartService): Response
    {
        $cartService->remove($key);
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart', name: 'app_cart')]
    public function show(CartService $cartService): Response
    {
        return $this->render('cart/index.html.twig', [
            'cart' => $cartService->getCart()
        ]);
    }
}