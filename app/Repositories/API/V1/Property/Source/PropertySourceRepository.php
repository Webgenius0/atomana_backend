<?php

namespace App\Repositories\API\V1\Property\Source;

use App\Models\PropertySource;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class PropertySourceRepository implements PropertySourceRepositoryInterface
{
    /**
     * getSource
     * @return \Illuminate\Database\Eloquent\Collection<int, PropertySource>
     */
    public function getSource(): Collection
    {
        try {
            return PropertySource::select('id', 'name')->get();
        }catch(Exception $e)
        {
            Log::error("App\Repositories\API\V1\Property\Source\PropertySourceRepository::getSource", ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
