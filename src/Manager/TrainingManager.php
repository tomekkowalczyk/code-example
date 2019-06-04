<?php

namespace App\Manager;

use App\Entity\AbsenceApplication;
use App\Entity\Training;
use App\Entity\Group;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Translation\TranslatorInterface;

class TrainingManager
{
    /**
     * @var int
     */
    private $countTrainings = 0;
    private $translator;
    private $entityManager;

    public function __construct(TranslatorInterface $translator, EntityManagerInterface $em)
    {
        $this->translator = $translator;
        $this->entityManager = $em;
    }

    /**
     * @param Group $group
     *
     * @throws \Exception
     */
    public function create(Group $group)
    {
        $arrTrainingsDate = $this->generateTrainingDates($group->getStartDate(), $group->getEndDate());
        $this->countTrainings = count($arrTrainingsDate);

        foreach ($arrTrainingsDate as $trainingDate) {
            $training = new Training();
            $training->setStartDate($trainingDate['startDate'])
                ->setEndDate($trainingDate['endDate'])
                ->setCoach($group->getCoach());

            foreach ($group->getStudents() as $student) {
                $training->addStudent($student);
            }
            $group->addTraining($training);
        }

        return;
    }

    /**
     * @param \DateTime $startDateGroup
     * @param \DateTime $endDateGroup
     *
     * @return array
     *
     * @throws \Exception
     */
    public function generateTrainingDates(\DateTime $startDateGroup, \DateTime $endDateGroup)
    {
        $arrTrainingsDate = [];
        $endDateTraining = (new \DateTime($startDateGroup->format('Y-m-d H:i:s')))->modify('+45 minutes');

        while ($startDateGroup <= $endDateGroup) {
            $arrTrainingsDate[] = ['startDate' => new \DateTime($startDateGroup->format('Y-m-d H:i:s')),
                'endDate' => new \DateTime($endDateTraining->format('Y-m-d H:i:s')),
            ];
            $startDateGroup->modify('+7 day');
            $endDateTraining->modify('+7 day');
        }

        return $arrTrainingsDate;
    }

    public function addStudentForArrearTraining(int $training, int $arrear, User $student)
    {
        $trainingArrear = $this->entityManager->getRepository(Training::class)->findOneBy(['uid' => $arrear]);
        $trainingAbsence = $this->entityManager->getRepository(Training::class)->findOneBy(['uid' => $training]);
        $absenceApplication = $this->entityManager->getRepository(AbsenceApplication::class)->findOneBy(['training' => $trainingAbsence, 'student' => $student]);

        if (!$trainingArrear) {
            throw new Exception($this->translator->trans('Invalid arrear training uid'));
        }

        if (!$trainingAbsence) {
            throw new Exception($this->translator->trans('Invalid arrear training uid'));
        }

        if (!$absenceApplication) {
            throw new Exception($this->translator->trans('Invalid absence application'));
        }

        $trainingArrear->addStudent($student);
        $this->entityManager->persist($trainingArrear);
        $this->entityManager->flush();

        $this->entityManager->remove($absenceApplication);
        $this->entityManager->flush();

        return $trainingArrear;
    }
}
