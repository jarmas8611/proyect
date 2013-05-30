<?php

namespace Taskeet\MainBundle\Controller\User;

use Admingenerated\TaskeetMainBundle\BaseUserController\EditController as BaseEditController;

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
        $User->setPassword($password);
    }
}
