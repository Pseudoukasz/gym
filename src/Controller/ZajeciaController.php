<?php

namespace App\Controller;

use App\Entity\Sale;
use App\Entity\Zajecia;
use App\Entity\User;
use App\Entity\Trener;
use App\Form\ZajeciaType;
use App\Repository\ZajeciaRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/**
 * @Route("/zajecia")
 */
class ZajeciaController extends AbstractController
{
    /**
     * @Route("/", name="zajecia_index", methods={"GET"})
     */
    public function index(ZajeciaRepository $zajeciaRepository): Response
    {
        $zz=$zajeciaRepository->findAll();
        dump($zz);
        return $this->render('zajecia/index.html.twig', [
            'zajecias' => $zajeciaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="zajecia_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $em=$this->getDoctrine()->getManager();
        $sale=$this->getDoctrine()->getRepository(Sale::class)->findAll();
        $zajecia = new Zajecia();
        $id=$this->getUser()->getNazwisko();
        
        $trener=$em->getRepository(Trener::class)->findOneBy(['Nazwisko' => $id]);
        
        
        //$form = $this->createForm(ZajeciaType::class, $zajecium);
        $form = $this->createFormBuilder()
            ->add('nazwa')
            ->add('data', DateTimeType::class,[ 
                'placeholder' => [
                'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                'hour' => 'Hour', 'minute' => 'Minute',
            ] 
            ])
            ->add('datazak', DateTimeType::class,[ 
                'placeholder' => [
                'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                'hour' => 'Hour', 'minute' => 'Minute',
            ] 
            ])
            ->add('sala', EntityType::class,[
                'class'=>Sale::class,
                'choice_label'=>'nazwa',
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
            $zajecia->setNazwa($data['nazwa']);
            $zajecia->setData($data['data']);
            $zajecia->setDatazak($data['datazak']);
            $zajecia->setSala($data['sala']);
            $zajecia->setIdTrener($trener);
            //$zajecia->setIdTrener($data['idTrener']);
            $entityManager->persist($zajecia);
            $entityManager->flush();

            return $this->redirectToRoute('zajecia_index');
        }

        return $this->render('zajecia/new.html.twig', [
            //'zajecium' => $zajecium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="zajecia_show", methods={"GET"})
     */
    public function show(Zajecia $zajecium): Response
    {
        
        return $this->render('zajecia/show.html.twig', [
            'zajecium' => $zajecium,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="zajecia_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Zajecia $zajecium): Response
    {
        $form = $this->createForm(ZajeciaType::class, $zajecium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('zajecia_index');
        }

        return $this->render('zajecia/edit.html.twig', [
            'zajecium' => $zajecium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="zajecia_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Zajecia $zajecium): Response
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
