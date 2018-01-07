<?php

namespace App\Controller;


use App\Entity\Reply;
use App\Entity\Thread;
use App\Form\ReplyType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RepliesController extends Controller
{
    /**
     * @Route("/threads/{slug}/reply", name="reply_new")
     * @Method({"GET", "POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @param Thread $thread
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function new(Thread $thread, Request $request)
    {
        $form = $this->createForm(ReplyType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $reply = $form->getData();
            $reply->setThread($thread);
            $reply->setUser($this->getUser());

            $entityManager->persist($reply);
            $entityManager->flush();

            $this->addFlash('success', 'Reply added');

            return $this->redirectToRoute('thread_show', [
                'slug' => $thread->getSlug()
            ]);
        }

        return $this->render('reply/new.html.twig', [
           'thread' => $thread,
           'form' => $form->createView(),
        ]);
    }
}