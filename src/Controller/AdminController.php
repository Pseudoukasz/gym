<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Trener;
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
        ->add('urzytkownik', EntityType::class,[
            'class'=>User::class,
            'choice_label'=>'email',
        ])
        ->add('rola', ChoiceType::class,[
            'choices'=>[
                ' ' => '',
                'trener'=>'ROLE_TRAINER',
                'klient'=>'ROLE_CUSTOMER',
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
                //$data2=$data['urzytkownik'];
                //$data3=$data['rola'];
                $em=$this->getDoctrine()->getManager();
                
                $user=$em->getRepository(User::class)->find($data['urzytkownik']);
                $user->setRoles([$data['rola']]);
                if($data['rola']=="ROLE_TRAINER"){
                    $imie=$user->getImie();
                    $nazwisko=$user->getNazwisko();
                    $trener= new Trener();
                    $trener->setImie($imie);
                    $trener->setNazwisko($nazwisko);
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
