<?php

namespace Taskeet\MainBundle\Form\Type\Event;

use Admingenerated\TaskeetMainBundle\Form\BaseEventType\NewType as BaseNewType;
use Symfony\Component\Form\FormBuilderInterface;

class NewType extends BaseNewType
{
	 public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
                                                                                      
           $builder->add('title', 'text', array(  'required' => true,  'label' => 'Title',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        
                                                                                      
           $builder->add('type', 'entity', array(  'em' => 'default',  'class' => 'Taskeet\\MainBundle\\Entity\\EventCategory',  'multiple' => false,  'required' => false,  'label' => 'Type',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        
                                                                                      
           $builder->add('startDate', 'datepicker', array(  'required' => true,  'label' => 'Startdate',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        
                                                                                      
           $builder->add('dueDate', 'datepicker', array(  'required' => true,  'label' => 'Duedate',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        
                                                                                      
           $builder->add('description', 'textarea', array(  'required' => true,  'label' => 'Description',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

           $builder->add('remind', 'choice', array(
            'choices'   => array(
                'PT300S'       => 'Cinco minutos',
                'PT600S'      => 'Diez minutos',
                'PT900S'      => 'Quince minutos',
                'PT1800S'      => 'Treinta minutos',
                'PT1H'       => 'Una hora',
                'PT2H'       => 'Dos horas',
                'PT4H'       => 'Cuatro horas',
                'PT6H'       => 'Seis horas',
                'PT8H'       => 'Ocho horas',
                'PT10H'      => 'Diez horas',
                'PT12H'      => 'Medio dia',
                'P1D'       => 'Un dia',
                'P2D'       => 'Dos dias',
                'P3D'       => 'Tres dias',
                'P4D'       => 'Cuatro dias',
                'P1W'       => 'Una semana',
                'P2W'       => 'Dos semanas',
            ),
            'mapped' => false,
            'label' => 'Recordar',
            'empty_value' => 'No recordar',
            'empty_data'  => null,
            'required' => false,
        ));

        
    }

}
