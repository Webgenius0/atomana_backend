<?php

namespace App\Repositories\API\V1\Property;

use App\Helpers\Helper;
use App\Models\Property;
use Exception;
use Illuminate\Support\Facades\Log;

class PropertyRepository implements PropertyRepositoryInterface
{
    /**
     * properties Of the Business
     * @param int $businessId
     */
    public function propertiesOftheBusiness(int $businessId)
    {
        try {
            $properties = Property::select('id', 'address')->whereBusinessId($businessId)->get();
            return $properties;
        } catch (Exception $e) {
            Log::error('PropertyRepository::propertiesOftheBusiness', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * properties Of The Agent
     * @param int $userId
     */
    public function propertiesOfTheAgent(int $userId)
    {
        try {
            $properties = Property::select('id', 'address')->whereUserId($userId)->get();
            return $properties;
        } catch (Exception $e) {
            Log::error('PropertyRepository::propertiesOfTheAgent', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Creating a property
     * @param array $credentials
     * @param int $userId
     * @param int $businessId
     * @return Property
     */
    public function createProperty(array $credentials, int $userId, int $businessId):Property
    {
        try {
            return Property::create([
                'business_id' => $businessId,
                'agent' => $userId,
                'sku' => Helper::generateUniqueId('properties', 'sku'),
                'email' => $credentials['email'],
                'address' => $credentials['address'],
                'price' => $credentials['price'],
                'expiration_date' => $credentials['expiration_date'],
                'development' => $credentials['development'],
                'co_agent' => $credentials['co_agent'],
                'co_list_percentage' => $credentials['co_list_percentage'],
                'source' => $credentials['source'],
            ]);
        } catch (Exception $e) {
            Log::error('PropertyRepository::createProperty', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
