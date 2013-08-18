<?php

namespace Taskeet\MainBundle\Form\Type\Event;

use Admingenerated\TaskeetMainBundle\Form\BaseEventType\EditType as BaseEditType;
use Symfony\Component\Form\FormBuilderInterface;
use Taskeet\MainBundle\EventListener\AddReminderFieldSubscriber;

class EditType extends BaseEditType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
                                                                                      
           $builder->add('title', 'text', array(  'required' => true,  'label' => 'Title',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        
                                                                                      
           $builder->add('type', 'entity', array(  'em' => 'default',  'class' => 'Taskeet\\MainBundle\\Entity\\EventCategory',  'multiple' => false,  'required' => false,  'label' => 'Type',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        
                                                                                      
           $builder->add('startDate', 'datepicker', array(  'required' => true,  'label' => 'Startdate',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        
                                                                                      
           $builder->add('dueDate', 'datepicker', array(  'required' => true,  'label' => 'Duedate',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        
                                                                                      
           $builder->add('description', 'textarea', array(  'required' => true,  'label' => 'Description',  'attr' => array('class' => 'span6', 'rows' => 10), 'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

           $builder->addEventSubscriber(new AddReminderFieldSubscriber());

        
    }
}
