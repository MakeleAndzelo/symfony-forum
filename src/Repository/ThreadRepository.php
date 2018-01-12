<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 1/5/18
 * Time: 9:35 PM
 */

namespace App\Repository;


use App\Entity\Channel;
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

    /**
     * @param Channel $channel
     * @return Thread[]
     */
    public function findAllByChannelOrderByUpdatedAt(Channel $channel)
    {
        return $this->createQueryBuilder('thread')
            ->where('thread.channel = :channel')
            ->setParameter(':channel', $channel)
            ->orderBy('thread.updated_at', 'DESC')
            ->getQuery()
            ->execute();
    }
}