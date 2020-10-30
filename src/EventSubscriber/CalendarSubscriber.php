<?php

namespace App\EventSubscriber;

use App\Entity\Classes;
use CalendarBundle\Entity\Event;
use CalendarBundle\CalendarEvents;
use App\Repository\ClassesRepository;

use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CalendarSubscriber implements EventSubscriberInterface
{

    private $classesRepository;
    private $router;

    public function __construct(
        ClassesRepository $classesRepository,
        UrlGeneratorInterface $router
    ) {
        $this->classesRepository = $classesRepository;
        $this->router = $router;
    }


    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        
        //$start = $calendar->getStart();
        $start='2020-08-10 00:00:00';
        //$dump($start);die;
        $end='2021-08-10 00:00:00';
        //$end = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // Modify the query to fit to your entity and needs
        // Change booking.beginAt by your start date property
        //$bookings=$em->getRepository(Classes::class)->findAll();
        $zajeciaa=$this->classesRepository->findAll();
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

            $bookingEvent->setOptions([
                'backgroundColor' => 'red',
                'borderColor' => 'red',
            ]);
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