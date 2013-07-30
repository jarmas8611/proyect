<?php

namespace Taskeet\MainBundle\Controller\Ticket;

use Admingenerated\TaskeetMainBundle\BaseTicketController\NewController as BaseNewController;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use DateTime;
use DateInterval;

class NewController extends BaseNewController
{
    /**
     * This method is here to make your life better, so overwrite  it
     *
     * @param \Symfony\Component\Form\Form $form the valid form
     * @param \Taskeet\MainBundle\Entity\Ticket $Ticket your \Taskeet\MainBundle\Entity\Ticket object
     */
    public function preSave(\Symfony\Component\Form\Form $form, \Taskeet\MainBundle\Entity\Ticket $Ticket)
    {
        if($form->get('remind')->getData())
        {
            $date = clone $form->get('startDate')->getData();
            $date->sub(new DateInterval($form->get('remind')->getData()));

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

        //poniendo al usuario logueado como owner
        $this->setPermissions($proveedor, $idObjeto, $this->getUser(), MaskBuilder::MASK_OWNER);

        //si la tarea tiene asignado un empleado se le asigna el perm operator
        if($assignedTo = $Ticket->getAssignedTo())
        {
            $this->setPermissions($proveedor, $idObjeto, $assignedTo, MaskBuilder::MASK_EDIT);
        }

        if($data = $form->get('repeat')->getData())
        {
            $start = clone $form->get('startDate')->getData();
            $end = clone $form->get('startDate')->getData();
            $interval = $form->get('repeat')->getData();

            $periodo = new DatePeriod($start, $interval, $end,
                \DatePeriod::EXCLUDE_START_DATE);

            foreach ($periodo as $fecha) {
                $ticket = clone $Ticket;
                $ticket->setStartDate(new \DateTime($fecha));
                $this->saveObject($ticket);
            }

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

    public function cloneAction($pk)
    {
        $Ticket = $this->getObject($pk);

        $clone = $this->getNewObject();

        // $clone = $Ticket;

        $title = $Ticket->getTitle().' '.'clon';

        $clone->setTitle($title);

        $clone->setDescription($Ticket->getDescription());

        // $clone->setFiles($Ticket->getFiles());

        $clone->setStartDate($Ticket->getStartDate());

        $clone->setDueDate($Ticket->getDueDate());

        $clone->setPriority($Ticket->getPriority());

        $clone->setAssignedTo($Ticket->getAssignedTo());

        $clone->setProject($Ticket->getProject());

        $clone->setDone($Ticket->getDone());

        $clone->setStatus($Ticket->getStatus());

        // $this->checkCredentials($Ticket);


        if (!$Ticket) {
            throw new NotFoundHttpException("The Taskeet\MainBundle\Entity\Ticket with id $pk can't be found");
        }

        $form = $this->createForm($this->getNewType(), $clone);

        return $this->render('TaskeetMainBundle:TicketNew:index.html.twig', $this->getAdditionalRenderParameters($Ticket) + array(
            "Ticket" => $clone,
            "form" => $form->createView(),
        ));
    }

    protected function getObject($pk)
    {
        return $this->getDoctrine()
                    ->getManager()
                    ->getRepository('Taskeet\MainBundle\Entity\Ticket')
                    ->find($pk);
    }
}
