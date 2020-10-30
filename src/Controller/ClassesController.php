<?php

namespace App\Controller;

use App\Entity\Rooms;
use App\Entity\Classes;
use App\Entity\User;
use App\Entity\Trainers;
use App\Entity\SignForClasses;
use App\Form\ClassesType;
use App\Repository\ClassesRepository;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/**
 * @Route("/classes")
 */
class ClassesController extends AbstractController
{
    /**
     * @Route("/", name="zajecia_index", methods={"GET"})
     */
    public function index(ClassesRepository $classesRepository): Response
    {
        $zz=$classesRepository->findAll();
        //dump($zajecium);
        //$zajecia1=$zz['0'];
        //$sala=$zajecia1->Sala;
        //dump($zz,$zajecia1);
        return $this->render('classes/index.html.twig', [
            //'classes' => $classesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="zajecia_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $em=$this->getDoctrine()->getManager();
        $sale=$this->getDoctrine()->getRepository(Rooms::class)->findAll();
        $zajecia = new Classes();
        $id=$this->getUser()->getSurname();
        
        $trener=$em->getRepository(Trainers::class)->findOneBy(['surname' => $id]);


        
        //$form = $this->createForm(ClassesType::class, $zajecium);
        $form = $this->createFormBuilder()
            ->add('nazwa')
            /*->add('data', DateTimeType::class,[
                'placeholder' => [
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                    'hour' => 'Hour', 'minute' => 'Minute',
                ]
            ])*/
            ->add('data', DateTimeType::class,[
                'date_widget' => 'single_text',
                'attr' => ['class' => 'form_datetime'],
                'placeholder' => [
                    'hour' => 'Hour', 'minute' => 'Minute',
                ]
            ])
            ->add('datazak', DateTimeType::class,[
                'date_widget' => 'single_text',
                'attr' => ['class' => 'form_datetime'],
                'placeholder' => [
                    'hour' => 'Hour', 'minute' => 'Minute',
                ]
            ])
            /*->add('datazak', DateType::class,[
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker']
            ])*/
            ->add('sala', EntityType::class,[
                'class'=>Rooms::class,
                'choice_label'=>'name',
            ])
            /*
            ->add('idTrener', HiddenType::class,[
                'data' => $trener
            ]) */
            ->add('zapisz', SubmitType::class, [
                'attr'=>[
                    'class'=>'btn btn-danger float-rignt'
            ]])
            ->getForm();    
            
        // tu skonczyłem, zrobic formulaz dodajocy wydazenie, ogarnać wyświetlanie kaledarza

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $data = $form->getData();
            dump($data);
            $zajecia->setName($data['nazwa']);
            $zajecia->setDateStart($data['data']);
            $zajecia->setDateEnd($data['datazak']);
            $zajecia->setRoom($data['sala']);
            $zajecia->setTrainer($trener);
            //$classes->setIdTrener($data['idTrener']);
            $entityManager->persist($zajecia);
            $entityManager->flush();

            return $this->redirectToRoute('zajecia_index');
        }

        return $this->render('classes/new.html.twig', [
            //'zajecium' => $zajecium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="zajecia_show", methods={"GET"})
     */
    public function show(Classes $class): Response
    {
        
        return $this->render('classes/show.html.twig', [
            'class' => $class,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="zajecia_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Classes $zajecium): Response
    {
        
        $form = $this->createForm(ClassesType::class, $zajecium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('zajecia_index');
        }

        return $this->render('classes/edit.html.twig', [
            'zajecium' => $zajecium,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}/sign", name="sign_for_classes", methods={"GET","POST"})
     */
    public function signForClasses(Request $request, Classes $zajecium): Response
    {
        $idZajecia=$zajecium->getId();
        $user=$this->getUser();
        $zapis = new SignForClasses();
        $entityManager = $this->getDoctrine()->getManager();

        $zapis->setUser($user);
        $zapis->setClasses($zajecium);
        $entityManager->persist($zapis);
        $entityManager->flush();
        //dump($idZajecia, $user, $request, $zajecium);die;

        return $this->redirectToRoute('zajecia_index');
    }


    /**
     * @Route("/{id}", name="zajecia_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Classes $zajecium): Response
    {
        if ($this->isCsrfTokenValid('delete'.$zajecium->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($zajecium);
            $entityManager->flush();
        }

        return $this->redirectToRoute('zajecia_index');
    }

     /**
     * @Route("/calendar", name="calendar", methods={"GET"})
     */
    public function calendar(): Response
    {
        return $this->render('zajecia/calendar.html.twig');
    }

}
