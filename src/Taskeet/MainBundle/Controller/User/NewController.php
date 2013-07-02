<?php

namespace Taskeet\MainBundle\Controller\User;

use Admingenerated\TaskeetMainBundle\BaseUserController\NewController as BaseNewController;
use JMS\SecurityExtraBundle\Security\Authorization\Expression\Expression;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class NewController extends BaseNewController
{
    /**
     * This method is here to make your life better, so overwrite  it
     *
     * @param \Symfony\Component\Form\Form $form the valid form
     * @param \Taskeet\MainBundle\Entity\User $User your \Taskeet\MainBundle\Entity\User object
     */
    public function preSave(\Symfony\Component\Form\Form $form, \Taskeet\MainBundle\Entity\User $User)
    {
        if ($form->get('password')->getData()) {
            $factory = $this->get('security.encoder_factory');

            $encoder = $factory->getEncoder($User);
            $password = $encoder->encodePassword($form->get('password')->getData(), $User->getSalt());
            $User->setPassword($password);
        }


        if($this->get('security.context')->isGranted(array(new Expression('not hasRole("ROLE_ADMIN") and hasRole("ROLE_JEFE_DPTO")'))))
        {
            $dpto = $this->getEntityManager()->getRepository('TaskeetMainBundle:Department')
                ->findOneByOwner($this->getUser());
            $User->addDepartment($dpto);
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
        $proveedor = $this->container->get('security.acl.provider');

        $idObjeto = ObjectIdentity::fromDomainObject($User);

        $this->setPermissions($proveedor, $idObjeto, $this->getUser(), MaskBuilder::MASK_OWNER);



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
