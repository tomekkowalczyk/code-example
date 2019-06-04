<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class AbsenceApplicationRepository extends EntityRepository
{
    public function getQueryBuilder(array $params = [])
    {
        $emConfig = $this->getEntityManager()->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        $emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');
        $datetime = new \DateTime();
        $year = $datetime->format('Y');
        $month = $datetime->format('m');
        $day = $datetime->format('d');

        $qb = $this->createQueryBuilder('absence_application')
            ->select('absence_application')
            ->leftJoin('absence_application.student', 'student')
            ;

        if (!empty($params['training'])) {
            $qb->andWhere('training = :training')
                ->setParameter('training', $params['training']);
        }

        if (!empty($params['today'])) {
            $qb->andWhere('YEAR(absence_application.updateDate) = :currDateYear')
                ->andWhere('MONTH(absence_application.updateDate) = :currDateMonth')
                ->andWhere('DAY(absence_application.updateDate) = :currDateDay')
                ->setParameter('currDateYear', $year)
                ->setParameter('currDateMonth', $month)
                ->setParameter('currDateDay', $day);
        }

        if (!empty($params['student'])) {
            $qb->andWhere('student = :student')
                ->setParameter('student', $params['student'])
                ->andWhere('student.roles LIKE :roles')
                ->setParameter('roles', '%"ROLE_STUDENT"%');
        }

        if (!empty($params['orderBy'])) {
            $orderDir = !empty($params['orderDir']) ? $params['orderDir'] : null;
            $qb->orderBy($params['orderBy'], $orderDir);
        }

        if (!empty($params['limit'])) {
            $qb->setMaxResults($params['limit']);
        }

        return $qb;
    }
}
