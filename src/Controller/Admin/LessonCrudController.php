<?php

namespace App\Controller\Admin;

use App\Entity\Lesson;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

// Crud Lesson
class LessonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Lesson::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),

            TextareaField::new('text')
                ->hideOnIndex(),

            MoneyField::new('price')
                ->setCurrency('EUR')
                ->setStoredAsCents(false),

            AssociationField::new('cursus')
                ->setFormTypeOption('by_reference', false),

            AssociationField::new('users')
                ->onlyOnIndex(),
        ];
    }
}