<?php

namespace Taskeet\MainBundle\Form\Type\User;

use Admingenerated\TaskeetMainBundle\Form\BaseUserType\EditType as BaseEditType;
use Symfony\Component\Form\FormBuilderInterface;
use JMS\SecurityExtraBundle\Security\Authorization\Expression\Expression;


class EditType extends BaseEditType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
                                                                                      
           $builder->add('firstName', 'text', array(  'required' => false,  'label' => 'Firstname',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        
                                                                                      
           $builder->add('lastName', 'text', array(  'required' => false,  'label' => 'Lastname',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        
                                                                                      
           $builder->add('username', 'text', array(  'required' => true,  'label' => 'Username',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        
                                                                                      
           $builder->add('password', 'repeated', array(  'required' => false,  'first_options' =>   array(    'required' => false, 'label' => 'repeated.label.plainPassword.first',  ),  'second_options' =>   array(    'required' => false, 'label' => 'repeated.label.plainPassword.second',  ),  'type' => 'password',  'label' => 'Password',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        
                                                                                      
           $builder->add('email', 'text', array(  'required' => true,  'label' => 'Email',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        if (false !== $this->securityContext->isGranted(array(new Expression('hasRole("ROLE_ADMIN")')), $builder->getData())) {
                                                                                      
           $builder->add('jefeDpto', 'entity', array(  'em' => 'default',  'class' => 'Taskeet\\MainBundle\\Entity\\Department',  'multiple' => false,  'required' => false,  'label' => 'Jefedpto',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

                }
                                                                                      
           $builder->add('department', 'entity', array(  'em' => 'default',  'class' => 'Taskeet\\MainBundle\\Entity\\Department',  'multiple' => false,  'required' => false,  'label' => 'Department',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        
                                                                                      
           $builder->add('enabled', 'checkbox', array(  'required' => false,  'label' => 'Enabled',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        
                                                                                      
           $builder->add('groups', 'double_list', array(  'em' => 'default',  'class' => 'Taskeet\\MainBundle\\Entity\\Group',  'label' => 'Groups',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        
                                                                                      
           $builder->add('projects', 'double_list', array(  'em' => 'default',  'class' => 'Taskeet\\MainBundle\\Entity\\Project',  'label' => 'Projects',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        
                                                                                      
           $builder->add('tasks', 'double_list', array(  'em' => 'default',  'class' => 'Taskeet\\MainBundle\\Entity\\Ticket',  'label' => 'Tasks',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        
    }
}
