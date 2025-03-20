<?php

namespace App\Services\API\V1\PasswordList;
use App\Helpers\Helper;
use App\Repositories\API\V1\PasswordList\PasswordListRepositoryInterface;
use App\Traits\V1\DateManager;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class PasswordListService
{
    use DateManager;
    protected $user;
    protected $businessId;
    protected PasswordListRepositoryInterface $passwordListRepository;

    public function __construct(PasswordListRepositoryInterface $passwordListRepository)
    {
        $this->user = Auth::user();
        $this->businessId = Auth::user()->business()->id;
        $this->$passwordListRepository = $passwordListRepository;
    }

    public function getAllPassword(): mixed
    {
        try {
            $perPage = request()->query('per_page', 25);
            $passwordLists = $this->passwordListRepository->getAllPassword($perPage);
            return $passwordLists;
        } catch (Exception $e) {
            Log::error('PasswordListService::getAllPassword', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function createPassword(array $validatedData): mixed
    {
        try {
            $validatedData['business_id'] = $this->businessId;
            $shortName = substr($validatedData['name'], 0, 10);
            $validatedData['slug'] = Helper::generateUniqueSlug($shortName, 'password_lists');
            $passwordList = $this->passwordListRepository->createPassword($validatedData);
            return $passwordList;
        } catch (Exception $e) {
            Log::error('PasswordListService::createPassword', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    public function updatePassword(array $validatedData, string $passwordListSlug): mixed
    {
        try {
            $passwordList = $this->passwordListRepository->updatePassword($validatedData, $passwordListSlug);
            return $passwordList;
        } catch (Exception $e) {
            Log::error('PasswordListService::updatePassword', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    public function deletePassword(string $passwordListSlug): mixed
    {
        try {
            $passwordList = $this->passwordListRepository->deletePassword($passwordListSlug);
            return $passwordList;
        } catch (Exception $e) {
            Log::error('PasswordListService::deletePassword', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    public function getPassword(string $passwordListSlug): mixed
    {
        try {
            $passwordList = $this->passwordListRepository->getPassword($passwordListSlug);
            return $passwordList;
        } catch (Exception $e) {
            Log::error('PasswordListService::getPassword', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
