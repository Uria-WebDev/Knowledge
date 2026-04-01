<?php

namespace App\Controller\Admin;

use App\Entity\Cursus;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class CursusCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cursus::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('price'),

            AssociationField::new('themes'),
            AssociationField::new('lessons'),
            AssociationField::new('users'),
        ];
    }
}
