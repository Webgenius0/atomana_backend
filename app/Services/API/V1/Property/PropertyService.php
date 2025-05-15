<?php

namespace App\Services\API\V1\Property;

use App\Models\Property;
use App\Repositories\API\V1\Property\PropertyRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PropertyService
{
    protected PropertyRepositoryInterface $propertyRepository;
    protected $user;

    /**
     * Summary of __construct
     * @param \App\Repositories\API\V1\Property\PropertyRepositoryInterface $propertyRepository
     */
    public function __construct(PropertyRepositoryInterface $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
        $this->user = Auth::user();
    }

    /**
     * propertyesOfBusiness
     */
    public function propertyesOfBusiness()
    {
        try {
            $perPage = request()->query('per_page', 25);
            return $this->propertyRepository->propertiesOftheBusiness($this->user->business()->id, $perPage);
        } catch (Exception $e) {
            Log::error('PropertyService::propertyesOfBusiness', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * showPropertyDetails
     * @param int $showById
     * @return Property
     */
    public function showPropertyDetails(int $showById): Property
    {
        try {
            return $this->propertyRepository->showDetailsById($showById);
        } catch (Exception $e) {
            Log::error('PropertyService::showPropertyDetails', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * showDropdown of properties
     */
    public function showDropdown()
    {
        try {
            $searchKey = request()->query('search') ?? '';
            if ($searchKey == '')
                return [];
            $properties = null;
            if ($this->user->role->id == 2) {
                $properties = $this->propertyRepository->searchPropertiesOfBusiness($this->user->business()->id, $searchKey);
            } else {
                $properties = $this->propertyRepository->searchPropertiesOfTheAgent($this->user->id, $searchKey);
            }
            return $properties;
        } catch (Exception $e) {
            Log::error('PropertyService::showDropdown', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * storing the property
     * @param array $credentials
     * @return Property
     */
    public function storeProperty(array $credentials): Property
    {
        try {
            $property = $this->propertyRepository->createProperty($credentials, $this->user->id, $this->user->business()->id);
            return $property;
        } catch (Exception $e) {
            Log::error('PropertyService::storeProperty', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * bulkDestory
     * @param array $ids
     */
    public function bulkDestory(array $ids)
    {
        try {
            return $this->propertyRepository->bulkDelete($ids);
        } catch (Exception $e) {
            Log::error('PropertyService:bulkDestory', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * editPrice
     * @param \App\Models\Property $property
     * @param mixed $price
     * @return void
     */
    public function editPrice(Property $property, $price)
    {
        try {
            $this->propertyRepository->updatePrice($property, $price);
        } catch (Exception $e) {
            Log::error('PropertyService:editPrice', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * editExpirationDate
     * @param \App\Models\Property $property
     * @param mixed $expiration_date
     * @return void
     */
    public function editExpirationDate(Property $property, $expiration_date)
    {
        try {
            $this->propertyRepository->updateExpirationDate($property, $expiration_date);
        } catch (Exception $e) {
            Log::error('PropertyService:editExpirationDate', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * editCommisionRate
     * @param \App\Models\Property $property
     * @param mixed $commission_rate
     * @return void
     */
    public function editCommisionRate(Property $property, $commission_rate)
    {
        try {
            $this->propertyRepository->updateCommisionRate($property, $commission_rate);
        } catch (Exception $e) {
            Log::error('PropertyService:editCommisionRate', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * editWebsite
     * @param \App\Models\Property $property
     * @param mixed $add_to_website
     * @return void
     */
    public function editWebsite(Property $property, $add_to_website)
    {
        try {
            $this->propertyRepository->updateWebsite($property, $add_to_website);
        } catch (Exception $e) {
            Log::error('PropertyService:editWebsite', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * editPropertySource
     * @param \App\Models\Property $property
     * @param mixed $property_source_id
     * @return void
     */
    public function editPropertySource(Property $property, $property_source_id)
    {
        try {
            $this->propertyRepository->updatePropertySource($property, $property_source_id);
        } catch (Exception $e) {
            Log::error('PropertyService:editPropertySource', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * editBed
     * @param \App\Models\Property $property
     * @param mixed $beds
     * @return void
     */
    public function editBed(Property $property, $beds)
    {
        try {
            $this->propertyRepository->updateBed($property, $beds);
        } catch (Exception $e) {
            Log::error('PropertyService:editBed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * editHalfBed
     * @param \App\Models\Property $property
     * @param mixed $half_baths
     * @return void
     */
    public function editHalfBed(Property $property, $half_baths)
    {
        try {
            $this->propertyRepository->updateHalfBed($property, $half_baths);
        } catch (Exception $e) {
            Log::error('PropertyService:editHalfBed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * editFullBed
     * @param \App\Models\Property $property
     * @param mixed $full_baths
     * @return void
     */
    public function editFullBed(Property $property, $full_baths)
    {
        try {
            $this->propertyRepository->updateFullBed($property, $full_baths);
        } catch (Exception $e) {
            Log::error('PropertyService:editFullBed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * editSize
     * @param \App\Models\Property $property
     * @param mixed $size
     * @return void
     */
    public function editSize(Property $property, $size)
    {
        try {
            $this->propertyRepository->updateSize($property, $size);
        } catch (Exception $e) {
            Log::error('PropertyService:editSize', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * editLink
     * @param \App\Models\Property $property
     * @param mixed $link
     * @return void
     */
    public function editLink(Property $property, $link)
    {
        try {
            $this->propertyRepository->updateLink($property, $link);
        } catch (Exception $e) {
            Log::error('PropertyService:editLink', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * eidtNote
     * @param \App\Models\Property $property
     * @param mixed $note
     * @return void
     */
    public function eidtNote(Property $property, $note)
    {
        try {
            $this->propertyRepository->updateNote($property, $note);
        }catch(Exception $e) {
            Log::error('PropertyService:eidtNote', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
