<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Notification;
use http\Message;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

class NotificationSystem
{
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_MODERADOR = 'ROLE_MODERADOR';
    const ROLE_INVESTIGADOR = 'ROLE_INVESTIGADOR';

    public $em;

    public $logger;

    public $security;

    public function __construct(\Doctrine\ORM\EntityManagerInterface $em, LoggerInterface $logger, Security $security)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->security = $security;
    }

    public function notification(User $user, $message = '')
    {
        try {
            $notification = new Notification();
            $notification->setUser($user);
            $notification->setMessage($message);
            $this->em->persist($notification);
            $this->em->flush();
        } catch (\Doctrine\ORM\ORMException $e) {
            $this->logger->error('Can´t be posible to insert the notification');
        }
    }

    public function getUserNotification()
    {
        $currentUser = $this->security->getUser();
        return $this->em->getRepository('App:Notification')->findBy(array('user' => $currentUser->getId(), 'state' => true), array('createAt' => 'DESC'));
    }

    public function sendNotificationToAdminUsers($message)
    {
        $users = $this->em->getRepository('App:User')->findBy(array('isadmin' => true));
        foreach ($users as $user) {
            $this->notification($user, $message);
        }
    }

    public function sendNotificationToParentUser($message)
    {
        $currentUser = $this->security->getUser();
        $usersSystem = $this->em->getRepository('App:User')->findAll();
        $this->sendNotificationToAdminUsers($message);
        if (isset($currentUser)) {
            foreach ($usersSystem as $user) {
                if ($user->getUsername() != $currentUser->getUsername()) {
                    switch ($currentUser->getRoles()[0]) {
                        case self::ROLE_MODERADOR:
                            if ($user->getRoles() == self::ROLE_MODERADOR) {
                                $this->notification($user, $message);
                            }
                            break;
                        case self::ROLE_INVESTIGADOR:
                            if ($user->getRoles() == self::ROLE_MODERADOR || $user->getRoles() == self::ROLE_INVESTIGADOR) {
                                $this->notification($user, $message);
                            }
                            break;
                    }
                }
            }
        }
    }
}