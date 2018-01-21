<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 1/5/18
 * Time: 9:35 PM
 */

namespace App\Repository;


use App\Entity\Channel;
use App\Entity\Thread;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class ThreadRepository extends EntityRepository
{
    /**
     * @return Thread[]
     */
    public function findAllOrderByUpdatedAt(int $page)
    {
        $query = $this->createQueryBuilder('thread')
            ->orderBy('thread.updated_at', 'DESC')
            ->getQuery();

        return $this->createPaginator($query, $page);
    }

    /**
     * @param Channel $channel
     * @return Thread[]
     */
    public function findAllByChannelOrderByUpdatedAt(Channel $channel, int $page)
    {
        $query = $this->createQueryBuilder('thread')
            ->where('thread.channel = :channel')
            ->setParameter(':channel', $channel)
            ->orderBy('thread.updated_at', 'DESC')
            ->getQuery();

        return $this->createPaginator($query, $page);
    }

    /**
     * @param User $user
     * @return Pagerfanta
     */
    public function findAllByUserOrderByUpdatedAt(User $user, int $page)
    {
        $query = $this->createQueryBuilder('thread')
            ->where('thread.user = :user')
            ->setParameter(':user', $user)
            ->orderBy('thread.updated_at', 'DESC')
            ->getQuery();

        return $this->createPaginator($query, $page);
    }

    /**
     * @param Query $query
     * @param int $page
     * @return Pagerfanta
     */
    private function createPaginator(Query $query, int $page)
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($query));
        $paginator->setCurrentPage($page)
            ->setMaxPerPage(Thread::THREADS_NUM);
        return $paginator;
    }
}