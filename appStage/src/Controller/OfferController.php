<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Offer;
use App\Repository\OfferRepository;
use Doctrine\ORM\EntityManagerInterface;;

class OfferController extends AbstractController
{
    /**
     * @var OfferRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(OfferRepository $repository,EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }


    /**
     * @Route("/offres", name="offer.index")
     * @return Response
     */

    public function index(): Response
    {


        return $this->render('offer/index.html.twig', [
            'current_menu' => 'offers'
        ]);
    }

    /**
     * @Route("/offres/{id}", name="offer.show")
     * @param Offer $offer
     * @return Response
     */
    public function show(Offer $offer): Response
    {

        return $this->render('offer/show.html.twig', [
            'offer' => $offer,
            'current_menu' => 'offers'
        ]);
    }
}