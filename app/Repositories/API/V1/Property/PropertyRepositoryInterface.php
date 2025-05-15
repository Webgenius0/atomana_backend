<?php

namespace App\Repositories\API\V1\Property;

use App\Models\Property;

interface PropertyRepositoryInterface
{
    /**
     * properties Of the Business
     * @param int $businessId
     * @param int $perPage
     */
    public function propertiesOftheBusiness(int $businessId, int $perPage);

    /**
     * searchPropertiesOfBusiness
     * @param int $businessId
     * @param string $searchKey
     */
    public function searchPropertiesOfBusiness(int $businessId, string $searchKey);

    /**
     * searchPropertiesOfTheAgent
     * @param int $userId
     * @param string $searchKey
     */
    public function searchPropertiesOfTheAgent(int $userId, string $searchKey);

    /**
     * Creating a property
     * @param array $credentials
     * @param int $userId
     * @param int $businessId
     * @return Property
     */
    public function createProperty(array $credentials, int $userId, int $businessId): Property;

    /**
     * showById
     * @param int $propertyId
     * @return Property
     */
    public function showDetailsById(int $propertyId): Property;

    /**
     * bulkDelete
     * @param array $ids
     * @return void
     */
    public function bulkDelete(array $ids): void;

    /**
     * updatePrice
     * @param \App\Models\Property $property
     * @param mixed $price
     * @return void
     */
    public function updatePrice(Property $property, $price);

    /**
     * updateExpirationDate
     * @param \App\Models\Property $property
     * @param mixed $expiration_date
     * @return void
     */
    public function updateExpirationDate(Property $property, $expiration_date);

    /**
     * updateCommisionRate
     * @param \App\Models\Property $property
     * @param mixed $commission_rate
     * @return void
     */
    public function updateCommisionRate(Property $property, $commission_rate);

    /**
     * updateIsDevelopment
     * @param \App\Models\Property $property
     * @param mixed $is_development
     * @return void
     */
    public function updateIsDevelopment(Property $property, $is_development);

    /**
     * updateWebsite
     * @param \App\Models\Property $property
     * @param mixed $add_to_website
     * @return void
     */
    public function updateWebsite(Property $property, $add_to_website);

    /**
     * updatePropertySource
     * @param \App\Models\Property $property
     * @param mixed $property_source_id
     * @return void
     */
    public function updatePropertySource(Property $property, $property_source_id);

    /**
     * updateBed
     * @param \App\Models\Property $property
     * @param mixed $beds
     * @return void
     */
    public function updateBed(Property $property, $beds);

    /**
     * updateHalfBed
     * @param \App\Models\Property $property
     * @param mixed $half_baths
     * @return void
     */
    public function updateHalfBed(Property $property, $half_baths);

    /**
     * updateFullBed
     * @param \App\Models\Property $property
     * @param mixed $full_baths
     * @return void
     */
    public function updateFullBed(Property $property, $full_baths);

    /**
     * updateSize
     * @param \App\Models\Property $property
     * @param mixed $size
     * @return void
     */
    public function updateSize(Property $property, $size);


    /**
     * updateLink
     * @param \App\Models\Property $property
     * @param mixed $link
     * @return void
     */
    public function updateLink(Property $property, $link);

    /**
     * updateNote
     * @param \App\Models\Property $property
     * @param mixed $note
     * @return void
     */
    public function updateNote(Property $property, $note);
}
