<?php

namespace App\Controller;

use App\Document\Review;
use App\Entity\QuoteRequest;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'admin_dashboard')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Fetch recent quotes for the list
        $recentQuotes = $entityManager->getRepository(QuoteRequest::class)->findBy(
            [],
            ['createdAt' => 'DESC'],
            5
        );

        $scheduleRepo = $entityManager->getRepository(\App\Entity\Schedule::class);
        $schedules = $scheduleRepo->findBy([], ['dayOfWeek' => 'ASC']);

        $businessHours = [];
        foreach ($schedules as $s) {
            if ($s->isActive()) {
                $fcDay = $s->getDayOfWeek() == 7 ? 0 : $s->getDayOfWeek();
                $businessHours[] = [
                    'daysOfWeek' => [$fcDay],
                    'startTime' => $s->getStartTime() ? $s->getStartTime()->format('H:i') : '00:00',
                    'endTime' => $s->getEndTime() ? $s->getEndTime()->format('H:i') : '23:59',
                ];
            }
        }

        return $this->render('admin/dashboard.html.twig', [
            'recentQuotes' => $recentQuotes,
            'businessHours' => $businessHours,
        ]);
    }

    #[Route('/reviews', name: 'admin_reviews')]
    public function reviews(DocumentManager $dm): Response
    {
        $reviews = $dm->getRepository(Review::class)->findBy([], ['createdAt' => 'DESC']);

        return $this->render('admin/reviews.html.twig', [
            'reviews' => $reviews,
        ]);
    }

    #[Route('/reviews/toggle/{id}', name: 'admin_review_toggle')]
    public function toggleReview(string $id, DocumentManager $dm): Response
    {
        $review = $dm->getRepository(Review::class)->find($id);

        if ($review) {
            $review->setIsVisible(!$review->isVisible());
            $dm->flush();
            $this->addFlash('success', 'Visibilité de l\'avis mise à jour.');
        }

        return $this->redirectToRoute('admin_reviews');
    }

    #[Route('/reviews/delete/{id}', name: 'admin_review_delete')]
    public function deleteReview(string $id, DocumentManager $dm): Response
    {
        $review = $dm->getRepository(Review::class)->find($id);

        if ($review) {
            $dm->remove($review);
            $dm->flush();
            $this->addFlash('success', 'Avis supprimé.');
        }

        return $this->redirectToRoute('admin_reviews');
    }
    #[Route('/unavailability/add', name: 'admin_unavailability_add', methods: ['POST'])]
    public function addUnavailability(Request $request, EntityManagerInterface $entityManager): Response
    {
        $start = new \DateTimeImmutable($request->request->get('start'));
        $end = new \DateTimeImmutable($request->request->get('end'));

        $unavailability = new \App\Entity\Unavailability();
        $unavailability->setStartTime($start);
        $unavailability->setEndTime($end);
        $unavailability->setReason('Bloqué par l\'admin');

        $entityManager->persist($unavailability);
        $entityManager->flush();

        return $this->json(['status' => 'success', 'id' => $unavailability->getId()]);
    }

    #[Route('/unavailability/delete/{id}', name: 'admin_unavailability_delete', methods: ['DELETE'])]
    public function deleteUnavailability(int $id, EntityManagerInterface $entityManager): Response
    {
        $unavailability = $entityManager->getRepository(\App\Entity\Unavailability::class)->find($id);

        if ($unavailability) {
            $entityManager->remove($unavailability);
            $entityManager->flush();
            return $this->json(['status' => 'success']);
        }

        return $this->json(['status' => 'error', 'message' => 'Non trouvé'], 404);
    }

    #[Route('/schedule', name: 'admin_schedule', methods: ['GET', 'POST'])]
    public function schedule(Request $request, EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(\App\Entity\Schedule::class);
        $schedules = $repository->findBy([], ['dayOfWeek' => 'ASC']);

        // Initialize if empty
        if (count($schedules) < 7) {
            for ($i = 1; $i <= 7; $i++) {
                $exists = false;
                foreach ($schedules as $s) {
                    if ($s->getDayOfWeek() === $i) {
                        $exists = true;
                        break;
                    }
                }
                if (!$exists) {
                    $schedule = new \App\Entity\Schedule();
                    $schedule->setDayOfWeek($i);
                    $schedule->setIsActive($i <= 5); // Default Mon-Fri active
                    if ($i <= 5) {
                        $schedule->setStartTime(new \DateTime('09:00'));
                        $schedule->setEndTime(new \DateTime('18:00'));
                    }
                    $entityManager->persist($schedule);
                }
            }
            $entityManager->flush();
            $schedules = $repository->findBy([], ['dayOfWeek' => 'ASC']);
        }

        if ($request->isMethod('POST')) {
            foreach ($schedules as $schedule) {
                $dayId = $schedule->getDayOfWeek();
                $isActive = $request->request->has('active_' . $dayId);
                $startTimeStr = $request->request->get('start_' . $dayId);
                $endTimeStr = $request->request->get('end_' . $dayId);

                $schedule->setIsActive($isActive);
                if ($isActive && $startTimeStr && $endTimeStr) {
                    $schedule->setStartTime(new \DateTime($startTimeStr));
                    $schedule->setEndTime(new \DateTime($endTimeStr));
                }
                $entityManager->persist($schedule);
            }
            $entityManager->flush();
            $this->addFlash('success', 'Horaires mis à jour avec succès.');
            return $this->redirectToRoute('admin_schedule');
        }

        return $this->render('admin/schedule.html.twig', [
            'schedules' => $schedules
        ]);
    }

    #[Route('/calendar', name: 'admin_calendar')]
    public function calendar(EntityManagerInterface $entityManager): Response
    {
        $appointments = $entityManager->getRepository(QuoteRequest::class)->createQueryBuilder('q')
            ->where('q.scheduledAt IS NOT NULL')
            ->getQuery()
            ->getResult();

        $scheduleRepo = $entityManager->getRepository(\App\Entity\Schedule::class);
        $schedules = $scheduleRepo->findBy([], ['dayOfWeek' => 'ASC']);

        $businessHours = [];
        foreach ($schedules as $s) {
            if ($s->isActive()) {
                if ($s->getDayOfWeek() == 7) {
                    $fcDay = 0;
                } else {
                    $fcDay = $s->getDayOfWeek();
                }

                $businessHours[] = [
                    'daysOfWeek' => [$fcDay],
                    'startTime' => $s->getStartTime() ? $s->getStartTime()->format('H:i') : '00:00',
                    'endTime' => $s->getEndTime() ? $s->getEndTime()->format('H:i') : '23:59',
                ];
            }
        }

        return $this->render('admin/calendar.html.twig', [
            'appointments' => $appointments,
            'businessHours' => $businessHours // Pass to template
        ]);
    }

    #[Route('/quote/{id}/accept', name: 'admin_quote_accept')]
    public function acceptQuote(int $id, EntityManagerInterface $entityManager): Response
    {
        $quote = $entityManager->getRepository(QuoteRequest::class)->find($id);

        if ($quote) {
            // Check if appointment already exists for this quote to avoid duplicates
            // We can match by date and user for now, or just trust the admin won't spam click (better is to check)
            /* 
             * Ideally we'd have a OneToOne relation or a quote ID in Appointment, 
             * but for now let's just create it if the quote wasn't already accepted 
             * or if we want to allow re-creating. 
             * Given the current simple state, let's just create it.
             */

            if ($quote->getStatus() !== 'ACCEPTED') {
                $appointment = new \App\Entity\Appointment();
                $appointment->setServiceType($quote->getServiceType());
                $appointment->setGardenSize($quote->getGardenSize());
                $appointment->setLocation($quote->getLocation());
                $appointment->setScheduledAt($quote->getScheduledAt());
                $appointment->setUser($quote->getUser());
                $appointment->setStatus('CONFIRMED');

                // If quote has image, we might want to carry it over? 
                // Appointment has imageFilename, QuoteRequest has imagePath.
                if ($quote->getImagePath()) {
                    $appointment->setImageFilename($quote->getImagePath());
                }

                $entityManager->persist($appointment);

                $quote->setStatus('ACCEPTED');
                $entityManager->flush();
                $this->addFlash('success', 'Rendez-vous accepté et ajouté au calendrier.');
            } else {
                $this->addFlash('warning', 'Le rendez-vous a déjà été accepté.');
            }

        } else {
            $this->addFlash('error', 'Demande de rendez-vous non trouvée.');
        }

        return $this->redirectToRoute('admin_calendar');
    }
}
