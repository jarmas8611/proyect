<?php

namespace Taskeet\MainBundle\Controller\Ticket;

use Admingenerated\TaskeetMainBundle\BaseTicketController\EditController as BaseEditController;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use DateTime;
use DateInterval;

class EditController extends BaseEditController
{
    /**
     * This method is here to make your life better, so overwrite  it
     *
     * @param \Symfony\Component\Form\Form $form the valid form
     * @param \Taskeet\MainBundle\Entity\Ticket $Ticket your \Taskeet\MainBundle\Entity\Ticket object
     */
    public function preSave(\Symfony\Component\Form\Form $form, \Taskeet\MainBundle\Entity\Ticket $Ticket)
    {
        if(!$form->get('reminder')->getData() instanceof DateTime && $form->get('reminder')->getData())
        {
            $date = clone $form->get('startDate')->getData();
            $date->sub(new DateInterval($form->get('reminder')->getData()));

            $Ticket->setReminder($date);
        }        

    }


    /**
     * This method is here to make your life better, so overwrite  it
     *
     * @param \Symfony\Component\Form\Form $form the valid form
     * @param \Taskeet\MainBundle\Entity\Ticket $Ticket your \Taskeet\MainBundle\Entity\Ticket object
     */
    public function postSave(\Symfony\Component\Form\Form $form, \Taskeet\MainBundle\Entity\Ticket $Ticket)
    {
        $proveedor = $this->container->get('security.acl.provider');

        $idObjeto = ObjectIdentity::fromDomainObject($Ticket);

        //si la tarea tiene asignado un empleado se le asigna el perm operator
        if($assignedTo = $Ticket->getAssignedTo())
        {
            $this->setPermissions($proveedor, $idObjeto, $assignedTo, MaskBuilder::MASK_EDIT);
        }



    }

    private function setPermissions($proveedor, $object, $user, $mask)
    {
        $idUsuario = UserSecurityIdentity::fromAccount($user);

        try {
            $acl = $proveedor->findAcl($object, array($idUsuario));
        } catch (\Symfony\Component\Security\Acl\Exception\AclNotFoundException $e) {
            $acl = $proveedor->createAcl($object);
        }

        $acl->insertObjectAce($idUsuario, $mask);

        //actualizando todos los permisos asignados
        $this->get('security.acl.provider')->updateAcl($acl);
    }

}
