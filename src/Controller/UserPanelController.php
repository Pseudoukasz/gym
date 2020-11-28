<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Entity\SignForClasses;
use App\Repository\ClassesRepository;
use App\Repository\SignForClassesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;

class UserPanelController extends AbstractController
{
    private $classesRepository;
    private $signForClassesRepository;
    private $router;
    private $security;
    private $user;

    public function __construct(
        ClassesRepository $classesRepository,
        SignForClassesRepository $signForClassesRepository,
        Security $security
    ) {
        $this->classesRepository = $classesRepository;
        $this->signForClassesRepository = $signForClassesRepository;
        $this->security = $security;
    }
    /**
     * @Route("/user/panel", name="user_panel")
     */
    public function index(): Response
    {
        $userClasses = $this->signForClassesRepository->findBy(['user' => $this->security->getUser()]);

        $userData=$this->security->getUser();
        dump($userClasses, $userData);
        return $this->render('user_panel/index.html.twig', [
            'controller_name' => 'UserPanelController',
            'userClasses' => $userClasses,
            'userData' => $userData,
        ]);
    }

    /**
     * @Route("/user/panel/{id}", name="rep_log_delete", methods={"DELETE"})
     */
    public function unsignFromClasses(SignForClasses $classes): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        $em = $this->getDoctrine()->getManager();
        $em->remove($classes);
        $em->flush();
        return new Response(null, 204);
    }
}
