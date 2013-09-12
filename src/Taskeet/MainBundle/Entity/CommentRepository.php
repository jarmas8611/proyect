<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Rafix
 * Date: 9/10/13
 * Time: 11:35 p.m.
 * To change this template use File | Settings | File Templates.
 */
namespace Taskeet\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Taskeet\MainBundle\Entity\User;

class CommentRepository extends EntityRepository
{
    public function findByUser(User $user)
    {
        return $this->getEntityManager()
            ->createQueryBuilder('c')
            ->leftJoin('c.thread', 't')
//            ->leftJoin('t.assignedTo', 'u1')
            ->where('t.createdBy = ?1')
            ->orWhere('t.assignedTo = ?2')
            ->orderBy('c.createdAt', 'DESC')
            ->setParameters(array(1 => $user->getUsername(), 2 => $user))
            ->getQuery()
            ->getResult();
    }
}
