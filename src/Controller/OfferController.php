<?php

namespace App\Controller;

use App\Entity\Memberships;
use App\Entity\User;
use App\Entity\MembershipsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OfferController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    /**
     * @Route("/offer", name="offer")
     */
    public function index()
    {
        $membershipTypes = $this->getDoctrine()->getRepository(MembershipsType::class)->findAll();

        return $this->render('offer/index.html.twig', [
            'membership_types' => $membershipTypes,
            'controller_name' => 'OfferController',
        ]);
    }
    /**
     * @Route("/offer/{id}", name="buy_membership")
     */
    public function buyMembership(Request $request, MembershipsType $membershipsType): Response
    {
        if($request->isXmlHttpRequest()){
            $ajax = $request;
            dump($ajax->get('membershipsType'));
            $entityManager = $this->getDoctrine()->getManager();
            $user = $this->get('security.token_storage')->getToken()->getUser();
             $meberships = new Memberships();
             $meberships->setDateStart(new \DateTime());
             $meberships->setDateEnd(new \DateTime());
             $meberships->setMembershipsType($ajax->get('membershipsType'));
             $meberships->setUserId($user->getId());
            $entityManager->persist($meberships);
            $entityManager->flush();

            dump($ajax);

        }

        dump($membershipsType);

        return new Response(null, 204);
    }
}
