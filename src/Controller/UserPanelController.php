<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Entity\Memberships;
use App\Entity\SignForClasses;
use App\Entity\Trainers;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\ClassesRepository;
use App\Repository\MembershipsRepository;
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
    private $membershipsRepository;
    private $router;
    private $security;
    private $user;

    public function __construct(
        ClassesRepository $classesRepository,
        SignForClassesRepository $signForClassesRepository,
        Security $security,
        MembershipsRepository $membershipsRepository
    ) {
        $this->classesRepository = $classesRepository;
        $this->signForClassesRepository = $signForClassesRepository;
        $this->security = $security;
        $this->membershipsRepository = $membershipsRepository;
    }
    /**
     * @Route("/user/panel", name="user_panel")
     */
    public function index(Request $request): Response
    {
        $em=$this->getDoctrine()->getManager();
        $userData=$this->security->getUser();
        $userClasses = $this->signForClassesRepository->findBy(['user' => $this->security->getUser()]);
        $editForm = $this->createForm(UserType::class, $userData);
        $userMembership =$this->membershipsRepository->findOneBy(['user_id' => $userData->getId()]);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_panel');
        }
        $id=$this->getUser()->getSurname();
        $trainer=$em->getRepository(Trainers::class)->findOneBy(['surname' => $id]);
        if($trainer != null){
            $userClasses = $em->getRepository(Classes::class)->findBy(['Trainer' => $trainer->getId()]);
            dump($userClasses);
        }

        return $this->render('user_panel/index.html.twig', [
            'controller_name' => 'UserPanelController',
            'userClasses' => $userClasses,
            'userData' => $userData,
            'trainer' => $trainer,
            'userMembership' => $userMembership ? $userMembership : null,
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
