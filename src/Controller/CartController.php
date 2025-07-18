<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Product;
use App\Entity\CartItem;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
  #[Route('/cart/add/{id}', name: 'cart_add')]
  #[IsGranted('IS_AUTHENTICATED_FULLY')]
  public function add($id, EntityManagerInterface $em)
  {
    $user = $this->getUser();
    // Trouver un panier existatn ou le créer :
    $cart = $em->getRepository(Cart::class)->findOneBy(
      [
        'customer' => $user,
        'status' => 'en_cours'
      ]
    );
    if (!$cart) {
      $cart = new Cart();
      $cart->setCustomer($user);
      $cart->setStatus('en_cours');
      $cart->SetCreatedAt(new \DateTimeImmutable());
      $cart->setUpdatedAt(new \DateTimeImmutable());
      $em->persist($cart);
    } else {
      $cart->setUpdatedAt(new \DateTimeImmutable());
    }
    // Vérifier le produit
    $product = $em->getRepository(Product::class)->find($id);
    if (!$product || $product->getQuantity() <= 0) {
      $this->addFlash('error', 'Produit indisponible, le stock est insuffisant.');
      return $this->redirectToRoute('app_product_catalog');
    }
    // ajouter le cartItem
    $cartItem = $em->getRepository(CartItem::class)->findOneBy(
      [
        'cart' => $cart,
        'product' => $product
      ]
    );
    if ($cartItem) {
      $cartItem->setQuantity($cartItem->getQuantity() + 1);
    } else {
      $cartItem = new CartItem();
      $cartItem->setCart($cart);
      $cartItem->setProduct($product);
      $cartItem->setQuantity(1);
      $em->persist($cartItem);
    }

    // Mettre à jour le stock du produit
    $product->setQuantity($product->getQuantity() - 1);

    $em->flush();

    $this->addFlash('success', 'Produit ajouté au panier !');
    return $this->redirectToRoute('app_product_catalog');
  }

  #[Route('/cart', name: 'cart_view')]
  public function view(EntityManagerInterface $em): Response
  {
    $user = $this->getUser();
    $cart = $em->getRepository(Cart::class)->findOneBy([
      'customer' => $user,
      'status' => 'en_cours'
    ]);
    $cartData = [];
    $total = 0;

    if ($cart) {
      foreach ($cart->getCartItems() as $cartItem) {
        $product = $cartItem->getProduct();
        $quantity = $cartItem->getQuantity();
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
  public function remove($id, EntityManagerInterface $em): Response
  {
    $user = $this->getUser();
    $cart = $em->getRepository(Cart::class)->findOneBy([
      'customer' => $user,
      'status' => 'en_cours'
    ]);

    if ($cart) {
      $cartItem = $em->getRepository(CartItem::class)->findOneBy([
        'cart' => $cart,
        'product' => $em->getRepository(Product::class)->find($id)
      ]);

      if ($cartItem) {
        if ($cartItem->getQuantity() > 1) {
          $cartItem->setQuantity($cartItem->getQuantity() - 1);
        } else {
          $em->remove($cartItem);
        }
        $product = $cartItem->getProduct();
        $product->setQuantity($product->getQuantity() + 1);
        $em->flush();
        $this->addFlash('success', 'Article retiré du panier.');
      }
    }

    return $this->redirectToRoute('cart_view');
  }

  #[Route('/cart/clear', name: 'cart_clear')]
  public function clear(EntityManagerInterface $em): Response
  {
    $user = $this->getUser();
    $cart = $em->getRepository(Cart::class)->findOneBy([
      'customer' => $user,
      'status' => 'en_cours'
    ]);

    if ($cart) {
      foreach ($cart->getCartItems() as $cartItem) {
        $em->remove($cartItem);
      }
      $em->flush();
      $this->addFlash('success', 'Le panier a été vidé.');
    }

    return $this->redirectToRoute('cart_view');
  }
}