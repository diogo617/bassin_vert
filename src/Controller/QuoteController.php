<?php

namespace App\Controller;

use App\Entity\QuoteRequest;
use App\Form\QuoteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class QuoteController extends AbstractController
{
    #[Route('/quote', name: 'app_quote')]
    public function request(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $quoteRequest = new QuoteRequest();

        // If user is logged in, pre-fill data
        if ($this->getUser()) {
            /** @var \App\Entity\User $user */
            $user = $this->getUser();
            $quoteRequest->setUser($user);
            $quoteRequest->setContactEmail($user->getEmail());
        }

        $form = $this->createForm(QuoteType::class, $quoteRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads/quotes',
                        $newFilename
                    );
                    $quoteRequest->setImagePath($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Failed to upload image.');
                }
            }

            $quoteRequest->setStatus('pending');

            $entityManager->persist($quoteRequest);
            $entityManager->flush();

            $this->addFlash('success', 'Your quote request has been sent successfully! We will contact you shortly.');

            return $this->redirectToRoute('app_home');
        }

        $scheduleRepo = $entityManager->getRepository(\App\Entity\Schedule::class);
        $schedules = $scheduleRepo->findBy([], ['dayOfWeek' => 'ASC']);

        $businessHours = [];
        foreach ($schedules as $s) {
            if ($s->isActive()) {
                // FullCalendar days: 0=Sun, 1=Mon, etc. PHP(N): 1=Mon, 7=Sun
                $fcDay = $s->getDayOfWeek() == 7 ? 0 : $s->getDayOfWeek();

                $businessHours[] = [
                    'daysOfWeek' => [$fcDay],
                    'startTime' => $s->getStartTime() ? $s->getStartTime()->format('H:i') : '00:00',
                    'endTime' => $s->getEndTime() ? $s->getEndTime()->format('H:i') : '23:59',
                ];
            }
        }

        return $this->render('quote/request.html.twig', [
            'quoteForm' => $form->createView(),
            'businessHours' => $businessHours,
        ]);
    }
}
