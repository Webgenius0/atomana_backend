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
    public function propertiesOftheBusiness(int $businessId, int $perPage)
    {
        try {
            $properties = Property::select('id', 'address')->whereBusinessId($businessId)->paginate($perPage);
            return $properties;
        } catch (Exception $e) {
            Log::error('PropertyRepository::propertiesOftheBusiness', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    /**
     * searchPropertiesOfBusiness
     * @param int $businessId
     * @param string $searchKey
     */
    public function searchPropertiesOfBusiness(int $businessId, string $searchKey)
    {
        try {
            $properties = Property::select('id', 'address')->whereBusinessId($businessId)->where('address', 'like', '%' . $searchKey. '%')->get();;
            return $properties;
        } catch (Exception $e) {
            Log::error('PropertyRepository::searchPropertiesOfBusiness', ['error' => $e->getMessage()]);
            throw $e;
        }
    }



    /**
     * searchPropertiesOfTheAgent
     * @param int $userId
     * @param string $searchKey
     */
    public function searchPropertiesOfTheAgent(int $userId, string $searchKey)
    {
        try {
            $properties = Property::select('id', 'address')->whereAgent($userId)->where('address', 'like', '%' . $searchKey. '%')->get();
            return $properties;
        } catch (Exception $e) {
            Log::error('PropertyRepository::searchPropertiesOfTheAgent', ['error' => $e->getMessage()]);
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
                'business_id'        => $businessId,
                'agent'              => $userId,
                'sku'                => Helper::generateUniqueId('properties', 'sku'),
                'address'            => $credentials['address'],
                'price'              => $credentials['price'],
                'expiration_date'    => $credentials['expiration_date'],
                'is_development'     => $credentials['is_development'],
                'add_to_website'     => $credentials['add_to_website'] ?? false,
                'commission_rate'    => $credentials['commission_rate'],
                'is_co_listing'      => $credentials['is_co_listing'],
                'co_agent'           => $credentials['co_agent'],
                'co_list_percentage' => $credentials['co_list_percentage'],
                'property_source_id' => $credentials['property_source_id'],
                'beds'               => $credentials['beds'],
                'full_baths'         => $credentials['full_baths'],
                'half_baths'         => $credentials['half_baths'],
                'size'               => $credentials['size'],
                'link'               => $credentials['link'],
                'note'               => $credentials['note'],
            ]);
        } catch (Exception $e) {
            Log::error('PropertyRepository::createProperty', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * showById
     * @param int $propertyId
     * @return Property
     */
    public function showDetailsById(int $propertyId):Property
    {
        try {
            return Property::select([
                'id',
                'sku',
                'address',
                'price',
                'expiration_date',
                'is_development',
                'add_to_website',
                'commission_rate',
                'agent',
                'co_agent',
                'co_list_percentage',
                'property_source_id',
                'beds',
                'full_baths',
                'half_baths',
                'size',
                'link',
                'note',
                ])->
            with(['agent:id,first_name,last_name,handle,avatar', 'coAgent:id,first_name,last_name,handle,avatar'])
            ->findOrFail($propertyId);
        }catch (Exception $e) {
            Log::error('PropertyRepository::createProperty', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
