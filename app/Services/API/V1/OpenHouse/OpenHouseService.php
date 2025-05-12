<?php

namespace App\Services\API\V1\OpenHouse;

use App\Models\OpenHouse;
use App\Repositories\API\V1\OpenHouse\OpenHouseRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OpenHouseService
{
    protected OpenHouseRepositoryInterface $openHouseRepository;
    protected $businessId;
    protected $user;

    /**
     * construct
     * @param \App\Repositories\API\V1\OpenHouse\OpenHouseRepositoryInterface $openHouseRepository
     */
    public function __construct(OpenHouseRepositoryInterface $openHouseRepository)
    {
        $this->openHouseRepository = $openHouseRepository;
        $this->user = Auth::user();
        $this->businessId = Auth::user()->business()->id;
    }


    /**
     * list
     */
    public function list()
    {
        try {
            $perPage = request()->query('per_page', 25);
            return $this->openHouseRepository->listInDesc($this->businessId, $perPage);
        } catch (Exception $e) {
            Log::error('App\Services\API\V1\OpenHouse\OpenHouseService:list', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * store
     * @param array $credential
     * @return OpenHouse
     */
    public function store(array $credential): OpenHouse
    {
        try {
            return $this->openHouseRepository->storeOpenHourse($credential, $this->businessId, $this->user->id);
        } catch (Exception $e) {
            Log::error('App\Services\API\V1\OpenHouse\OpenHouseService:store', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * showOpenHouse
     * @param \App\Models\OpenHouse $openHouse
     * @return OpenHouse
     */
    public function showOpenHouse(OpenHouse $openHouse): OpenHouse
    {
        try {
            return $this->openHouseRepository->openHouseInfoById($openHouse->id);
        } catch (Exception $e) {
            Log::error('App\Services\API\V1\OpenHouse\OpenHouseService:showOpenHouse', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    /**
     * dropdown
     */
    public function dropdown()
    {
        try {
            return $this->openHouseRepository->getList($this->businessId);
        } catch (Exception $e) {
            Log::error('App\Services\API\V1\OpenHouse\OpenHouseService:store', ['error' => $e->getMessage()]);
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
            return $this->openHouseRepository->bulkDelete($ids);
        } catch (Exception $e) {
            Log::error('App\Services\API\V1\OpenHouse\OpenHouseService:bulkDestory', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
