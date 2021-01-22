<?php

namespace App\EventSubscriber;

use App\Repository\ReservationsRepository;
use CalendarBundle\Entity\Event;
use CalendarBundle\CalendarEvents;
use App\Repository\ClassesRepository;
use App\Repository\SignForClassesRepository;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Security;

class CalendarSubscriber implements EventSubscriberInterface
{

    private $classesRepository;
    private $reservationsRepository;
    private $signForClassesRepository;
    private $router;
    private $security;
    private $user;

    public function __construct(
        ClassesRepository $classesRepository,
        UrlGeneratorInterface $router,
        SignForClassesRepository $signForClassesRepository,
        Security $security,
        ReservationsRepository $reservationsRepository
    ) {
        $this->classesRepository = $classesRepository;
        $this->signForClassesRepository = $signForClassesRepository;
        $this->router = $router;
        $this->security = $security;
        $this->reservationsRepository = $reservationsRepository;
    }


    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        dump($calendar);
        //$start = $calendar->getStart();
        $start='2020-08-10 00:00:00';
        //$dump($start);die;
        $end='2021-08-10 00:00:00';
        //$end = $calendar->getEnd();
        $filters = $calendar->getFilters();
        dump($filters);
        // Modify the query to fit to your entity and needs
        // Change booking.beginAt by your start date property
        //$bookings=$em->getRepository(Classes::class)->findAll();
        if ($filters['roomId'] == 'all'){
            $zajeciaa=$this->classesRepository->findAll();
        } else
            $zajeciaa=$this->classesRepository->findBy(['room' => $filters['roomId']]);

        $reservations = $this->reservationsRepository->findBy(['user' =>  $this->security->getUser()]);
        foreach ($reservations as $reservation){
            $bookingEvent = new Event(
                'rezerwacja sali:'.$reservation->getRoom()->getName(),
                $reservation->getDateStart(),
                $reservation->getDateEnd()
            );
            $bookingEvent->setOptions(
                [
                    'backgroundColor' => 'brown',
                    'borderColor' => 'brown',
                ]
            );
            $calendar->addEvent($bookingEvent);
        }

        /*
        $zajeciaa = $this->zajeciaRepository
            ->createQueryBuilder('classes')
            ->where('classes.data BETWEEN :start and :end')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            //->setParameter('start', $start->format('Y-m-d H:i:s'))
            //->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ; */
        dump($zajeciaa);
        
        foreach ($zajeciaa as $zajecia) {
            // this create the events with your data (here booking data) to fill calendar
            $bookingEvent = new Event(
                $zajecia->getName(),
                $zajecia->getDateStart(),
                $zajecia->getDateEnd()
                //$classes->getIdTrener(),
                //$classes->getSala() // If the end date is null or not defined, a all day event is created.
            );

            /*
             * Add custom options to events
             *
             * For more information see: https://fullcalendar.io/docs/event-object
             * and: https://github.com/fullcalendar/fullcalendar/blob/master/src/core/options.ts
             */
            //var_dump($zajecia->getId());die;
            //$zajecia->getId();

            //var_dump($id);
            if($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {

                if ($zajecia->getRoom()->getMaxNumberOfUsers() <= count($this->signForClassesRepository->findBy(['classes' => $zajecia->getId()]))) {

                    $bookingEvent->setOptions(
                        [
                            'backgroundColor' => 'red',
                            'borderColor' => 'red',
                        ]
                    );
                } else if ($this->signForClassesRepository->findOneBy(['classes' => $zajecia->getId(), 'user' => $this->security->getUser()])) {
                    $bookingEvent->setOptions(
                        [
                            'backgroundColor' => 'blue',
                            'borderColor' => 'blue',
                        ]
                    );
                }else {
                    $bookingEvent->setOptions(
                        [
                            'backgroundColor' => 'green',
                            'borderColor' => 'green',
                        ]
                    );
                }
            } else {
                $bookingEvent->setOptions(
                    [
                        'backgroundColor' => 'green',
                        'borderColor' => 'green',
                    ]
                );
            }

            $bookingEvent->addOption(
                'url',
                $this->router->generate('zajecia_show', [
                    'id' => $zajecia->getId(),
                ])
            );

            // finally, add the event to the CalendarEvent to fill the calendar
            $calendar->addEvent($bookingEvent);
        }
    }    
}