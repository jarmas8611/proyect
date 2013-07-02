<?php

namespace Taskeet\MainBundle\Controller\User;

use Admingenerated\TaskeetMainBundle\BaseUserController\EditController as BaseEditController;
use JMS\SecurityExtraBundle\Security\Authorization\Expression\Expression;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class EditController extends BaseEditController
{
    /**
     * This method is here to make your life better, so overwrite  it
     *
     * @param \Symfony\Component\Form\Form $form the valid form
     * @param \Taskeet\MainBundle\Entity\User $User your \Taskeet\MainBundle\Entity\User object
     */
    public function preSave(\Symfony\Component\Form\Form $form, \Taskeet\MainBundle\Entity\User $User)
    {
        $factory = $this->get('security.encoder_factory');

            $encoder = $factory->getEncoder($User);
            $password = $encoder->encodePassword($form->get('password')->getData(), $User->getSalt());

        if ($password != $User->getPassword()) {
            
            $User->setPassword($password);
        }
        else {
            $User->setPassword($User->getPassword());
        }


        if($this->get('security.context')->isGranted(array(new Expression('not hasRole("ROLE_ADMIN") and hasRole("ROLE_JEFE_DPTO")'))))
        {
            $dpto = $this->getEntityManager()->getRepository('TaskeetMainBundle:Department')
                ->findOneByOwner($this->getUser());
            $User->addDepartment($dpto);
            $this->saveObject($User);
        }
    }

    /**
     * This method is here to make your life better, so overwrite  it
     *
     * @param \Symfony\Component\Form\Form $form the valid form
     * @param \Taskeet\MainBundle\Entity\User $User your \Taskeet\MainBundle\Entity\User object
     */
    public function postSave(\Symfony\Component\Form\Form $form, \Taskeet\MainBundle\Entity\User $User)
    {
        // if ($form->get('password')->getData() != '') {
        //     $factory = $this->get('security.encoder_factory');

        //     $encoder = $factory->getEncoder($User);
        //     $password = $encoder->encodePassword($form->get('password')->getData(), $User->getSalt());
        //     $User->setPassword($password);
        // }

    }

}
