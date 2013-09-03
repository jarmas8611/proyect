<?php

namespace Taskeet\MainBundle\Form\Type\Ticket;

use Admingenerated\TaskeetMainBundle\Form\BaseTicketType\NewType as BaseNewType;
use Symfony\Component\Form\FormBuilderInterface;
use Taskeet\MainBundle\EventListener\AddProjectFieldSubscriber;
use Taskeet\MainBundle\EventListener\AddUserFieldSubscriber;

class NewType extends BaseNewType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $factory = $builder->getFormFactory();

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


//        $projectSubscriber = new AddProjectFieldSubscriber($factory);
//        $builder->addEventSubscriber($projectSubscriber);

        $userSubscriber = new AddUserFieldSubscriber($factory, $this->securityContext);
        $builder->addEventSubscriber($userSubscriber);


        $builder->add('description', 'textarea', array(  'required' => true,  
                                                        'label' => 'Description',
                                                        'attr' => array('class' => 'span6', 'rows' => 10),  
                                                        'help' => NULL,  
                                                        'translation_domain' => 'TaskeetMainBundle',));



        $builder->add('files', 'upload', array(  'required' => false,  'nameable' => 'name',  'editable' =>   array(    0 => 'name',    1 => 'description',  ),  'type' =>  new \Taskeet\MainBundle\Form\Type\Media\EditType(),  'maxNumberOfFiles' => 5,  'maxFileSize' => 5000000,  'minFileSize' => 10,  'acceptFileTypes' => '/(\\.|\\/)(gif|jpe?g|png|txt|doc|docx|pdf|xls|ppt|pptx)$/i',  'prependFiles' => false,  'allow_add' => true,  'allow_delete' => true,  'error_bubbling' => false,  'options' =>   array(    'data_class' => 'Taskeet\\MainBundle\\Entity\\Media',  ),  'label' => 'Archivos',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));



        $builder->add('repeat', 'choice', array(
            'choices' => array(
                null => 'Solo este día',
                'P1D' => 'Repetir diariamente',
                'P1W'    => 'Repetir semanalmente',
                'P1M'   => 'Repetir mensualmente',
                'P1A'  =>  'Repetir anualmente',
            ),
            'required' => false,
            'label' => 'Repeat',
            'help' => NULL,
            'translation_domain' => 'TaskeetMainBundle',
            'mapped'    => false,
        ));

//        $builder->add('frequency', 'text', array(
//            'required' => false,
//            'label' => 'Frequency',
//            'help' => NULL,
//            'translation_domain' => 'TaskeetMainBundle',
//            'mapped'    => false,
//        ));



    }

}
