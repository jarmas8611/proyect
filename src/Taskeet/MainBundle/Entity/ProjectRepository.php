<?php

namespace Taskeet\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjectRepository extends EntityRepository
{
//    public function findByMember($user)
//    {
//        $em = $this->getEntityManager();
//        $query = $em->createQuery('
//            SELECT e
//            FROM TaskeetMainBUndle:Project p
//            JOIN p.members m
//            WHERE m.usuario = :user
//            '
//        )
//            ->setParameter('user', $user);
//
//        return $query->getResult();
//    }
}
