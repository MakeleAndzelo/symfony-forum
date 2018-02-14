<?php

namespace App\Controller;


use App\Entity\Reply;
use App\Entity\Thread;
use App\Entity\User;
use App\Form\UserType;
use App\Services\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersController extends Controller
{
    /**
     * @Route("/user/{username}/threads", name="threads_by_user")
     */
    public function showUserThreads(Request $request, User $user)
    {
        if(!$user) {
            $this->createNotFoundException();
        }

        $threads = $this->getDoctrine()
            ->getRepository(Thread::class)
            ->findAllByUserOrderByUpdatedAt($user, $request->query->getInt('page', 1));

        return $this->render('threads/index.html.twig', [
            'threads' => $threads
        ]);
    }

    /**
     * @Route("/user/{username}", name="user_profile")
     * @Method("GET")
     */
    public function show(User $user)
    {
        if(!$user) {
            $this->createNotFoundException();
        }

        $lastReplies = $this->getDoctrine()
            ->getRepository(Reply::class)
            ->findAllLastUserPosts($user);

        return $this->render("users/show.html.twig", [
            'user' => $user,
            'lastReplies' => $lastReplies,
        ]);
    }

    /**
     * @Route("/register", name="registration")
     * @Method({"GET", "POST"})
     */
    public function create(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user->setPassword(
                $encoder->encodePassword($user, $user->getPlainPassword())
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('users/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}