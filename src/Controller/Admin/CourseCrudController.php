<?php

namespace App\Controller\Admin;

use App\Entity\Course;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class CourseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Course::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextField::new('shortDesc'),
            TextEditorField::new('description'),

            TextEditorField::new('content')->hideOnIndex()->setLabel('Main Content (Video/Intro)'),

            AssociationField::new('modules')
                ->hideOnIndex()
                ->setLabel('Modules (Lessons)')
                ->setHelp('Manage related Module entities via the Modules CRUD'),

            NumberField::new('price'),
            TextField::new('imageUrl'),
            AssociationField::new('category'),
        ];
    }
}
