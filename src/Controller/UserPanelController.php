<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Entity\SignForClasses;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\ClassesRepository;
use App\Repository\SignForClassesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(Request $request): Response
    {
        $userData=$this->security->getUser();
        $userClasses = $this->signForClassesRepository->findBy(['user' => $this->security->getUser()]);
        $editForm = $this->createForm(UserType::class, $userData);


        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_panel');
        }
        dump($userClasses, $userData);
        return $this->render('user_panel/index.html.twig', [
            'controller_name' => 'UserPanelController',
            'userClasses' => $userClasses,
            'userData' => $userData,
            'form' => $editForm->createView()
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
