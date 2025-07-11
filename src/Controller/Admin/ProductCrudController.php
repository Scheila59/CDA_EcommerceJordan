<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            MoneyField::new('price')
                ->setCurrency('EUR')
                ->setNumDecimals(2)
                ->setStoredAsCents(false)
                ->setLabel('Prix')
                ->setHelp('Prix du produit en euros'),
            IntegerField::new('quantity'),
            TextEditorField::new('description'),
            ImageField::new('image')
                ->setUploadDir('public/images/products')
                ->setBasePath('images/products')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false)
                ->setLabel('Image du produit')
                ->setHelp('Téléchargez une image pour le produit (formats acceptés : jpg, png, gif)'),
            AssociationField::new('types')
                ->setLabel('Type de Produit')
                ->setHelp('Sélectionnez le type de produit'),
        ];
    }
}
