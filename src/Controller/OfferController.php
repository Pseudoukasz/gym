<?php

namespace App\Controller;

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
    public function buyMembership(Request $request, MembershipsType $membershipsType): void
    {



        $response = $this->client->request(
          'POST',
            'https://sandbox.przelewy24.pl/api/v1/transaction/register',[
            'body' =>['currency' => 'PLN',
            'description'=>'test order',
            'amount' => '100'],

        ]);
        dump($membershipsType);


    }
}
