<?php

namespace Taskeet\MainBundle\Form\Type\Ticket;

use Admingenerated\TaskeetMainBundle\Form\BaseTicketType\NewType as BaseNewType;
use Symfony\Component\Form\FormBuilderInterface;
use Taskeet\MainBundle\EventListener\AddDepartmentFieldSubscriber;
use Taskeet\MainBundle\EventListener\AddUserFieldSubscriber;
use Taskeet\MainBundle\EventListener\AddFollowersFieldSubscriber;

class NewType extends BaseNewType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $factory = $builder->getFormFactory();                   

        $builder->add('title', 'text', array(  'required' => true,  
                                               'label' => 'Title',
                                               'attr' => array('class' => 'span6'),   
                                               'help' => NULL,  
                                               'translation_domain' => 'TaskeetMainBundle',));

        $departmentSubscriber = new AddDepartmentFieldSubscriber($factory);
        $builder->addEventSubscriber($departmentSubscriber);

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
            'label' => 'Remind',
            'empty_value' => 'No avisar',
            'empty_data'  => null,
            'required' => false,
            'translation_domain' => 'TaskeetMainBundle',
        ));

        
        // $projectSubscriber = new AddProjectFieldSubscriber($factory);
        // $builder->addEventSubscriber($projectSubscriber);

        $userSubscriber = new AddUserFieldSubscriber($factory, $this->securityContext);
        $builder->addEventSubscriber($userSubscriber);


        $builder->add('description', 'textarea', array(  'required' => true,  
                                                        'label' => 'Description',
                                                        'attr' => array('class' => 'span6', 'rows' => 10),  
                                                        'help' => NULL,  
                                                        'translation_domain' => 'TaskeetMainBundle',));



        $builder->add('files', 'upload', array(  'required' => false,  'nameable' => 'name',  'editable' =>   array(    0 => 'name',    1 => 'description',  ),  'type' =>  new \Taskeet\MainBundle\Form\Type\Media\EditType(),  'maxNumberOfFiles' => 5,  'maxFileSize' => 16384,  'minFileSize' => 10,  'acceptFileTypes' => '/(\\.|\\/)(gif|jpe?g|png|txt|doc|docx|pdf|xls|ppt|pptx)$/i',  'prependFiles' => false,  'allow_add' => true,  'allow_delete' => true,  'error_bubbling' => false, 'options' =>   array(    'data_class' => 'Taskeet\\MainBundle\\Entity\\Media',  ),  'label' => 'Adjuntos',  'help' => 'Tamaño máximo permitido: 16 MB',  'translation_domain' => 'TaskeetMainBundle',));



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

        $builder->add('ocurrences', 'text', array(
            'required' => false,
            'label' => 'Ocurrences',
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

        $followersSubscriber = new AddFollowersFieldSubscriber($factory, $this->securityContext);
        $builder->addEventSubscriber($followersSubscriber);

        $builder->add('startDate', 'datetime', array(  
            'required' => true,  
            'label' => 'Startdate', 
            'help' => NULL,  
            'translation_domain' => 'TaskeetMainBundle', 
            'widget' => 'single_text',
            'attr' => array('class' => 'dtpicker'),
        ));

        $builder->add('dueDate', 'datetime', array(  
            'required' => true,  
            'label' => 'Duedate',  
            'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',
            'widget' => 'single_text',
            'attr' => array('class' => 'dtpicker'),
        )); 

        $builder->add('priority', 'entity', array(  'required' => true, 'em' => 'default',  'class' => 'Taskeet\\MainBundle\\Entity\\Priority',  'multiple' => false,  'label' => 'Priority',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));
                                                                              
        $builder->add('status', 'entity', array(  'required' => true, 'em' => 'default',  'class' => 'Taskeet\\MainBundle\\Entity\\Status',  'multiple' => false,   'label' => 'Status',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

    }

}
