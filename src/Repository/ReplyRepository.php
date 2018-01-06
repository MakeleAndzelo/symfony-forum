<?php

namespace App\Repository;


use App\Entity\Thread;
use Doctrine\ORM\EntityRepository;

class ReplyRepository extends EntityRepository
{
    /**
     * @param Thread $thread
     * @return Reply[]
     */
    public function findAllByThreadOrderByUpdatedAt(Thread $thread)
    {
        return $this->createQueryBuilder('reply')
            ->where('reply.thread = :thread')
            ->setParameter(':thread', $thread)
            ->orderBy('reply.updated_at', 'DESC')
            ->getQuery()
            ->execute();
    }
}