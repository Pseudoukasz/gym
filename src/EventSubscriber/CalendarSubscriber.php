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
        $filters = $calendar->getFilters();
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
            $bookingEvent->setOptions([
                    'backgroundColor' => 'brown',
                    'borderColor' => 'brown',
                ]);
            $calendar->addEvent($bookingEvent);
        }
        foreach ($zajeciaa as $zajecia) {
            $bookingEvent = new Event(
                $zajecia->getName(),
                $zajecia->getDateStart(),
                $zajecia->getDateEnd()
            );
            if($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
                if ($zajecia->getRoom()->getMaxNumberOfUsers() <= count($this->signForClassesRepository->findBy(['classes' => $zajecia->getId()]))){
                    $bookingEvent->setOptions([
                            'backgroundColor' => 'red',
                            'borderColor' => 'red',
                        ]);
                } else if ($this->signForClassesRepository->findOneBy(['classes' => $zajecia->getId(), 'user' => $this->security->getUser()])) {
                    $bookingEvent->setOptions([
                            'backgroundColor' => 'blue',
                            'borderColor' => 'blue',
                        ]);
                }else {
                    $bookingEvent->setOptions([
                            'backgroundColor' => 'green',
                            'borderColor' => 'green',
                        ]);
                }
            } else {
                $bookingEvent->setOptions([
                        'backgroundColor' => 'green',
                        'borderColor' => 'green',
                    ]);
            }
            $bookingEvent->addOption(
                'url',
                $this->router->generate('zajecia_show', [
                    'id' => $zajecia->getId(),
                ])
            );
            $calendar->addEvent($bookingEvent);
        }
    }    
}