<?php
	namespace App\Controller\Admin;
	
	use App\Entity\User;
	use App\Form\EditProfileImageType;
	use App\Form\ProfileType;
	use App\Form\EditPasswordType;
	use App\Repository\UserRepository;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\Routing\Annotation\Route;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	
	class AdminProfileController extends AbstractController {
		
		/**
		 * @var UserRepository
		 */
		private $repository;
		
		public function __construct(UserRepository $repository,EntityManagerInterface $em)
		{
			$this->repository = $repository;
			$this->em = $em;
		}
		
		
		/**
		 * @Route("/admin/profil/voir{id}", name="admin.profile.show")
		 * @param User $user
		 * @return Response
		 */
		public function show(User $user,Request $request): Response
		{
			$form = $this->createForm(EditPasswordType::class, $user);
			$form->handleRequest($request);
			
			if ($form->isSubmitted() && $form->isValid()) {
				$this->em->flush();
				$this->addFlash('success', 'Mot de passe modifié avec succès');
				return $this->redirectToRoute('admin.profile.show', ['id'=> $user->getId()]);
			}
			
			$formImage = $this->createForm(EditProfileImageType::class, $user);
			$formImage->handleRequest($request);
			
			if ($formImage->isSubmitted() && $formImage->isValid()) {
				$this->em->flush();
				$this->addFlash('success', 'Photo de profil modifié avec succès');
				return $this->redirectToRoute('admin.profile.show', ['id'=> $user->getId()]);
			}
			
			return $this->render('admin/profile/show.html.twig', [
				'user' => $user,
				'form' => $form->createView(),
				'formImage' => $formImage->createView(),
			]);
		}
		
		/**
		 * @Route("/admin/profil/{id}", name="admin.profile.edit", methods="GET|POST")
		 * @param User $user
		 * @param Request $request
		 * @return  \Symfony\Component\HttpFoundation\Response
		 */
		public function edit(User $user,Request $request)
		{
			$form = $this->createForm(ProfileType::class, $user);
			$form->handleRequest($request);
			
			if ($form->isSubmitted() && $form->isValid()) {
				$this->em->flush();
				$this->addFlash('success', 'Profil modifié avec succès');
				return $this->redirectToRoute('admin.profile.show', ['id'=> $user->getId()]);
			}
			
			return $this->render('admin/profile/edit.html.twig', [
				'user' => $user,
				'form' => $form->createView()
			]);
		}
		
		/**
		 * @Route("/admin/profil/{id}", name="admin.profile.delete", methods="DELETE")
		 * @param User $user
		 * @param Request $request
		 */
		public function delete(User $user, Request $request){
			if($user == null)
			{
				return $this->redirectToRoute('home');
			}
			if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->get('_token'))) {
				$this->get('security.token_storage')->setToken(null);
				$this->em->remove($user);
				$this->em->flush();
				return $this->redirectToRoute('home');
			}
			return $this->redirectToRoute('home');
		}
	}