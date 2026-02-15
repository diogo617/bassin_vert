<?php

namespace App\Service;

use App\Document\Review;
use Doctrine\ODM\MongoDB\DocumentManager;

class MongoReviewProvider implements ReviewProviderInterface
{
    private $dm;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    public function getLatestReviews(): array
    {
        try {
            // Fetch top 3 recent reviews
            return $this->dm->getRepository(Review::class)->findBy(
                [],
                ['createdAt' => 'DESC'],
                3
            );
        } catch (\Exception $e) {
            // Fallback for connection errors
            return [];
        }
    }
}
