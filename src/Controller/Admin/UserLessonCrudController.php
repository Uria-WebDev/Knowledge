<?php

namespace App\Controller\Admin;

use App\Entity\UserLesson;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

// Crud User_Lesson
class UserLessonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserLesson::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('user'),

            AssociationField::new('lesson'),

            BooleanField::new('isValidated'),

            DateTimeField::new('validatedAt')
                ->hideOnForm(),
        ];
    }
}
