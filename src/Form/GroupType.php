<?php

namespace App\Form;

use App\Entity\Term;
use App\Entity\User;
use App\Entity\EducationLevel;
use App\Entity\SwimmingPool;
use App\Entity\Group;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class GroupType.
 */
class GroupType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'attr' => [
                    'minlength' => '3',
                    'maxlength' => '120',
                ],
            ])
            ->add('coach', EntityType::class, [
                'label' => 'Coach',
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
                'label' => 'Students',
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
            ->add('swimmingPool', EntityType::class, [
                'label' => 'Swimming pool',
                'choice_label' => 'name',
                'class' => SwimmingPool::class,
                'choice_value' => 'slug',
            ])
            ->add('educationLevel', EntityType::class, [
                'label' => 'Education level',
                'class' => EducationLevel::class,
                'choice_value' => 'slug',
                'choice_label' => function ($educationLevel) {
                    return 'Poziom '.$educationLevel->getLevel();
                },
            ])
            ->add('term', EntityType::class, [
                'label' => 'Term',
                'choice_label' => function ($term) {
                    return $term->getName().' '.$term->getStartDate()->format('d.m.Y').' - '.$term->getStartDate()->format('d.m.Y');
                },
                'choice_value' => 'slug',
                'class' => Term::class,
            ])
            ->add('startDate', DateTimeType::class, [
                'label' => false,
                'widget' => 'single_text',
            ])
            ->add('endDate', DateTimeType::class, [
                'label' => false,
                'widget' => 'single_text',
            ])
            ->add('price', NumberType::class, [
                'label' => false,
            ])->add('minCount', NumberType::class, [
                'label' => false,
            ])
            ->add('maxCount', NumberType::class, [
                'label' => false,
            ])
            ->add('poolPath', NumberType::class, [
                'label' => false,
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'label' => 'Description',
                'attr' => [
                    'rows' => '10',
                ],
            ])
            ->add('arrearGroup', EntityType::class, [
                'required' => false,
                'multiple' => true,
                'label' => 'Arrears',
                'choice_label' => function ($groupArrear) {
                    return $groupArrear->getName();
                },
                'choice_value' => 'slug',
                'class' => Group::class,
                'attr' => [
                    'multiple' => 'multiple',
                ],
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Group::class,
        ]);
    }
}
