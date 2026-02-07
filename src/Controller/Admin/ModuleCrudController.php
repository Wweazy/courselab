<?php

namespace App\Controller\Admin;

use App\Entity\Module;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ModuleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Module::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title')->setLabel('Module title'),
            TextField::new('videoUrl')
                ->setLabel('Video URL (YouTube/Vimeo)')
                ->setHelp('Wklej pełny link do filmu, np. https://www.youtube.com/watch?v=XXXX'),
            TextEditorField::new('content')->setLabel('Lesson text'),
            NumberField::new('position')->setLabel('Order'),
            AssociationField::new('course')->setLabel('Course'),
        ];
    }
}
