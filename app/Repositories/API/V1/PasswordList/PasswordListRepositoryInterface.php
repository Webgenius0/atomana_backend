<?php

namespace App\Repositories\API\V1\PasswordList;

interface PasswordListRepositoryInterface
{
    public function getAllPassword(int $perPage = 25);
    public function getPassword(string $passwordListSlug);
    public function createPassword(array $validatedData);
    public function updatePassword(array $validatedData, string $passwordListSlug);
    public function deletePassword(string $passwordListSlug);
}
