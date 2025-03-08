<?php

namespace App\Services\API\V1\Target;

use App\Models\Target;
use App\Repositories\API\V1\Target\TargetRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TargetService
{
    protected TargetRepositoryInterface $targetRepository;
    protected $user;

    /**
     * construct
     * @param \App\Repositories\API\V1\Target\TargetRepositoryInterface $targetRepository
     */
    public function __construct(TargetRepositoryInterface $targetRepository)
    {
        $this->user = Auth::user();
        $this->targetRepository = $targetRepository;
    }

    /**
     * store
     * @param array $credentials
     * @return \App\Models\Target
     */
    public function store(array $credentials): Target
    {
        try {
            return $this->targetRepository->storeTarget($credentials, $this->user->id);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error('App\Services\API\V1\Target\TargetService::store', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
