<?php

namespace App\Controller;


use App\Entity\Reply;
use App\Entity\Thread;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class ThreadsController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Route("/threads", name="threads_index")
     */
    public function index()
    {
        $threads = $this->getDoctrine()->getRepository(Thread::class)->findAll();

        return $this->render('threads/index.html.twig', [
            'threads' => $threads,
        ]);
    }

    /**
     * @Route("/threads/{slug}", name="thread_show")
     * @param Thread $thread
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Thread $thread)
    {
        if(!$thread) {
            $this->createNotFoundException('Thread not found');
        }

        $replies = $this->getDoctrine()->getRepository(Reply::class)->findAllByThreadOrderByUpdatedAt($thread);

        return $this->render('thread/show.html.twig', [
           'thread' => $thread,
           'replies' => $replies
        ]);
    }
}