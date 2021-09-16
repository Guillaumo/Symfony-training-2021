<?php

namespace App\Controller\Admin;

use App\Entity\Speaker;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class SpeakerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Speaker::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInSingular('Un Conférencier')
        ->setEntityLabelInPlural('Les conférenciers')
        ->setSearchFields(['name']);
    }

    public function configureFields(string $pageName): iterable
    {
        
        yield ImageField::new('image')
        ->setBasePath('uploads/')
        ->setUploadDir('public/uploads/')
        ->setFormType(FileUploadType::class);
        yield TextField::new('name', 'nom');
        yield TextField::new('surname', 'prénom');
        yield TextEditorField::new('bio')
        ->hideOnIndex();
    }



}