<?php

namespace App\Controller;


use App\Entity\Thread;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends Controller
{
    /**
     * @Route("/user/{username}/threads", name="threads_by_user", defaults={"page":"1"})
     * @Route("/user/{username}/threads/page/{page}", name="threads_by_user_paginated", defaults={"page":"1"})
     */
    public function threads(User $user, $page)
    {
        $threads = $this->getDoctrine()->getRepository(Thread::class)->findAllByUserOrderByUpdatedAt($user, $page);

        return $this->render('threads/index.html.twig', [
            'threads' => $threads
        ]);
    }
}