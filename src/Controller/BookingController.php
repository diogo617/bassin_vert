<?php

namespace App\Controller;

use App\Entity\QuoteRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookingController extends AbstractController
{
    #[Route('/api/bookings', name: 'api_bookings', methods: ['GET'])]
    public function getBookings(EntityManagerInterface $entityManager): Response
    {
        // Fetch all quotes that have a scheduled time
        $quotes = $entityManager->getRepository(QuoteRequest::class)->findAll();
        $unavailabilities = $entityManager->getRepository(\App\Entity\Unavailability::class)->findAll();

        $events = [];
        foreach ($quotes as $quote) {
            if ($quote->getScheduledAt()) {
                $events[] = [
                    'id' => 'quote_' . $quote->getId(),
                    'title' => 'Réservé',
                    'start' => $quote->getScheduledAt()->format('Y-m-d\TH:i:s'),
                    'end' => $quote->getScheduledAt()->modify('+1 hour')->format('Y-m-d\TH:i:s'), // Assume 1hr slots
                    'display' => 'background',
                    'color' => '#ff9f89',
                    'extendedProps' => [
                        'type' => 'booking',
                        'status' => $quote->getStatus()
                    ]
                ];
            }
        }

        foreach ($unavailabilities as $unavailability) {
            $events[] = [
                'id' => 'block_' . $unavailability->getId(),
                'title' => 'Indisponible',
                'start' => $unavailability->getStartTime()->format('Y-m-d\TH:i:s'),
                'end' => $unavailability->getEndTime()->format('Y-m-d\TH:i:s'),
                'display' => 'background',
                'color' => '#888888',
                'extendedProps' => ['type' => 'blocked']
            ];
        }

        return $this->json($events);
    }
}
