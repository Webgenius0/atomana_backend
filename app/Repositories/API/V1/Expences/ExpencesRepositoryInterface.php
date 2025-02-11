<?php

namespace App\Repositories\API\V1\Expences;

interface ExpencesRepositoryInterface
{
    public function storeExpence(array $credential);

    public function getExpences(string $type);
}
