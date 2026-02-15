<?php

namespace App\Controller;

use App\Document\Review;
use App\Form\ReviewType;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReviewController extends AbstractController
{
    #[Route('/avis/nouveau', name: 'app_review_new')]
    public function new(Request $request, DocumentManager $dm): Response
    {
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $review->setCreatedAt(new \DateTime());
            // By default, reviews might be visible or require moderation. 
            // The entity defaults isVisible to false, so let's set it to true for now unless moderation is requested.
            // For now, I'll set it to true to see it immediately, or keep false if I want to simulate moderation.
            // Let's set it to true for immediate feedback for this demo/task.
            $review->setIsVisible(true);

            $dm->persist($review);
            $dm->flush();

            $this->addFlash('success', 'Votre avis a été ajouté avec succès !');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('review/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
