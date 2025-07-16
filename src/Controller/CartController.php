<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class CartController extends AbstractController
{
  #[Route('/cart/add/{id}', name: 'cart_add')]
  public function add($id, SessionInterface $session, EntityManagerInterface $em): RedirectResponse
  {
    $cart = $session->get('cart', []);

    // Vérifier le stock
    $product = $em->getRepository(Product::class)->find($id);
    if (!$product) {
      $this->addFlash('error', 'Produit introuvable.');
      return $this->redirectToRoute('product_catalog');
    }
    if ($product->getQuantity() <= 0) {
      $this->addFlash('error', 'Stock insuffisant.');
      return $this->redirectToRoute('product_catalog');
    }

    // Incrémentation dans le panier
    if (!empty($cart[$id])) {
      $cart[$id]++;
    } else {
      $cart[$id] = 1;
    }

    // Retirer du stock
    $product->setQuantity($product->getQuantity() - 1);
    $em->flush();

    $session->set('cart', $cart);
    $this->addFlash('success', 'Produit ajouté au panier !');
    return $this->redirectToRoute('app_product_catalog');
  }

  #[Route('/cart', name: 'cart_view')]
  public function view(SessionInterface $session, EntityManagerInterface $em): Response
  {
    $cart = $session->get('cart', []);
    $cartData = [];
    $total = 0;

    foreach ($cart as $id => $quantity) {
      $product = $em->getRepository(Product::class)->find($id);
      if ($product) {
        $cartData[] = [
          'product' => $product,
          'quantity' => $quantity,
          'total' => $product->getPrice() * $quantity,
        ];
        $total += $product->getPrice() * $quantity;
      }
    }

    return $this->render('cart/view.html.twig', [
      'cart' => $cartData,
      'total' => $total,
    ]);
  }

  #[Route('/cart/remove/{id}', name: 'cart_remove')]
  public function remove($id, SessionInterface $session, EntityManagerInterface $em): Response
  {
    $cart = $session->get('cart', []);

    if (!empty($cart[$id])) {
      // Récupérer le produit pour remettre le stock
      $product = $em->getRepository(Product::class)->find($id);
      if ($product) {
        $product->setQuantity($product->getQuantity() + 1);
        $em->flush();
      }

      // Décrémenter la quantité ou supprimer l'article
      if ($cart[$id] > 1) {
        $cart[$id]--;
      } else {
        unset($cart[$id]);
      }
      $session->set('cart', $cart);
      $this->addFlash('success', 'Article retiré du panier.');
    }

    return $this->redirectToRoute('cart_view');
  }

  #[Route('/cart/clear', name: 'cart_clear')]
  public function clear(SessionInterface $session): Response
  {
    $session->remove('cart');
    $this->addFlash('success', 'Le panier a été vidé.');
    return $this->redirectToRoute('cart_view');
  }
}