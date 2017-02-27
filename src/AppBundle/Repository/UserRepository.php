<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 2/24/17
 * Time: 2:29 PM
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

/**
 *
 */
class UserRepository extends  EntityRepository
{

    public function countUnreadMessages(\AppBundle\Entity\User $user)
    {
        return $this
            ->createQueryBuilder('u')
            ->select('count(m.id)')
            ->innerJoin('u.conversations', 'c')
            ->innerJoin('c.messages', 'm')
            ->where('u.id='. $user->getId())
            ->andWhere('m.author !='. $user->getId())
            ->andWhere('m.isRead ='. 0)
            ->getQuery()
            ->getSingleScalarResult();

    }
}