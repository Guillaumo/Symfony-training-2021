<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInSingular('un commentaire')
        ->setEntityLabelInPlural('Les commentaires par conférence')
        ->setSearchFields(['author','text','email'])
        ->setDefaultSort(['createdAt' => 'DESC']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
        ->add(EntityFilter::new('conference'));
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('conference','conférence');
        yield TextField::new('author','auteur');
        yield EmailField::new('email');
        yield TextEditorField::new('text','message')
        ->hideOnIndex();
        yield BooleanField::new('validated','A approuver');

        $createdAt = DateTimeField::new('createdAt')->setFormTypeOptions([
            'html5' => true,
            'years' => range(date('Y'),date('Y')+2),
            'widget' => 'single_text',
        ]);

        if(Crud::PAGE_EDIT === $pageName)
        {
            yield $createdAt->setFormTypeOption('disabled',true);
        }
        else
        {
            yield $createdAt;
        }
        // return [
        //     IdField::new('id'),
        //     TextField::new('title'),
        //     TextEditorField::new('description'),
        // ];
    }
    
}
