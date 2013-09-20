<?php

namespace Taskeet\MainBundle\Controller\Department;

use Admingenerated\TaskeetMainBundle\BaseDepartmentController\EditController as BaseEditController;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class EditController extends BaseEditController
{
    /**
     * This method is here to make your life better, so overwrite  it
     *
     * @param \Symfony\Component\Form\Form $form the valid form
     * @param \Taskeet\MainBundle\Entity\Department $Department your \Taskeet\MainBundle\Entity\Department object
     */
    public function preSave(\Symfony\Component\Form\Form $form, \Taskeet\MainBundle\Entity\Department $Department)
    {
        if($Department->getOwner() != $form->get('owner')->getData())
        {
            $proveedor = $this->container->get('security.acl.provider');
            $idObjeto = ObjectIdentity::fromDomainObject($oferta);
            $idUsuario = UserSecurityIdentity::fromAccount($tienda);

            $acl = $proveedor->findAcl($idObjeto, array($idUsuario));

            $aces = $acl->getObjectAces();
            foreach ($aces as $index => $ace) {
                $acl->deleteObjectAce($index);
            }

            $proveedor->updateAcl($acl);
        }

        if ($form->get('parent')->getData() == $form->get('name')->getData()) {
            $Department->setParent(NULL);
        }
    }

    /**
     * This method is here to make your life better, so overwrite  it
     *
     * @param \Symfony\Component\Form\Form $form the valid form
     * @param \Taskeet\MainBundle\Entity\Department $Department your \Taskeet\MainBundle\Entity\Department object
     */
    public function postSave(\Symfony\Component\Form\Form $form, \Taskeet\MainBundle\Entity\Department $Department)
    {
        $proveedor = $this->container->get('security.acl.provider');

        $idObjeto = ObjectIdentity::fromDomainObject($Department);

        //si el departamento tiene asignado un encargado se le asigna el perm owner
        if($owner = $Department->getOwner())
        {
            $this->setPermissions($proveedor, $idObjeto, $owner, MaskBuilder::MASK_OWNER);
        }
        //asignando permisos para ver a los miembros
        $users = $Department->getUsers();
        foreach ($users as $user)
        {
            $this->setPermissions($proveedor, $idObjeto, $user, MaskBuilder::MASK_VIEW);
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
