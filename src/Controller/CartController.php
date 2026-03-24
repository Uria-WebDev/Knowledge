<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CursusRepository;
use App\Repository\LessonRepository;
use Symfony\Bundle\SecurityBundle\Security;

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

    // Route de vérification de payement
    #[Route('/checkout', name: 'app_checkout')]
    public function checkout(CartService $cart): RedirectResponse
    {
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

        $cartData = $cart->getCart();
        $lineItems = [];

        foreach ($cartData['items'] as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item['item']->getName(),
                    ],
                    'unit_amount' => $item['item']->getPrice() * 100,
                ],
                'quantity' => 1,
            ];
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => 'http://localhost:8000/success',
            'cancel_url' => 'http://localhost:8000/cancel',
        ]);

        return new RedirectResponse($session->url);
    }

    // Route de validation de payement
    #[Route('/success', name: 'payment_success')]
    public function success(
        CartService $cartService,
        EntityManagerInterface $em,
        Security $security,
        CursusRepository $cursusRepository,
        LessonRepository $lessonRepository
    ): Response {
        $user = $security->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException();
        }

        $cart = $cartService->getCart();

        foreach ($cart['items'] as $item) {

            if ($item['type'] === 'cursus') {
                $cursus = $cursusRepository->find($item['item']->getId());

                if ($cursus) {
                    $user->addCursusBought($cursus);
                }
            }

            if ($item['type'] === 'lesson') {
                $lesson = $lessonRepository->find($item['item']->getId());

                if ($lesson) {
                    $user->addLessonBought($lesson);
                }
            }
        }

        $em->persist($user);
        $em->flush();

        // vider le panier
        $cartService->clear();

        return $this->render('payment/success.html.twig');
    }

    // Route d'annulation de payement
    #[Route('/cancel', name: 'payment_cancel')]
    public function cancel()
    {
        return $this->render('payment/cancel.html.twig');
    }
}