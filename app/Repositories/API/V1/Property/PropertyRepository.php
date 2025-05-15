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
            $properties = Property::select('id', 'address')->whereBusinessId($businessId)->orderBy('id', 'desc')->paginate($perPage);
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
            $properties = Property::select('id', 'address')->whereBusinessId($businessId)->where('address', 'like', '%' . $searchKey . '%')->get();;
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
            $properties = Property::select('id', 'address')->whereAgent($userId)->where('address', 'like', '%' . $searchKey . '%')->get();
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
    public function createProperty(array $credentials, int $userId, int $businessId): Property
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
    public function showDetailsById(int $propertyId): Property
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
            ])->with(['agent:id,first_name,last_name,handle,avatar', 'coAgent:id,first_name,last_name,handle,avatar'])
                ->findOrFail($propertyId);
        } catch (Exception $e) {
            Log::error('PropertyRepository::createProperty', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    /**
     * bulkDelete
     * @param array $ids
     * @return void
     */
    public function bulkDelete(array $ids): void
    {
        try {
            Property::destroy($ids);
        } catch (Exception $e) {
            Log::error('PropertyRepository:bulkDelete', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updatePrice
     * @param \App\Models\Property $property
     * @param mixed $price
     * @return void
     */
    public function updatePrice(Property $property, $price)
    {
        try {
            $property->price = $price;
            $property->save();
        } catch (Exception $e) {
            Log::error('PropertyRepository:updatePrice', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateExpirationDate
     * @param \App\Models\Property $property
     * @param mixed $expiration_date
     * @return void
     */
    public function updateExpirationDate(Property $property, $expiration_date)
    {
        try {
            $property->expiration_date = $expiration_date;
            $property->save();
        } catch (Exception $e) {
            Log::error('PropertyRepository:updateExpirationDate', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateCommisionRate
     * @param \App\Models\Property $property
     * @param mixed $commission_rate
     * @return void
     */
    public function updateCommisionRate(Property $property, $commission_rate)
    {
        try {
            $property->commission_rate = $commission_rate;
            $property->save();
        } catch (Exception $e) {
            Log::error('PropertyRepository:updateCommisionRate', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateIsDevelopment
     * @param \App\Models\Property $property
     * @param mixed $is_development
     * @return void
     */
    public function updateIsDevelopment(Property $property, $is_development)
    {
        try {
            $property->is_development = $is_development;
            $property->save();
        } catch (Exception $e) {
            Log::error('PropertyRepository:updateIsDevelopment', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateWebsite
     * @param \App\Models\Property $property
     * @param mixed $add_to_website
     * @return void
     */
    public function updateWebsite(Property $property, $add_to_website)
    {
        try {
            $property->add_to_website = $add_to_website;
            $property->save();
        } catch (Exception $e) {
            Log::error('PropertyRepository:updateWebsite', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updatePropertySource
     * @param \App\Models\Property $property
     * @param mixed $property_source_id
     * @return void
     */
    public function updatePropertySource(Property $property, $property_source_id)
    {
        try {
            $property->property_source_id = $property_source_id;
            $property->save();
        } catch (Exception $e) {
            Log::error('PropertyRepository:updatePropertySource', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateBed
     * @param \App\Models\Property $property
     * @param mixed $beds
     * @return void
     */
    public function updateBed(Property $property, $beds)
    {
        try {
            $property->beds = $beds;
            $property->save();
        } catch (Exception $e) {
            Log::error('PropertyRepository:updateBed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateHalfBed
     * @param \App\Models\Property $property
     * @param mixed $half_baths
     * @return void
     */
    public function updateHalfBed(Property $property, $half_baths)
    {
        try {
            $property->half_baths = $half_baths;
            $property->save();
        } catch (Exception $e) {
            Log::error('PropertyRepository:updateHalfBed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateFullBed
     * @param \App\Models\Property $property
     * @param mixed $full_baths
     * @return void
     */
    public function updateFullBed(Property $property, $full_baths)
    {
        try {
            $property->full_baths = $full_baths;
            $property->save();
        } catch (Exception $e) {
            Log::error('PropertyRepository:updateFullBed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateSize
     * @param \App\Models\Property $property
     * @param mixed $size
     * @return void
     */
    public function updateSize(Property $property, $size)
    {
        try {
            $property->size = $size;
            $property->save();
        } catch (Exception $e) {
            Log::error('PropertyRepository:updateSize', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateLink
     * @param \App\Models\Property $property
     * @param mixed $link
     * @return void
     */
    public function updateLink(Property $property, $link)
    {
        try {
            $property->link = $link;
            $property->save();
        } catch (Exception $e) {
            Log::error('PropertyRepository:updateLink', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateNote
     * @param \App\Models\Property $property
     * @param mixed $note
     * @return void
     */
    public function updateNote(Property $property, $note)
    {
        try {
            $property->note = $note;
            $property->save();
        } catch (Exception $e) {
            Log::error('PropertyRepository:updateNote', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
