<?php

namespace App\EventListener;


use App\Events;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class PraiseNotificationSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(\Swift_Mailer $mailer, LoggerInterface $logger)
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    public function onReplyPraised(GenericEvent $event)
    {
        $praise = $event->getSubject();
        $reply = $praise->getReply();
        $user = $praise->getUser();

        $message = (new \Swift_Message('New Praise'))
            ->setFrom('forum@forum.pl')
            ->setTo($user->getEmail())
            ->setBody('New praise!');

        $this->mailer->send($message);

        $this->logger->info('Praise notification sent');
    }

    public static function getSubscribedEvents()
    {
        return [
          Events::REPLY_PRAISED => 'onReplyPraised',
        ];
    }
}