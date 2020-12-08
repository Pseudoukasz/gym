<?php

namespace App\Controller;

use App\Entity\User;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Validator\Type\FormTypeValidatorExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\TypeValidator;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder )
    {
        $form= $this->createFormBuilder()
            ->add('email',  TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Email([
                        'message' => 'The email {{ value }} is not a valid email.',
                    ])
                ],
            ])
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Regex(['pattern' => '/[a-zA-Z]+$/',
                        'match' => true]),
                    new Type([
                        'type' => 'string',
                        'message' => 'The value {{ value }} is not a valid {{ type }}.'
                    ])
                ],
            ])
            ->add('surname', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Regex(['pattern' => '/[a-zA-Z]+$/',
                        'match' => true]),
                    new Type([
                        'type' => 'string',
                        'message' => 'The value {{ value }} is not a valid {{ type }}.',
                    ])
                ],
            ])
            ->add('phone_number',TextType::class, [
                'constraints' =>[
                    new Length(['min' => 9])
                ]
            ]
            )
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => ['label' =>'Hasło'],
                'second_options' => ['label' =>'Powtórz hasło'],
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 8])
                ],
            ])
            ->add('register', SubmitType::class, [
                'attr'=>[
                    'class'=>'btn btn-success float-rignt'
            ]])
            ->getForm()
        ;
            $form->handleRequest($request);
            if($form ->isSubmitted() && $form->isValid()){
                $data = $form->getData();
                $user = new User();
                $user->setEmail($data['email']);
                $user->setName($data['name']);
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
