<?php

namespace App\Repositories\API\V1\Property\Type;

use App\Models\PropertyType;
use Exception;
use Illuminate\Support\Facades\Log;

class PropertyTypeRepository implements PropertyTypeRepositoryInterface
{
    /**
     * getList
     * @return \Illuminate\Database\Eloquent\Collection<int, PropertyType>
     */
    public function getList()
    {
        try {
            return PropertyType::all();
        }catch (Exception $e) {
            Log::error('PropertyTypeRepository::getList', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
