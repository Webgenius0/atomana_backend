<?php

namespace App\Repositories\API\V1\Property\Source;
use App\Models\PropertySource;
use Illuminate\Database\Eloquent\Collection;

interface PropertySourceRepositoryInterface
{
    /**
     * getSource
     * @return \Illuminate\Database\Eloquent\Collection<int, PropertySource>
     */
    public function getSource(): Collection;
}
