<?php

namespace App\Controller\Admin;

use App\Entity\Conference;
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


class ConferenceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Conference::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInSingular('Une Conférence')
        ->setEntityLabelInPlural('Les conférences')
        ->setDefaultSort(['year' => 'DESC']);
    }


    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('speaker', 'conférencier');
        yield ImageField::new('image')
        ->setBasePath('uploads/')
        ->setUploadDir('public/uploads/')
        ->setFormType(FileUploadType::class);
        yield TextField::new('title','intitulé');
        yield TextField::new('city','ville');
        yield TextEditorField::new('description')
        ->hideOnIndex();
        yield BooleanField::new('isInternational','international');
        yield DateTimeField::new('year','date')
        ->setFormTypeOptions([
            'html5' => true,
            'years' => range(date('Y'),date('Y')+2),
            'widget' => 'single_text',
        ]);




        // return [
        //     IdField::new('id'),
        //     TextField::new('title'),
        //     TextEditorField::new('description'),
        // ];
    }
    
}
