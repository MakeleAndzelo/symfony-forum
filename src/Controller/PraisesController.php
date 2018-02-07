<?php

namespace App\Controller;


use App\Entity\Praise;
use App\Entity\Reply;
use App\Events;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PraisesController extends Controller
{
    /**
     * @Route("/reply/{id}/praise")
     * @Method("POST")
     */
    public function store(Reply $reply, Request $request, ValidatorInterface $validator, EventDispatcherInterface $eventDispatcher)
    {
        $token = $request->request->get('token');
        if(!$this->isCsrfTokenValid('add-praise', $token)) {
            $this->createNotFoundException();
        }

        if (!$reply) {
            return $this->createNotFoundException();
        }

        $praise = new Praise();
        $praise->setReply($reply);
        $praise->setUser($reply->getUser());
        $praise->setBody($request->request->get('body'));

        $errors = $validator->validate($praise);

        if(count($errors) > 0) {
            $this->addFlash('warning', 'Use only A-Z');
            return $this->redirectToRoute('thread_show', [
               'slug' => $reply->getThread()->getSlug(),
               'channelSlug' => $reply->getThread()->getChannel()->getChannelSlug(),
            ]);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($praise);
        $entityManager->flush();
        $this->addFlash('info', 'Successfully added praise!');

        $event = new GenericEvent($praise);
        $eventDispatcher->dispatch(Events::REPLY_PRAISED, $event);

        return $this->redirectToRoute('thread_show', [
           'slug' => $reply->getThread()->getSlug(),
           'channelSlug' => $reply->getThread()->getChannel()->getChannelSlug(),
        ]);
    }
}