<?php

namespace App\Controller;

use App\Entity\MembershipsType;
use App\Entity\Rooms;
use App\Entity\User;
use App\Entity\Trainers;
use App\Form\MembershipType;
use App\Form\RoomsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
        $em = $this->getDoctrine()->getManager();
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $rooms = $this->getDoctrine()->getRepository(Rooms::class)->findAll();
        $membershipsTypes = $this->getDoctrine()->getRepository(MembershipsType::class)->findAll();
        $addRoomForm = $this->createForm(RoomsType::class);
        $addMembershipTypeForm = $this->createForm(MembershipType::class);
        $form = $this->createFormBuilder()
            ->add(
                'user',
                EntityType::class,
                [
                    'class' => User::class,
                    'choice_label' => 'email',
                ]
            )
            ->add(
                'rola',
                ChoiceType::class,
                [
                    'choices' => [
                        ' ' => '',
                        'trener' => 'ROLE_TRAINER',
                        // 'klient'=>'ROLE_CUSTOMER',
                        'admin' => 'ROLE_ADMIN',
                    ],
                ]
            )
            ->add(
                'zapisz',
                SubmitType::class,
                [
                    'attr' => [
                        'class' => 'btn btn-danger float-rignt',
                    ],
                ]
            )
            ->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $data = $form->getData();
            $user = $em->getRepository(User::class)->find($data['user']);

            //$role = $user->getRoles();
            //$user->setRoles([$role, $data['rola']]);
            if ($data['rola'] == "ROLE_TRAINER") {
                $imie = $user->getName();
                $nazwisko = $user->getSurname();
                $trener = new Trainers();
                $trener->setName($imie);
                $trener->setSurname($nazwisko);
                //$trener->setImie($imie);
                //$trener->setNazwisko($user['nazwisko']);
                $em = $this->getDoctrine()->getManager();
                $em->persist($trener);
                $em->flush();
                //var_dump($user);

            }
            dump($data, $user);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('admin');
        }
        $addRoomForm->handleRequest($request);
        if ($addRoomForm->isSubmitted()) {
            $dataRoomForm = $addRoomForm->getData();
            $room = new Rooms();
            $room->setName($dataRoomForm['name']);
            $room->setMaxNumberOfUsers($dataRoomForm['maxNumberOfUsers']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($room);
            $em->flush();

            return $this->redirectToRoute('admin');
        }
        $addMembershipTypeForm->handleRequest($request);
        if ($addMembershipTypeForm->isSubmitted()) {
            $dataMembershipForm = $addMembershipTypeForm->getData();
            $membershipType = new MembershipsType();
            $membershipType->setName($dataMembershipForm['name']);
            $membershipType->setDuration($dataMembershipForm['duration']);
            $membershipType->setType($dataMembershipForm['type']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($membershipType);
            $em->flush();

            return $this->redirectToRoute('admin');
        }

        //dump($users);die;
        return $this->render(
            'admin/index.html.twig',
            [
                'controller_name' => 'AdminController',
                'users' => $users,
                'form' => $form->createView(),
                'room_form' => $addRoomForm->createView(),
                'rooms' => $rooms,
                'membership_form' => $addMembershipTypeForm->createView(),
                'memberships' => $membershipsTypes,
            ]
        );
    }

    public function nadaj_uprawnienia(Request $request)
    {


        return $this->render(
            'admin/index.html.twig',
            [

            ]
        );
    }
    /**
     * @Route("/admin/{id}", name="membership_type_delete", methods={"DELETE"})
     */
    public function deleteMembershipType(MembershipsType $membershipsType): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        $em = $this->getDoctrine()->getManager();
        $em->remove($membershipsType);
        $em->flush();
        return new Response(null, 204);
    }
    /**
     * @Route("/admin/r/{id}", name="room_delete", methods={"DELETE"})
     */
    public function deleteRoom(Rooms $rooms): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        $em = $this->getDoctrine()->getManager();
        $em->remove($rooms);
        $em->flush();
        return new Response(null, 204);
    }
}
