<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use App\Form\AlbumSongType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;

class AlbumCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Album::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('project', 'Project')
                ->renderAsEmbeddedForm(ProjectCrudController::class)
                ->addCssFiles(Asset::fromEasyAdminAssetPackage('field-text-editor.css')->onlyOnForms())
                ->addJsFiles(Asset::fromEasyAdminAssetPackage('field-text-editor.js')->onlyOnForms())
                ->addJsFiles(Asset::fromEasyAdminAssetPackage('field-collection.js')->onlyOnForms()),
            BooleanField::new('single', 'Single'),
            CollectionField::new('songs', 'Songs')
                ->setEntryType(AlbumSongType::class)
        ];
    }
}
