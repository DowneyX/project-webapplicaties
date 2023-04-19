<?php

namespace App\Controller\Admin;

use App\Entity\Contract;
use App\Entity\Subscription;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[isGranted("ROLE_ADMINISTRATIVE_USER")]
class UserCrudController extends AbstractCrudController
{
    public function __construct(
        private Security $security
    )
    {
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        if($this->security->isGranted('ROLE_ADMIN')) {
            return [
                TextField::new('username'),
                TextField::new('password')->setFormType(PasswordType::class)->hideOnIndex()->hideWhenUpdating(),
                EmailField::new('email'),
                ArrayField::new('roles'),
                AssociationField::new('subscriptions', "Subscriptions"),
                AssociationField::new('contracts', "Contracts"),
                BooleanField::new('is_verified')
            ];
        } else {
            return [
                TextField::new('username'),
                AssociationField::new('subscriptions', "Subscriptions"),
                AssociationField::new('contracts', "Contracts"),
            ];
        }
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::NEW, "ROLE_ADMIN");
    }
}
