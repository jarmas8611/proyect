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

        $builder->add('title', 'text', array(  'required' => true,  'label' => 'Title',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        $builder->add('priority', 'entity', array(  'em' => 'default',  'class' => 'Taskeet\\MainBundle\\Entity\\Priority',  'multiple' => false,  'required' => false,  'label' => 'Priority',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        $builder->add('status', 'entity', array(  'em' => 'default',  'class' => 'Taskeet\\MainBundle\\Entity\\Status',  'multiple' => false,  'required' => true,  'label' => 'Status',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        $departmentSubscriber = new AddDepartmentFieldSubscriber($factory);
        $builder->addEventSubscriber($departmentSubscriber);

        $builder->add('project', 'entity', array(  'em' => 'default',  'class' => 'Taskeet\\MainBundle\\Entity\\Project',  'multiple' => false,  'required' => false,  'label' => 'Project',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        $builder->add('assignedTo', 'entity', array(  'em' => 'default',  'class' => 'Taskeet\\MainBundle\\Entity\\User',  'multiple' => false,  'required' => false,  'label' => 'Assignedto',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        $builder->add('startDate', 'datepicker', array(  'required' => true,  'label' => 'Startdate',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        $builder->add('dueDate', 'datepicker', array(  'required' => true,  'label' => 'Duedate',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        $builder->addEventSubscriber(new AddReminderFieldSubscriber());
        
        $userSubscriber = new AddUserFieldSubscriber($factory, $this->securityContext);
        $builder->addEventSubscriber($userSubscriber);


        $builder->add('description', 'textarea', array(  'required' => true,  'label' => 'Description',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        $builder->add('followers', 'double_list', array(  'em' => 'default',  'class' => 'Taskeet\\MainBundle\\Entity\\User',  'label' => 'Followers',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

        $followersSubscriber = new AddFollowersFieldSubscriber($factory, $this->securityContext);
        $builder->addEventSubscriber($followersSubscriber);
        
        $builder->add('done', 'checkbox', array(  'required' => false,  'label' => 'Done',  'help' => NULL,  'translation_domain' => 'TaskeetMainBundle',));

    }
}
