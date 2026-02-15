<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ServicesController extends AbstractController
{
    #[Route('/services', name: 'app_services')]
    public function index(): Response
    {
        $services = [
            [
                'title' => 'Tonte de Pelouse & Entretien',
                'description' => 'Tonte régulière, bordures et fertilisation pour garder votre pelouse luxuriante.',
                'icon' => '🌱',
            ],
            [
                'title' => 'Création de Jardin Zen',
                'description' => 'Conception et installation de jardins de rocaille paisibles, paysages de mousse et points d\'eau.',
                'icon' => '🪨',
            ],
            [
                'title' => 'Taille de Haies',
                'description' => 'Taille de précision pour les haies et arbustes afin de maintenir forme et santé.',
                'icon' => '✂️',
            ],
            [
                'title' => 'Plantation Saisonnière',
                'description' => 'Sélection et plantation de fleurs et bulbes saisonniers pour de la couleur toute l\'année.',
                'icon' => '🌻',
            ],
            [
                'title' => 'Nettoyage de Jardin',
                'description' => 'Nettoyage complet de jardins envahis, y compris l\'enlèvement des déchets.',
                'icon' => '🍂',
            ],
        ];

        return $this->render('services/index.html.twig', [
            'services' => $services,
        ]);
    }
}
