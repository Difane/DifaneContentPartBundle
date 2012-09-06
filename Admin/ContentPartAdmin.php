<?php

namespace Difane\Bundle\ContentPartBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;


class ContentPartAdmin extends Admin
{
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('title')
            ->add('contentFormatter')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filterMapper)
    {
        $filterMapper
            ->add('name')
            ->add('title')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('name')
                ->add('title', null, array('required' => false))
            ->with('Content')
                ->add('rawContent', 'textarea', array('required' => false, 'attr'=> array('rows' => 20)))
                ->add('contentFormatter', 'sonata_formatter_type_selector')
            ->end()
        ;
    }
}