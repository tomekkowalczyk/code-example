<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use App\Entity\SwimmingPool;
use App\Entity\User;
use App\Entity\EducationLevel;
use App\Entity\Term;

/**
 * Class SearchGroupType.
 */
class SearchGroupType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('swimmingPool', EntityType::class, [
                'required' => false,
                'label' => false,
                'choice_label' => 'name',
                'class' => SwimmingPool::class,
            ])
            ->add('coach', EntityType::class, [
                'required' => false,
                'label' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('user')
                        ->andWhere('user.roles LIKE :roles')
                        ->setParameter('roles', '%"ROLE_COACH"%');
                },
                'choice_label' => function ($coach) {
                    return $coach->getName().' '.$coach->getSurname();
                },
                'class' => User::class,
            ])
            ->add('student', EntityType::class, [
                'required' => false,
                'label' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('user')
                        ->andWhere('user.roles LIKE :roles')
                        ->setParameter('roles', '%"ROLE_STUDENT"%');
                },
                'choice_label' => function ($coach) {
                    return $coach->getName().' '.$coach->getSurname();
                },
                'class' => User::class,
            ])
            ->add('term', EntityType::class, [
                'required' => false,
                'label' => false,
                'choice_label' => function ($term) {
                    return $term->getName().' '.$term->getStartDate()->format('d.m.Y').' - '.$term->getStartDate()->format('d.m.Y');
                },
                'class' => Term::class,
            ])
            ->add('educationLevel', EntityType::class, [
                'required' => false,
                'label' => false,
                'class' => EducationLevel::class,
            ])
            ;
    }
}
