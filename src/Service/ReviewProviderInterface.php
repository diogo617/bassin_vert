<?php

namespace App\Service;

interface ReviewProviderInterface
{
    /**
     * @return array Returns an array of review data (objects or arrays)
     */
    public function getLatestReviews(): array;
}
