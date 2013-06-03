<?php

namespace Taskeet\MainBundle\Controller\Project;

use Admingenerated\TaskeetMainBundle\BaseProjectController\EditController as BaseEditController;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class EditController extends BaseEditController
{
    /**
     * This method is here to make your life better, so overwrite  it
     *
     * @param \Symfony\Component\Form\Form $form the valid form
     * @param \Taskeet\MainBundle\Entity\Project $Project your \Taskeet\MainBundle\Entity\Project object
     */
    public function postSave(\Symfony\Component\Form\Form $form, \Taskeet\MainBundle\Entity\Project $Project)
    {
        $proveedor = $this->container->get('security.acl.provider');

        $idObjeto = ObjectIdentity::fromDomainObject($Project);

        //asignando permisos para ver a los miembros
        $users = $Project->getMembers();
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
