<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 1/5/18
 * Time: 9:35 PM
 */

namespace App\Repository;


use Doctrine\ORM\EntityRepository;

class ThreadRepository extends EntityRepository
{
    /**
     * @return Thread[]
     */
    public function findAllOrderByUpdatedAt()
    {
        return $this->createQueryBuilder('thread')
            ->orderBy('thread.updated_at', 'DESC')
            ->getQuery()
            ->execute();
    }
}