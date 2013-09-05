<?php

namespace Taskeet\MainBundle\Form\Type\User;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
        ;

        parent::buildForm($builder, $options);
    }

    public function getName()
    {
        return 'taskeet_main_profile';
    }
}
