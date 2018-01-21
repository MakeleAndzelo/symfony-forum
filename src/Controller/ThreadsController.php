<?php

namespace App\Controller;


use App\Entity\Channel;
use App\Entity\Reply;
use App\Entity\Thread;
use App\Form\ThreadType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ThreadsController extends Controller
{
    /**
     * @Route("/", name="homepage", defaults={"page":"1"})
     * @Route("/threads", name="threads_index", defaults={"page": "1"})
     * @Route("/threads/page/{page}", name="threads_index_paginated", defaults={"page": "1"})
     */
    public function index($page)
    {
        $threads = $this->getDoctrine()->getRepository(Thread::class)->findAllOrderByUpdatedAt($page);

        return $this->render('threads/index.html.twig', [
            'threads' => $threads,
        ]);
    }

    /**
     * @Route("/threads/{channelSlug}/{slug}", name="thread_show")
     * @param Channel $channel
     * @param Thread $thread
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Channel $channel, Thread $thread)
    {
        if(!$thread) {
            $this->createNotFoundException('Thread not found');
        }

        $replies = $this->getDoctrine()->getRepository(Reply::class)->findAllByThread($thread);

        return $this->render('threads/show.html.twig', [
           'thread' => $thread,
           'channel' => $channel,
           'replies' => $replies
        ]);
    }

    /**
     * @Route("/thread", name="thread_new")
     * @Method({"GET", "POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $form = $this->createForm(ThreadType::class);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $thread = $form->getData();
            $thread->setUser($this->getUser());

            $entityManager->persist($thread);
            $entityManager->flush();

            $this->addFlash('alert', 'Thread created');
            return $this->redirectToRoute('thread_show', [
               'slug' => $thread->getSlug(),
               'channelSlug' => $thread->getChannel()->getChannelSlug(),
            ]);
        }

        return $this->render('threads/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}