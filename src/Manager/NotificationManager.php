<?php

namespace App\Manager;

use App\Entity\Notification;
use App\Entity\User;
use App\Entity\Group;
use Doctrine\ORM\EntityManagerInterface;

class NotificationManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }

    public function send(User $user, string $info)
    {
        $notification = new Notification();
        $notification->setUser($user);
        $notification->setDescription($info);
        $notification->setCreateDate(new \DateTime());
        $this->entityManager->persist($notification);
        $this->entityManager->flush();
    }
}
