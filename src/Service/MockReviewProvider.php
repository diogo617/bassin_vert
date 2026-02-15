<?php

namespace App\Service;

class MockReviewProvider implements ReviewProviderInterface
{
    public function getLatestReviews(): array
    {
        // Simulate MongoDB Documents
        return [
            [
                'customerName' => 'Alice Dupont',
                'rating' => 5,
                'comment' => 'Excellent work! My garden looks like a zen paradise.',
                'createdAt' => new \DateTime('-2 days'),
            ],
            [
                'customerName' => 'Jean Martin',
                'rating' => 4,
                'comment' => 'Very professional. The moss garden installation is perfect.',
                'createdAt' => new \DateTime('-1 week'),
            ],
            [
                'customerName' => 'Sophie Bernard',
                'rating' => 5,
                'comment' => 'I love the dark aesthetic of the design. Highly recommended!',
                'createdAt' => new \DateTime('-3 weeks'),
            ],
            [
                'customerName' => 'Lucas Duboi',
                'rating' => 4,
                'comment' => 'Great service, but the booking calendar was a bit full!',
                'createdAt' => new \DateTime('-1 month'),
            ],
        ];
    }
}
