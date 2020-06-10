<?php

// app/src/Controller/RegistrationController.php
	namespace App\Controller;
	
	use App\Entity\User;
	use App\Form\RegistrationFormType;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
	
	class RegistrationController extends AbstractController
	{
		/**
		 * @Route("/register", name="register")
		 */
		public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
		{
			$user = new User();
			$form = $this->createForm(RegistrationFormType::class, $user);
			$form->handleRequest($request);
			
			if ($form->isSubmitted() && $form->isValid()) {
				// encode the plain password
				$user->setPassword(
					$passwordEncoder->encodePassword(
						$user,
						$form->get('plainPassword')->getData()
					)
				);
				
				$em = $this->getDoctrine()->getManager();
				$em->persist($user);
				$em->flush();
				
				
				// do anything else you need here, like send an email
				// in this example, we are just redirecting to the homepage
				return $this->redirectToRoute('login',['id'=> $user->getId()]);
			}
			
			return $this->render('registration/register.html.twig', [
				'registrationForm' => $form->createView(),
				'id' => $user->getId()
			]);
		}
		
		
		/**
		 * @Route("/", name="app_index")
		 */
		public function index()
		{
			return $this->render('admin/index.html.twig');
		}
		
	}