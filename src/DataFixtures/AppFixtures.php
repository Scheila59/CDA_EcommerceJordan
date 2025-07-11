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
                'quantity' => 0,
                'description' => 'Classique intemporel au look iconique, en cuir premium.',
                'image' => 'https://encrypted-tbn2.gstatic.com/shopping?q=tbn:ANd9GcQM7_pzgbZm0yX6e4Q9SqRSrGYu3dVgq5_Ndu-pFrDacZnTETmKC05xZc0T16FLOuentG1Zak5Vy1SBCE019W6LPJDsf1kNf_vv00l35Q78IvUMyLDGuBxM0Oe4S-zfhdrQjbrg3iE&usqp=CAc',
                'type' => $basketType
            ],
            [
                'name' => 'Jordan Training Shorts',
                'price' => 55,
                'quantity' => 45,
                'description' => 'Short d’entraînement léger et respirant avec logo Jordan sur la cuisse.',
                'image' => 'https://encrypted-tbn1.gstatic.com/shopping?q=tbn:ANd9GcRagPabv_FSu7mcY1m9_075eYuGfst6QlBcwX7Qwn7dMorDZcnniGchX7eIRatA-0iDIzNzVU7y3WPmcDQbkHNxox-J-M4XzkAenmx-61vE7X_FieCewfY1D9eLTEDz59Cl6RJpYIZMxr0&usqp=CAc',
                'type' => $vetementType
            ],
            [
                'name' => 'Air Jordan 6 Midnight Navy',
                'price' => 210,
                'quantity' => 20,
                'description' => 'Design sophistiqué en cuir avec détails bleus profonds, amorti Air visible.',
                'image' => 'https://encrypted-tbn0.gstatic.com/shopping?q=tbn:ANd9GcSSfZO2aN4-GnkrX7KY34gY_FJSdUEq6KbcfnBmT_Rb7MAcQ4UQV8XVE_7At6Qj5eYN1TTk2LSgITWWWjw2TyVi2c8mEShjpZafCOuDqk-h2Q2Vini9HlCXJxQU0XbdJc2Vc_da_P9vHA&usqp=CAc',
                'type' => $basketType
            ],
            [
                'name' => 'Air Jordan 4 Bred',
                'price' => 190,
                'quantity' => 30,
                'description' => 'Sneaker culte avec amorti Nike Air et empiècements en mesh.',
                'image' => 'https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcTW5noc4VZOe7GZTQwI1b0KOhgRYq2UB35EOSpt28gj6SWv9Jx7xwMKB-Oltm7aQTFtCnKp7GO0bUK2HwlCe3maRPXrp0DejZk17S45fDsn0O51so71DZUrObg97M87Bu_7sRA&usqp=CAc',
                'type' => $basketType
            ],
            [
                'name' => 'Air Jordan 11 Concord',
                'price' => 220,
                'quantity' => 20,
                'description' => 'Design épuré avec cuir verni et mesh, parfait pour le streetwear.',
                'image' => 'https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcSJwHW-6pLwjZHDQPPhL8ZHMq15bUeK1drJdzIef7-n_075Ur4Q_SWlVGKGnKH47Kt_flBVCv_DmSP4_z5yWQ_afSAenbMIzVCGT1qCsX2vSPEp1jbkb1XBoWv1qi1jAAFZL2bRx7qGOQ&usqp=CAc',
                'type' => $basketType
            ],
            [
                'name' => 'Air Jordan 5 Fire Red',
                'price' => 200,
                'quantity' => 25,
                'description' => 'Silhouette agressive, avec détails réfléchissants et semelle icy.',
                'image' => 'https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcTaywrVKATtknPI5WI34m_Xo1aXSqrpK9bPSrIMIS8VT91gUfLZ0ro2GSX0Bp9W5jhCJmyM8oty22vLeugFycxUmC_kPGT-IntmRm5fGIOcBo-FNNfZPHtNPXuM0XwQmju6fTdKPIU&usqp=CAc',
                'type' => $basketType
            ],
            [
                'name' => 'Air Jordan Hoodie',
                'price' => 90,
                'quantity' => 40,
                'description' => 'Sweat Jordan en coton, logo brodé, ultra confortable.',
                'image' => 'https://encrypted-tbn1.gstatic.com/shopping?q=tbn:ANd9GcTC30jaOnZY8I7wzKsL914AJHTpbHYfzlUwniVijhn_iJSQNvBLfPZ9CJjMmtbGTiLIOcYeojkfGqQ2tdP_lPFaiRWdzJt-AMgFyzU0k2BrJlTBqJhYocmEXJaOm_j-x7xXJgr8seM&usqp=CAc',
                'type' => $vetementType
            ],
            [
                'name' => 'Jordan T-Shirt Classic',
                'price' => 45,
                'quantity' => 60,
                'description' => 'T-shirt blanc avec logo Jumpman, parfait au quotidien.',
                'image' => 'https://encrypted-tbn0.gstatic.com/shopping?q=tbn:ANd9GcTJZAWJSmXuN4H2ovi9-Za60ib4DQwcJh9incoQaR-c8Xuwfc6Yowojl0FKo6tW-Tp-A86ZFLr8N06GoSuPOGFHygdZU-KG4eZHunqkIxVWf22M1cLdujGb_6PlaRzfyl3-lFOiGBSULA&usqp=CAc',
                'type' => $vetementType
            ],
            [
                'name' => 'Jordan Tech Pants',
                'price' => 75,
                'quantity' => 35,
                'description' => 'Pantalon de sport léger et respirant, design moderne.',
                'image' => 'https://encrypted-tbn2.gstatic.com/shopping?q=tbn:ANd9GcTR4WZs3qTTyF2XXIqlq6qki3AQSb6twEByabpFYv7C7lva3dpiMgxpV55vCgzAn2dY2LsZS0MbpdmwY-EV6uTd1MaFiFcLQqfZMWKe6Tp_UcZ0NVeXMoxkXtWoPyX8VVXb9q77sRsGSA&usqp=CAc',
                'type' => $vetementType
            ],
            [
                'name' => 'Air Jordan 3 Black Cement',
                'price' => 180,
                'quantity' => 40,
                'description' => 'Style rétro avec le célèbre motif éléphant print et amorti Air.',
                'image' => 'https://encrypted-tbn1.gstatic.com/shopping?q=tbn:ANd9GcRGMb9SU71JRF-Dr1CXbY6cB-iC6WMUzxRwBy5HG-ARu66-4Yb49gyI7ySoso1To2lb_XDtoaLWzqlF6F-Mk88ycoKr6DPB80_5_StRsuADEC94jhM0HoYG2K9G2ykoP4aN8tfBBecVRg&usqp=CAc',
                'type' => $basketType
            ],
        ];

        // Création des produits
        foreach ($Products as $data) {
            $produit = new Product();
            $produit->setName($data['name']);
            $produit->setPrice($data['price']);
            $produit->setQuantity($data['quantity']);
            $produit->setDescription($data['description']);
            $produit->setImage($data['image']);
            $produit->setTypes($data['type']);
            $manager->persist($produit);
        }

        $manager->flush();
    }
}
