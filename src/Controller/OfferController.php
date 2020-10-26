<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class OfferController extends AbstractController
{
    /**
     * @Route("/offer", name="offer")
     */
    public function index()
    {
        return $this->render('offer/index.html.twig', [
            'controller_name' => 'OfferController',
        ]);
    }
}
