<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;



use App\Service\ReviewProviderInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ReviewProviderInterface $reviewProvider): Response
    {
        $reviews = $reviewProvider->getLatestReviews();

        return $this->render('home/index.html.twig', [
            'reviews' => $reviews,
        ]);
    }
}
