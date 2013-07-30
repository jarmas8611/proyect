<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rafix
 * Date: 13/06/13
 * Time: 16:01
 * To change this template use File | Settings | File Templates.
 */

namespace Taskeet\MainBundle\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;

class AddReminderFieldSubscriber implements EventSubscriberInterface
{


    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',            
        );
    }

    
    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data->getReminder()) {
            $form->add('reminder', 'choice', array(
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
        else {

            // $fecha = $data->getStartDate()->diff($data->getReminder());

            // $form->add('remind', 'choice', array(
            //     'choices'   => array(
            //         'PT300S'       => 'Cinco minutos',
            //         'PT600S'      => 'Diez minutos',
            //         'PT900S'      => 'Quince minutos',
            //         'PT1800S'      => 'Treinta minutos',
            //         'PT1H'       => 'Una hora',
            //         'PT2H'       => 'Dos horas',
            //         'PT4H'       => 'Cuatro horas',
            //         'PT6H'       => 'Seis horas',
            //         'PT8H'       => 'Ocho horas',
            //         'PT10H'      => 'Diez horas',
            //         'PT12H'      => 'Medio dia',
            //         'P1D'       => 'Un dia',
            //         'P2D'       => 'Dos dias',
            //         'P3D'       => 'Tres dias',
            //         'P4D'       => 'Cuatro dias',
            //         'P1W'       => 'Una semana',
            //         'P2W'       => 'Dos semanas',
            //     ),
            //     'mapped' => false,
            //     'label' => 'Recordar',
            //     'preferred_choices' => array($fecha),
            //     'empty_value' => 'No recordar',
            //     'empty_data'  => null,
            //     'required' => false,
            // )); 
            $form->add('reminder', 'datepicker', array(  'required' => false,  'label' => 'Reminder',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));       
        }

    }

    
}