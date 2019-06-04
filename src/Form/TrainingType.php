<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use App\Entity\User;
use App\Entity\Group;
use App\Entity\Training;

/**
 * Class TrainingType.
 */
class TrainingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('coach', EntityType::class, [
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('user')
                        ->andWhere('user.roles LIKE :roles')
                        ->setParameter('roles', '%"ROLE_COACH"%');
                },
                'choice_label' => function ($coach) {
                    return $coach->getName().' '.$coach->getSurname();
                },
                'choice_value' => 'uid',
                'class' => User::class,
            ])
            ->add('students', EntityType::class, [
                'multiple' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('user')
                        ->andWhere('user.roles LIKE :roles')
                        ->setParameter('roles', '%"ROLE_STUDENT"%');
                },
                'choice_label' => function ($coach) {
                    return $coach->getName().' '.$coach->getSurname();
                },
                'choice_value' => 'uid',
                'class' => User::class,
                'attr' => [
                    'multiple' => 'multiple',
                ],
            ])
            ->add('group', EntityType::class, [
                'choice_label' => 'name',
                'choice_value' => 'slug',
                'class' => Group::class,
            ])
            ->add('startDate', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('endDate', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Training::class,
        ]);
    }
}
