<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;

class TrainingRepository extends EntityRepository
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

        $qb = $this->createQueryBuilder('training')
            ->select('training, groups, term, educationLevel, swimmingPool, student, coach')
            ->leftJoin('training.group', 'groups')
            ->leftJoin('groups.swimmingPool', 'swimmingPool')
            ->leftJoin('groups.educationLevel', 'educationLevel')
            ->leftJoin('groups.term', 'term')
            ->leftJoin('training.students', 'student')
            ->leftJoin('training.coach', 'coach')
            ;

        if (!empty($params['training'])) {
            $qb->andWhere('training = :training')
                ->setParameter('training', $params['training']);
        }
        if (!empty($params['trainingUid'])) {
            $qb->andWhere('training.uid = :training')
                ->setParameter('training', $params['trainingUid']);
        }
        if (!empty($params['educationLevel'])) {
            $qb->andWhere('educationLevel = :educationLevel')
                ->setParameter('educationLevel', $params['educationLevel']);
        }
        if (!empty($params['group'])) {
            $qb->andWhere('groups = :group')
                ->setParameter('group', $params['group']);
        }
        if (!empty($params['term'])) {
            $qb->andWhere('term = :term')
                ->setParameter('term', $params['term']);
        }
        if (!empty($params['coach'])) {
            $qb->andWhere('coach = :coach')
                ->andWhere('coach.roles LIKE :role_coach OR coach.roles LIKE :role_admin')
                ->setParameter('coach', $params['coach'])
                ->setParameter('role_coach', '%"ROLE_COACH"%')
                ->setParameter('role_admin', '%"ROLE_ADMIN"%');
        }
        if (!empty($params['coachUid'])) {
            $qb->andWhere('coach.uid = :coach')
                ->andWhere('coach.roles LIKE :role_coach OR coach.roles LIKE :role_admin')
                ->setParameter('coach', $params['coachUid'])
                ->setParameter('role_coach', '%"ROLE_COACH"%')
                ->setParameter('role_admin', '%"ROLE_ADMIN"%');
        }
        if (!empty($params['student'])) {
            $qb->andWhere('student = :student')
                ->setParameter('student', $params['student'])
                ->andWhere('student.roles LIKE :roles')
                ->setParameter('roles', '%"ROLE_STUDENT"%');
        }
        if (!empty($params['studentUid'])) {
            $qb->andWhere('student.uid = :student')
                ->setParameter('student', $params['studentUid'])
                ->andWhere('student.roles LIKE :roles')
                ->setParameter('roles', '%"ROLE_STUDENT"%');
        }
        if (!empty($params['swimmingPool'])) {
            $qb->andWhere('swimmingPool = :swimmingPool')
                ->setParameter('swimmingPool', $params['swimmingPool']);
        }
        if (!empty($params['no_student'])) {
            $qb->andWhere('student.uid != :student')
                ->setParameter('student', $params['no_student'])
                ->andWhere('student.roles LIKE :roles')
                ->setParameter('roles', '%"ROLE_STUDENT"%');
        }

        if (!empty($params['today'])) {
            $qb->andWhere('YEAR(training.startDate) = :currDateYear')
                ->andWhere('MONTH(training.startDate) = :currDateMonth')
                ->andWhere('DAY(training.startDate) = :currDateDay')
                ->setParameter('currDateYear', $year)
                ->setParameter('currDateMonth', $month)
                ->setParameter('currDateDay', $day);
        }

        if (!empty($params['startDate'])) {
            $year = ($params['startDate'])->format('Y');
            $month = ($params['startDate'])->format('m');
            $day = ($params['startDate'])->format('d');
            $qb->andWhere('YEAR(training.startDate) = :startDateYear')
                ->andWhere('MONTH(training.startDate) = :startDateMonth')
                ->andWhere('DAY(training.startDate) = :startDateDay')
                ->setParameter('startDateYear', $year)
                ->setParameter('startDateMonth', $month)
                ->setParameter('startDateDay', $day);
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

    public function getArrearTrainings($conn, User $user, $group)
    {
        $sql = '
                   SELECT trainings.uid AS trainingUID, trainings.start_date AS trainingStartDate, 
                   trainings.end_date AS trainingEndDate, groups.name AS groupName, groups.pool_path AS groupPoolPath,
                   swimming_pools.name AS swimmingPoolName, users.name AS coachName, users.surname AS coachSurname,
                   groups.max_count AS groupMaxCount, COUNT(training_students.user_id) AS studentsCount
                   FROM trainings
                   INNER JOIN groups ON trainings.group_id = groups.id
                   INNER JOIN users ON users.id = trainings.coach_id
                   INNER JOIN swimming_pools ON groups.swimming_pool_id = swimming_pools.id
                   LEFT JOIN training_students ON trainings.id = training_students.training_id                 
                   WHERE group_id IN (    
                       SELECT arrear_groups.arrear_group
                       FROM groups
                       INNER JOIN arrear_groups
                       ON arrear_groups.group_id = groups.id
                       WHERE groups.slug = :slug
                   )
                   AND trainings.start_date > NOW()
                   GROUP BY trainings.id
                    ';

        $sql2 = '
                SELECT trainings.uid AS trainingUID FROM trainings
                LEFT JOIN training_students ON trainings.id = training_students.training_id
                WHERE training_students.user_id = :id
                ';

        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute(['id' => $user->getId()]);
        $trainingsAll = $stmt2->fetchAll();

        $stmt = $conn->prepare($sql);
        $stmt->execute(['slug' => $group->getSlug()]);
        $trainings = $stmt->fetchAll();

        $i = 0;
        foreach ($trainings as $training) {
            foreach ($trainingsAll as $trainingAll) {
                if ($training['trainingUID'] === $trainingAll['trainingUID']) {
                    unset($trainings[$i]);
                }
            }
            ++$i;
        }
        return $trainings;
    }
}
