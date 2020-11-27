<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder )
    {
        $form= $this->createFormBuilder()
            ->add('email')
            ->add('name')
            ->add('surname')
            ->add('phone_number')
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => ['label' =>'Hasło'],
                'second_options' => ['label' =>'Powtórz hasło']
            ])
            ->add('register', SubmitType::class, [
                'attr'=>[
                    'class'=>'btn btn-success float-rignt'
            ]])
            ->getForm()
        ;
            $form->handleRequest($request);
            if($form ->isSubmitted()){
                $data = $form->getData();
                $user = new User();
                $user->setEmail($data['email']);
                $user->setName($data['imie']);
                $user->setSurname($data['surname']);
                $user->setPhoneNumber($data['phone_number']);
                $user->setPassword(
                    $passwordEncoder->encodePassword($user, $data['password'])
                );
                //dump($data);die;
                $em=$this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                return $this -> redirect($this->generateUrl('app_login'));
            }

        return $this->render('register/index.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
