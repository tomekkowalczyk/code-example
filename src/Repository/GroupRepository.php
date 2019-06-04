<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class GroupRepository extends EntityRepository
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

        $qb = $this->createQueryBuilder('groups')
            ->select('groups, training, term, educationLevel, swimmingPool, student, coach')
            ->leftJoin('groups.training', 'training')
            ->leftJoin('groups.swimmingPool', 'swimmingPool')
            ->leftJoin('groups.educationLevel', 'educationLevel')
            ->leftJoin('groups.term', 'term')
            ->leftJoin('groups.students', 'student')
            ->leftJoin('groups.coach', 'coach');

        if (!empty($params['swimmingPool'])) {
            $qb->andWhere('swimmingPool = :swimmingPool')
                ->setParameter('swimmingPool', $params['swimmingPool']);
        }

        if (!empty($params['educationLevel'])) {
            $qb->andWhere('educationLevel = :educationLevel')
                ->setParameter('educationLevel', $params['educationLevel']);
        }
        if (!empty($params['term'])) {
            $qb->andWhere('term = :term')
                ->setParameter('term', $params['term']);
        }
        if (!empty($params['coach'])) {
            $qb->andWhere('coach = :coach')
                ->setParameter('coach', $params['coach'])
                ->andWhere('coach.roles LIKE :roles')
                ->setParameter('roles', '%"ROLE_COACH"%');
        }
        if (!empty($params['student'])) {
            $qb->andWhere('student = :student')
                ->setParameter('student', $params['student'])
                ->andWhere('student.roles LIKE :roles')
                ->setParameter('roles', '%"ROLE_STUDENT"%');
        }
        if (!empty($params['not_student'])) {
            $qb->andWhere('student != :not_student')
                ->setParameter('not_student', $params['not_student'])
                ->andWhere('student.roles LIKE :roles')
                ->setParameter('roles', '%"ROLE_STUDENT"%');
        }
        if (!empty($params['today'])) {
            $qb->andWhere('YEAR(groups.updateDate) = :currDateYear')
                ->andWhere('MONTH(groups.updateDate) = :currDateMonth')
                ->andWhere('DAY(groups.updateDate) = :currDateDay')
                ->setParameter('currDateYear', $year)
                ->setParameter('currDateMonth', $month)
                ->setParameter('currDateDay', $day);
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
