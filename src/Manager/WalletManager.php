<?php

namespace App\Manager;

use App\Entity\User;
use App\Entity\Group;
use Doctrine\ORM\EntityManagerInterface;

class WalletManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }

    public function updateForGroup(Group $group)
    {
        foreach ($group->getStudents() as $student) {
            $ilosc = $group->getTraining()->count();
            $student->setWallet($student->getWallet() - ($ilosc * $group->getPrice()));
            $this->entityManager->persist($student);
            $this->entityManager->flush();
        }
    }
}
