<?php

namespace App\Controller;


use App\Entity\Reply;
use App\Entity\Thread;
use App\Form\ThreadType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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

        $replies = $this->getDoctrine()->getRepository(Reply::class)->findAllByThread($thread);

        return $this->render('threads/show.html.twig', [
           'thread' => $thread,
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

            return $this->redirectToRoute('thread_show', [
               'slug' => $thread->getSlug(),
            ]);
        }

        return $this->render('threads/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}