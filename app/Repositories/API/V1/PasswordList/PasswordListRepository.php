<?php

namespace App\Repositories\API\V1\PasswordList;

use App\Models\PasswordList;
use Exception;
use Illuminate\Support\Facades\Log;

class PasswordListRepository implements PasswordListRepositoryInterface
{
    public function getAllPassword(int $perPage = 25): mixed
    {
        try {
            $passwordLists = PasswordList::where('business_id', auth()->user()->business()->id)->select('id', 'business_id', 'title', 'website', 'user_name', 'password', 'email', 'notes', 'slug','updated_at')->latest()->get();

            return $passwordLists;
        } catch (Exception $e) {
            Log::error('PasswordListRepository::getAllPassword', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function getPassword(string $passwordListSlug): mixed
    {
        try {
            $passwordList = PasswordList::where('business_id', auth()->user()->business()->id)->select('id', 'business_id', 'title', 'website', 'user_name', 'password', 'email', 'notes', 'slug','updated_at')->where('slug', $passwordListSlug)->firstOrFail();
            return $passwordList;
        } catch (Exception $e) {
            Log::error('PasswordListRepository::getPassword', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function createPassword(array $validatedData): mixed
    {
        try {
            $passwordList = PasswordList::create($validatedData);
            return $passwordList;
        } catch (Exception $e) {
            Log::error('PasswordListRepository::createPassword', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
    public function updatePassword(array $validatedData, string $passwordListSlug): mixed
    {
        try {
            $passwordList = PasswordList::where('business_id', auth()->user()->business()->id)->where('slug', $passwordListSlug)->firstOrFail();
            $passwordList->update($validatedData);
            return $passwordList;
        } catch (Exception $e) {
            Log::error('PasswordListRepository::updatePassword', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function deletePassword(string $passwordListSlug): mixed
    {
        try {
            $passwordList = PasswordList::where('business_id', auth()->user()->business()->id)->where('slug', $passwordListSlug)->firstOrFail();
            $passwordList->delete();
            return true;
        } catch (Exception $e) {
            Log::error('PasswordListRepository::deletePassword', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
