<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Trainers;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(Request $request)
    {
        $users=$this->getDoctrine()->getRepository(User::class)->findAll();
        
        $form=$this->createFormBuilder()
        ->add('user', EntityType::class,[
            'class'=>User::class,
            'choice_label'=>'email',
        ])
        ->add('rola', ChoiceType::class,[
            'choices'=>[
                ' ' => '',
                'trener'=>'ROLE_TRAINER',
               // 'klient'=>'ROLE_CUSTOMER',
                'admin'=>'ROLE_ADMIN',
            ],
        ])
        ->add('zapisz', SubmitType::class, [
            'attr'=>[
                'class'=>'btn btn-danger float-rignt'
        ]])
        ->getForm();

        $form->handleRequest($request);
            if($form ->isSubmitted()){
                $data = $form->getData();
                $em=$this->getDoctrine()->getManager();

                $user=$em->getRepository(User::class)->find($data['user']);

                //$role = $user->getRoles();
                //$user->setRoles([$role, $data['rola']]);
                if($data['rola']=="ROLE_TRAINER"){
                    $imie=$user->getName();
                    $nazwisko=$user->getSurname();
                    $trener= new Trainers();
                    $trener->setName($imie);
                    $trener->setSurname($nazwisko);
                    //$trener->setImie($imie);
                    //$trener->setNazwisko($user['nazwisko']);
                    $em=$this->getDoctrine()->getManager();
                    $em->persist($trener);
                    $em->flush();
                    //var_dump($user);

                }
                dump($data,$user);
                $em->persist($user);
                $em->flush();
            }

        //dump($users);die;
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
            'form' => $form->createView(),
        ]);
    }
    public function nadaj_uprawnienia(Request $request){

        
        return $this->render('admin/index.html.twig',[
            
        ]);
    }
}
