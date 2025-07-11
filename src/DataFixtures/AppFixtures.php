<?php

namespace App\DataFixtures;

use App\Entity\Type;
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // ajout des 2 types "basket et vêtement"
        $basketType = new Type();
        $basketType->setLabel('basket');
        $manager->persist($basketType);

        $vetementType = new Type();
        $vetementType->setLabel('vêtement');
        $manager->persist($vetementType);

        // Liste des produits ficitfs 
        $Products = [
            [
                'name' => 'Air Jordan 1 Retro High OG', 
                'price' => 170, 
                'quantity' => 50, 
                'description' => 'Classique intemporel au look iconique, en cuir premium.', 
                'image' => '', 
                'type' => $basketType],
            [
                'name' => 'Jordan Training Shorts', 
                'price' => 55, 
                'quantity' => 45, 
                'description' => 'Short d’entraînement léger et respirant avec logo Jordan sur la cuisse.', 
                'image' => '', 
                'type' => $vetementType],
            [
                'name' => 'Air Jordan 6 Midnight Navy', 
                'price' => 210, 
                'quantity' => 20, 
                'description' => 'Design sophistiqué en cuir avec détails bleus profonds, amorti Air visible.', 
                'image' => '', 
                'type' => $basketType],
            [
                'name' => 'Air Jordan 4 Bred', 
                'price' => 190, 
                'quantity' => 30, 
                'description' => 'Sneaker culte avec amorti Nike Air et empiècements en mesh.', 
                'image' => '', 
                'type' => $basketType],
            [
                'name' => 'Air Jordan 11 Concord', 
                'price' => 220, 
                'quantity' => 20, 
                'description' => 'Design épuré avec cuir verni et mesh, parfait pour le streetwear.', 
                'image' => '', 
                'type' => $basketType],
            [
                'name' => 'Air Jordan 5 Fire Red', 
                'price' => 200, 
                'quantity' => 25, 
                'description' => 'Silhouette agressive, avec détails réfléchissants et semelle icy.', 
                'image' => '', 
                'type' => $basketType],
            [
                'name' => 'Air Jordan Hoodie', 
                'price' => 90, 
                'quantity' => 40, 
                'description' => 'Sweat Jordan en coton, logo brodé, ultra confortable.', 
                'image' => '', 
                'type' => $vetementType],
            [
                'name' => 'Jordan T-Shirt Classic', 
                'price' => 45, 
                'quantity' => 60, 
                'description' => 'T-shirt blanc avec logo Jumpman, parfait au quotidien.', 
                'image' => '', 
                'type' => $vetementType],
            [
                'name' => 'Jordan Tech Pants', 
                'price' => 75, 
                'quantity' => 35, 
                'description' => 'Pantalon de sport léger et respirant, design moderne.', 
                'image' => '', 
                'type' => $vetementType],
            [
                'name' => 'Air Jordan 3 Black Cement', 
                'price' => 180, 
                'quantity' => 40, 
                'description' => 'Style rétro avec le célèbre motif éléphant print et amorti Air.', 
                'image' => '', 
                'type' => $basketType],
        ];

        // Création des produits
        foreach ($Products as $data) {
            $produit = new Product();
            $produit->setName($data['name']);
            $produit->setPrice($data['price']);
            $produit->setQuantity($data['quantity']);
            $produit->setDescription($data['description']);
            $produit->setImage($data['image']);
            $produit->setType($data['type']);
            $manager->persist($produit);
        }

        $manager->flush();
    }
}