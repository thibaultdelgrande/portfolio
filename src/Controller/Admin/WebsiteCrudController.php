<?php

namespace App\Controller\Admin;

use App\Entity\Website;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class WebsiteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Website::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('project', 'Project')
            ->renderAsEmbeddedForm(ProjectCrudController::class )
            ->addCssFiles(Asset::fromEasyAdminAssetPackage('field-text-editor.css')->onlyOnForms())
            ->addJsFiles(Asset::fromEasyAdminAssetPackage('field-text-editor.js')->onlyOnForms())
            ->addJsFiles(Asset::fromEasyAdminAssetPackage('field-collection.js')->onlyOnForms()),
            UrlField::new('url', 'Url')
        ];
    }
}
