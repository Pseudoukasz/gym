<?php

namespace App\Controller;

use App\Entity\Zajecia;
use App\Form\ZajeciaType;
use App\Repository\ZajeciaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        return $this->render('zajecia/index.html.twig', [
            'zajecias' => $zajeciaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="zajecia_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $zajecium = new Zajecia();
        $form = $this->createForm(ZajeciaType::class, $zajecium);
       // $form = $this->createFormBuilder()
        //->add('data', )
        // tu skonczyłem, zrobic formulaz dodajocy wydazenie, ogarnać wyświetlanie kaledarza

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($zajecium);
            $entityManager->flush();

            return $this->redirectToRoute('zajecia_index');
        }

        return $this->render('zajecia/new.html.twig', [
            'zajecium' => $zajecium,
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
        return $this->render('booking/calendar.html.twig');
    }

}
