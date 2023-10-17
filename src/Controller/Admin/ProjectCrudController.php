<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Form\ProjectLinkType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use Vich\UploaderBundle\Form\Type\VichImageType;


class ProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextEditorField::new('description'),
            DateField::new('releaseDate'),
            Field::new('logo')
                ->setFormType(VichImageType::class) // Utilisez le bon type de formulaire VichUploader
                ->setLabel('Image'),
            CollectionField::new('projectLinks')
                ->setEntryType(ProjectLinkType::class),
        ];
    }
}
