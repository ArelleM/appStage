<?php

// app/src/Form/RegistrationFormType.php
	namespace App\Form;
	
	use App\Entity\User;
	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\Extension\Core\Type\PasswordType;
	use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
	use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
	use Symfony\Component\Form\Extension\Core\Type\CollectionType;
	use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Symfony\Component\Validator\Constraints\NotBlank;
	use Symfony\Component\Validator\Constraints\Length;
	use Symfony\Component\Validator\Constraints\IsTrue;
	
	class RegistrationFormType extends AbstractType
	{
		public function buildForm(FormBuilderInterface $builder, array $options)
		{
			
			$builder
				->add('username')
				->add('plainPassword', RepeatedType::class, [
					'type' => PasswordType::class,
					'invalid_message' => 'Les mots de passe ne correspondent pas',
					'required' => true,
					'first_options'  => ['label' => 'Mot de passe'],
					'second_options' => ['label' => 'Répétez le mot de passe'],
					// instead of being set onto the object directly,
					// this is read and encoded in the controller
					'mapped' => false,
					'constraints' => [
						new NotBlank([
							'message' => 'Veuillez rentrer un mot de passe',
						]),
						new Length([
							'min' => 6,
							'minMessage' => 'Votre mot de passe doit comprendre au moins {{ limit }} caractères',
							// max length allowed by Symfony for security reasons
							'max' => 4096,
						]),
					],
				])
				->add('roles', CollectionType::class, [
					'entry_type'   => ChoiceType::class,
					'entry_options'  => [
						'choices'  => [
							'Étudiant' => 'ROLE_STUDENT',
							'Entreprise' => 'ROLE_COMPANY',
						],
					],
				])
				
				->add('agreeTerms', CheckboxType::class, [
					'mapped' => false,
					'constraints' => [
						new IsTrue([
							'message' => 'You should agree to our terms.',
						]),
					],
				])
			;
		}
		
		public function configureOptions(OptionsResolver $resolver)
		{
			$resolver->setDefaults([
				'data_class' => User::class,
			]);
		}
	}
