<?php

namespace App\Repository;


use App\Entity\Thread;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;

class ReplyRepository extends EntityRepository
{
    /**
     * @param Thread $thread
     * @return Reply[]
     */
    public function findAllByThread(Thread $thread)
    {
        return $this->createQueryBuilder('reply')
            ->where('reply.thread = :thread')
            ->setParameter(':thread', $thread)
            ->getQuery()
            ->execute();
    }

    function findAllLastUserPosts(User $user)
    {
        return $this->createQueryBuilder('reply')
            ->where('reply.user = :user')
            ->setParameter(':user', $user)
            ->orderBy('reply.updatedAt', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->execute();
    }
}