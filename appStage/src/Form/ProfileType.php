<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('sex', ChoiceType::class , array(
                'choices' => array(
                    'Femme' => 'f',
                    'Homme' => 'm'
                ),
                'required'    => false,
                'empty_data'  => null,
                'expanded' => true,
                'multiple' => false,
                'placeholder' =>false
            ))
            ->add('cvFile', FileType::class)
            ->add('description')
            ->add('address')
            ->add('postalCode')
            ->add('city')
            ->add('country')
            ->add('phone')
            ->add('email')
            ->add('birthdate', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('companyName')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
	        'translation_domain' =>'forms'
        ]);
    }
}
