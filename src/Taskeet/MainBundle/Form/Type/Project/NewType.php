<?php

namespace Taskeet\MainBundle\Form\Type\Project;

use Admingenerated\TaskeetMainBundle\Form\BaseProjectType\NewType as BaseNewType;
use Symfony\Component\Form\FormBuilderInterface;

class NewType extends BaseNewType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('name', 'text', array(  'required' => true,  'label' => 'Name', 'attr' => array('class' => 'span6'), 'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));
        $builder->add('description', 'textarea', array(  'required' => true,  'label' => 'Description', 'attr' => array('class' => 'span6', 'rows' => 10), 'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));
    }
}
