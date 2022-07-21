<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use SebastianBergmann\CodeCoverage\Report\Text;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
    	return [
    		TextField::new('name'),
			ImageField::new('illustration')
				->setUploadDir('public/uploads/images/products')
				->setBasePath('uploads/images/products')
				->setFormTypeOptions(['required' => false])
				->setUploadedFileNamePattern('[contenthash].[extension]'),
			TextField::new('subtitle'),
			TextareaField::new('description'),
			MoneyField::new('price')->setCurrency('EUR'),
			AssociationField::new('category')
		];
    }
}
