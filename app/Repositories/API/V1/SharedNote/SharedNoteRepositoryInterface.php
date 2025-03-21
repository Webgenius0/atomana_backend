<?php

namespace App\Repositories\API\V1\SharedNote;

interface SharedNoteRepositoryInterface
{
    public function getAllSharedNote(int $perPage = 25): mixed;
    public function getSharedNote(string $SharedNoteSlug): mixed;
    public function createSharedNote(array $validatedData): mixed;
    public function updateSharedNote(array $validatedData, string $SharedNoteSlug): mixed;
    public function deleteSharedNote(string $SharedNoteSlug): mixed;
}
