<?php

namespace Taskeet\MainBundle\Controller\Event;

use Admingenerated\TaskeetMainBundle\BaseEventController\NewController as BaseNewController;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use DateTime;
use DateInterval;
use DatePeriod;

class NewController extends BaseNewController
{
    /**
     * This method is here to make your life better, so overwrite  it
     *
     * @param \Symfony\Component\Form\Form $form the valid form
     * @param \Taskeet\MainBundle\Entity\Event $Ticket your \Taskeet\MainBundle\Entity\Event object
     */
    public function postSave(\Symfony\Component\Form\Form $form, \Taskeet\MainBundle\Entity\Event $Event)
    {
        $proveedor = $this->container->get('security.acl.provider');

        $idObjeto = ObjectIdentity::fromDomainObject($Event);

        //poniendo al usuario logueado como owner
        $this->setPermissions($proveedor, $idObjeto, $this->getUser(), MaskBuilder::MASK_OWNER);

        if($data = $form->get('repeat')->getData())
        {
            $start = clone $form->get('startDate')->getData();
            $end = clone $form->get('dueDate')->getData();
            $ocurrences = $form->get('ocurrences')->getData();
            $interval = new DateInterval($form->get('repeat')->getData());
            
            $periodo = new \DatePeriod($start, $interval, $ocurrences,
                \DatePeriod::EXCLUDE_START_DATE);

            foreach ($periodo as $key => $fecha) {
                $event = clone $Event;
                $event->setStartDate($fecha);
                $event->setDueDate($end->add($interval));
                $event->setTitle(sprintf('%s-%s', $Event->getTitle(), $key));
                // $event->setSlug(sprintf('%s-%s', $Event->getSlug(), $key));
                $this->preSave($form, $event);
                $this->saveObject($event);
                $idObjeto = ObjectIdentity::fromDomainObject($event);
                $this->setPermissions($proveedor, $idObjeto, $this->getUser(), MaskBuilder::MASK_OWNER);                
            }

        }

    }

    /**
     * This method is here to make your life better, so overwrite  it
     *
     * @param \Symfony\Component\Form\Form $form the valid form
     * @param \Taskeet\MainBundle\Entity\Event $Event your \Taskeet\MainBundle\Entity\Event object
     */
    public function preSave(\Symfony\Component\Form\Form $form, \Taskeet\MainBundle\Entity\Event $Event)
    {
        $Event->setOwner($this->getUser());

        if($form->get('remind')->getData())
        {
            $date = clone $form->get('startDate')->getData();
            $date->sub(new DateInterval($form->get('remind')->getData()));

            $Event->setReminder($date);
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
