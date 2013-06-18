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

//        $builder->add('project', 'entity',
//                       array(  'em' => 'default',
//                                'class' => 'Taskeet\\MainBundle\\Entity\\Project',
//                                'multiple' => false,
//                                'required' => false,
//                                'label' => 'Project',
//                                'help' => NULL,
//                                'translation_domain' => 'TaskeetMainBundle',
//                       ));
//
//        $builder->add('assignedTo', 'entity',
//                      array(  'em' => 'default',
//                          'class' => 'Taskeet\\MainBundle\\Entity\\User',
//                          'multiple' => false,  'required' => false,
//                          'label' => 'Assignedto',
//                          'help' => NULL,
//                          'translation_domain' => 'TaskeetMainBundle',
//                      ));
        $factory = $builder->getFormFactory();

        $builder->add('title', 'text', array(  'required' => true,  'label' => 'Title',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));



        $builder->add('priority', 'entity', array(  'em' => 'default',  'class' => 'Taskeet\\MainBundle\\Entity\\Priority',  'multiple' => false,  'required' => false,  'label' => 'Priority',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));



        $builder->add('status', 'entity', array(  'em' => 'default',  'class' => 'Taskeet\\MainBundle\\Entity\\Status',  'multiple' => false,  'required' => false,  'label' => 'Status',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));



        $builder->add('startDate', 'datepicker', array(  'required' => true,  'label' => 'Startdate',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));



        $builder->add('dueDate', 'datepicker', array(  'required' => true,  'label' => 'Duedate',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));


        $projectSubscriber = new AddProjectFieldSubscriber($factory);
        $builder->addEventSubscriber($projectSubscriber);

        $userSubscriber = new AddUserFieldSubscriber($factory);
        $builder->addEventSubscriber($userSubscriber);


        $builder->add('description', 'textarea', array(  'required' => true,  'label' => 'Description',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));



        $builder->add('files', 'upload', array(  'required' => false,  'nameable' => 'name',  'editable' =>   array(    0 => 'name',    1 => 'description',  ),  'type' =>  new \Taskeet\MainBundle\Form\Type\Media\EditType(),  'maxNumberOfFiles' => 5,  'maxFileSize' => 5000000,  'minFileSize' => 10,  'acceptFileTypes' => '/(\\.|\\/)(gif|jpe?g|png|txt|doc|docx|pdf|xls|ppt|pptx)$/i',  'prependFiles' => false,  'allow_add' => true,  'allow_delete' => true,  'error_bubbling' => false,  'options' =>   array(    'data_class' => 'Taskeet\\MainBundle\\Entity\\Media',  ),  'label' => 'Archivos',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));




//        parent::buildForm($builder, $options);



    }

}
