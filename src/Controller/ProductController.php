<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
  #[Route('/produits', name: 'app_product_catalog')]
  public function catalog(
    Request $request,
    ProductRepository $productRepository,
    TypeRepository $typeRepository
  ): Response {
    $typeId = $request->query->getInt('type', 0);

    $products = $typeId > 0
      ? $productRepository->findByType($typeId)
      : $productRepository->findAll();

    $types = $typeRepository->findAll();

    return $this->render('product/catalog.html.twig', [
      'products' => $products,
      'types' => $types,
      'selectedType' => $typeId,
    ]);
  }

  #[Route('/produit/{id}', name: 'product_details')]
  public function details(int $id, ProductRepository $productRepository): Response
  {
    $product = $productRepository->find($id);

    if (!$product) {
      throw $this->createNotFoundException('Produit non trouvé');
    }

    return $this->render('product/details.html.twig', [
      'product' => $product,
    ]);
  }
}
