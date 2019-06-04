<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class CoachType.
 */
class CoachType extends AbstractType
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'User';
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', TextType::class, [
                    'label' => 'First name',
                    'attr' => [
                        'data-minlength' => '5',
                        'data-maxlength' => '50',
                    ],
                ])
                ->add('surname', TextType::class, [
                    'label' => 'Surname',
                    'attr' => [
                        'data-minlength' => '3',
                        'data-maxlength' => '50',
                    ],
                ])
                ->add('points', NumberType::class, [
                    'label' => 'Punkty',
                    'attr' => [
                        'min' => '0',
                    ],
                ])
                ->add('phone', TelType::class, [
                    'label' => 'Phone',
                ])
                ->add('description', TextareaType::class, [
                    'required' => false,
                    'label' => 'Description',
                    'attr' => [
                        'data-maxlength' => '1000',
                        'rows' => '10',
                    ],
                ])
                ->add('email', EmailType::class, [
                    'label' => 'E-mail',
                    'attr' => [
                        'data-minlength' => '3',
                        'data-maxlength' => '50',
                    ],
                ])
                ->add('city', TextType::class, [
                    'required' => false,
                    'label' => 'City',
                    'label_attr' => [
                        'class' => 'floated',
                    ],
                ])
                ->add('street', TextType::class, [
                    'required' => false,
                    'label' => 'Street',
                    'attr' => [
                        'data-minlength' => '3',
                        'data-maxlength' => '50',
                    ],
                     'label_attr' => [
                        'class' => 'floated',
                    ],
                ])
                ->add('postalCode', TextType::class, [
                    'required' => false,
                    'label' => 'Postal code',
                    'attr' => [
                        'data-minlength' => '3',
                        'data-maxlength' => '10',
                        'data-mask' => '99999',
                    ],
                     'label_attr' => [
                        'class' => 'floated',
                    ],
                ])
                ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\User',
        ]);
    }
}
