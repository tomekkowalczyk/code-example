<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

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

        $qb = $this->createQueryBuilder('user')
            ->select('user, groups, coach, term')
            ->leftJoin('user.groups', 'groups')
            ->leftJoin('user.coach', 'coach')
            ->leftJoin('user.educationLevel', 'educationLevel')
            ->leftJoin('groups.term', 'term')
        ;

        if (!empty($params['roles'])) {
            $qb->andWhere('user.roles LIKE :roles')
                ->setParameter('roles', '%"'.$params['roles'].'"%');
        }
        if (!empty($params['uid'])) {
            $qb->andWhere('user.uid = :uid')
                ->setParameter('uid', $params['uid']);
        }
        if (!empty($params['educationLevel'])) {
            $qb->andWhere('educationLevel.id = :educationLevel')
                ->setParameter('educationLevel', $params['educationLevel']);
        }

        if (!empty($params['today'])) {
            $qb->andWhere('YEAR(user.updateDate) = :currDateYear')
                ->andWhere('MONTH(user.updateDate) = :currDateMonth')
                ->andWhere('DAY(user.updateDate) = :currDateDay')
                ->setParameter('currDateYear', $year)
                ->setParameter('currDateMonth', $month)
                ->setParameter('currDateDay', $day);
        }

        if (!empty($params['search'])) {
            $searchParam = '%'.$params['search'].'%';
            $qb->andWhere('user.name LIKE :searchParam OR user.surname LIKE :searchParam OR user.uid LIKE :searchParam')
                ->setParameter('searchParam', $searchParam);
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
