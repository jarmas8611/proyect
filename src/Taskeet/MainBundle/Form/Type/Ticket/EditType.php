<?php

namespace Taskeet\MainBundle\Form\Type\Ticket;

use Admingenerated\TaskeetMainBundle\Form\BaseTicketType\EditType as BaseEditType;
use Symfony\Component\Form\FormBuilderInterface;
use JMS\SecurityExtraBundle\Security\Authorization\Expression\Expression;
use Taskeet\MainBundle\EventListener\AddDepartmentFieldSubscriber;
use Taskeet\MainBundle\EventListener\AddUserFieldSubscriber;
use Taskeet\MainBundle\EventListener\AddReminderFieldSubscriber;
use Taskeet\MainBundle\EventListener\AddFollowersFieldSubscriber;

class EditType extends BaseEditType
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

        $builder->addEventSubscriber(new AddReminderFieldSubscriber());
        

        $userSubscriber = new AddUserFieldSubscriber($factory, $this->securityContext);
        $builder->addEventSubscriber($userSubscriber);

        $builder->add('description', 'textarea', array(  'required' => true,  
                                                        'label' => 'Description',
                                                        'attr' => array('class' => 'span6', 'rows' => 10),  
                                                        'help' => NULL,  
                                                        'translation_domain' => 'TaskeetMainBundle',));

        //$builder->add('followers', 'double_list', array(  'em' => 'default',  'class' => 'Taskeet\\MainBundle\\Entity\\User',  'label' => 'Followers',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));


        
        $followersSubscriber = new AddFollowersFieldSubscriber($factory, $this->securityContext);
        $builder->addEventSubscriber($followersSubscriber);
        
        $builder->add('startDate', 'datetime', array(  'required' => true,  'label' => 'Startdate',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

$builder->add('dueDate', 'datetime', array(  'required' => true,  'label' => 'Duedate',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',)); 

    }
}
