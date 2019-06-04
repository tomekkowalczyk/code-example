<?php

namespace App\Form;

use App\Entity\RegistrationApplication;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

/**
 * Class ApplicationType.
 */
class RegistrationApplicationType extends AbstractType
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
            ->add('surname', TextType::class, [
                'label' => 'Surname',
                'attr' => [
                    'minlength' => '3',
                    'maxlength' => '120',
                ],
            ])
            ->add('birthday', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Birthday',
             ])
            ->add('phone', TelType::class, [
                'label' => 'Phone',
             ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
             ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'label' => 'Description',
                'attr' => [
                    'row' => '5',
                ],
            ])
            ->add('comment', TextareaType::class, [
                'required' => false,
                'label' => 'Comment',
                'attr' => [
                    'row' => '5',
                ],
            ])
            ->add('swimmingPool', EntityType::class, [
                'required' => false,
                'label' => false,
                'choice_label' => 'name',
                'class' => 'App\Entity\SwimmingPool',
                'choice_value' => 'slug',
            ])
            ->add('educationLevel', EntityType::class, [
                'required' => false,
                'label' => false,
                'class' => 'App\Entity\EducationLevel',
                'choice_value' => 'slug',
            ])
            ->add('status', EntityType::class, [
                'required' => false,
                'label' => false,
                'class' => 'App\Entity\ApplicationStatus',
                'choice_value' => 'slug',
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RegistrationApplication::class,
        ]);
    }
}
