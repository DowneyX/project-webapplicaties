<?php

namespace App\Controller\Admin;

use App\Entity\SubscriptionType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SubscriptionTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SubscriptionType::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
