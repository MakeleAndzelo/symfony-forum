<?php

namespace App\Controller;


use App\Entity\Channel;
use App\Entity\Thread;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class ChannelsController extends Controller
{
    public function index()
    {
        $channels = $this->getDoctrine()
            ->getRepository(Channel::class)
            ->findAll();

        return $this->render('channels/index.html.twig', [
            'channels' => $channels,
        ]);
    }

    /**
     * @Route("/threads/channel/{channelSlug}", name="channel_show", defaults={"page":"1"})
     * @Route("/threads/channel/{channelSlug}/page/{page}", name="channel_show_paginated", defaults={"page":"1"})
     * @param Channel $channel
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Channel $channel, int $page)
    {
        if(!$channel) {
            $this->createNotFoundException();
        }

        $threads = $this->getDoctrine()
            ->getRepository(Thread::class)
            ->findAllByChannelOrderByUpdatedAt($channel, $page);

        return $this->render('channels/show.html.twig', [
            'channel' => $channel,
            'threads' => $threads,
        ]);
    }
}