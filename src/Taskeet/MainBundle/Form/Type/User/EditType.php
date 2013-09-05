<?php

namespace Taskeet\MainBundle\Form\Type\User;

use Admingenerated\TaskeetMainBundle\Form\BaseUserType\EditType as BaseEditType;
use Symfony\Component\Form\FormBuilderInterface;
use JMS\SecurityExtraBundle\Security\Authorization\Expression\Expression;


class EditType extends BaseEditType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
                                             
       	$builder->add('password', 'repeated', array(  'mapped' => false, 'required' => false,  'first_options' =>   array(    'label' => 'repeated.label.plainPassword.first',  ),  'second_options' =>   array(    'label' => 'repeated.label.plainPassword.second',  ),  'type' => 'password',  'label' => 'Password',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

    }
}
