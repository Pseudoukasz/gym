<?php

namespace App\EventSubscriber;

use App\Entity\Zajecia;
use CalendarBundle\Entity\Event;
use CalendarBundle\CalendarEvents;
use App\Repository\ZajeciaRepository;

use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CalendarSubscriber implements EventSubscriberInterface
{

    private $zajeciaRepository;
    private $router;

    public function __construct(
        ZajeciaRepository $zajeciaRepository,
        UrlGeneratorInterface $router
    ) {
        $this->zajeciaRepository = $zajeciaRepository;
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
        //$bookings=$em->getRepository(Zajecia::class)->findAll();
        $zajeciaa=$this->zajeciaRepository->findAll();
        /*
        $zajeciaa = $this->zajeciaRepository
            ->createQueryBuilder('zajecia')
            ->where('zajecia.data BETWEEN :start and :end')
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
                $zajecia->getNazwa(),
                $zajecia->getData(),
                $zajecia->getDatazak()
                //$zajecia->getIdTrener(),
                //$zajecia->getSala() // If the end date is null or not defined, a all day event is created.
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