<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TrainerPanelController extends AbstractController
{
    /**
     * @Route("/trener/panel", name="trener_panel")
     */
    public function index()
    {
        return $this->render('trener_panel/index.html.twig', [
            'controller_name' => 'TrainerPanelController',
        ]);
    }
}
