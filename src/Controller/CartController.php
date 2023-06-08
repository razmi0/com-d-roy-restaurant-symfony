<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/mon-panier', name: 'cart')]

    public function index(Cart $cart): Response
    {
        $cartComplete = [];

        foreach ($cart->get() as $id => $quantity) {
            $cartComplete[] = [
                'item' => $this->entityManager->getRepository(Item::class)->findOneById($id),
                'quantity' => $quantity
            ];
        }

        return $this->render('cart/index.html.twig', [
           'cart'=> $cartComplete
            ]);
    }

    #[Route('/cart/add/{id}', name: 'add_to_cart')]

    public function add(Cart $cart, $id): Response
    {
        $cart->add($id);

        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/remove/{id}', name: 'remove_to_cart')]

    public function remove(Cart $cart): Response
    {
        $cart->remove();

        return $this->redirectToRoute('app_item_index');
    }

    #[Route('/cart/delete/{id}', name: 'delete_to_cart')]

    public function delete(Cart $cart, $id): Response
    {
        $cart->delete($id);

        return $this->redirectToRoute('cart');
    }


    #[Route('/cart/decrease/{id}', name: 'decrease_to_cart')]

    public function decrease(Cart $cart, $id): Response
    {
        $cart->decrease($id);

        return $this->redirectToRoute('cart');
    }

}
