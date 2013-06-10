<?php

namespace Taskeet\MainBundle\Form\Type\User;

use Admingenerated\TaskeetMainBundle\Form\BaseUserType\EditType as BaseEditType;
use Symfony\Component\Form\FormBuilderInterface;


class EditType extends BaseEditType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


           $builder->add('firstName', 'text', array(  'required' => false,  'label' => 'Firstname',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));



           $builder->add('lastName', 'text', array(  'required' => false,  'label' => 'Lastname',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));



           $builder->add('username', 'text', array(  'required' => true,  'label' => 'Username',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));



           $builder->add('password', 'repeated', array(  'required' => false,  'first_options' =>   array(    'label' => 'repeated.label.plainPassword.first',  ),  'second_options' =>   array(    'label' => 'repeated.label.plainPassword.second',  ),  'type' => 'password',  'label' => 'Password',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));



           $builder->add('email', 'text', array(  'required' => true,  'label' => 'Email',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));



           $builder->add('departments', 'double_list', array(  'em' => 'default',  'class' => 'Taskeet\\MainBundle\\Entity\\Department',  'label' => 'Departments',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));



           $builder->add('enabled', 'checkbox', array(  'required' => false,  'label' => 'Enabled',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));



           // $builder->add('expired', 'checkbox', array(  'required' => false,  'label' => 'Expired',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));



           // $builder->add('expiresAt', 'datepicker', array(  'required' => false,  'label' => 'Expiresat',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));



           // $builder->add('roles', 'collection', array(  'allow_add' => true,  'allow_delete' => true,  'by_reference' => true,  'widget' => 'table',  'label' => 'Roles',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));



           $builder->add('groups', 'double_list', array(  'em' => 'default',  'class' => 'Taskeet\\MainBundle\\Entity\\Group',  'label' => 'Groups',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));


           $builder->add('projects', 'double_list', array(  'em' => 'default',  'class' => 'Taskeet\\MainBundle\\Entity\\Project',  'label' => 'Projects',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));



           $builder->add('tasks', 'double_list', array(  'em' => 'default',  'class' => 'Taskeet\\MainBundle\\Entity\\Ticket',  'label' => 'Tasks',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));


    }
}
