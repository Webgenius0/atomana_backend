<?php

namespace App\Repositories\API\V1\Property\Type;

use App\Models\PropertyType;

interface PropertyTypeRepositoryInterface
{

    /**
     * getList
     * @return \Illuminate\Database\Eloquent\Collection<int, PropertyType>
     */
    public function getList();
}
