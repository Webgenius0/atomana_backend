<?php

namespace App\Services\API\V1\SharedNote;
use App\Helpers\Helper;
use App\Repositories\API\V1\SharedNote\SharedNoteRepositoryInterface;
use App\Traits\V1\DateManager;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class SharedNoteService
{
    use DateManager;
    protected $user;
    protected $businessId;
    protected SharedNoteRepositoryInterface $sharedNoteRepository;

    public function __construct(SharedNoteRepositoryInterface $sharedNoteRepository)
    {
        $this->user = Auth::user();
        $this->businessId = Auth::user()->business()->id;
        $this->sharedNoteRepository = $sharedNoteRepository;
    }

    public function getAllSharedNote()
    {
        try {
            $perPage = request()->query('per_page', 25);
            $passwordLists = $this->sharedNoteRepository->getAllSharedNote($perPage);
            return $passwordLists;
        } catch (Exception $e) {
            Log::error('SharedNoteService::getAllSharedNote', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
    public function getSharedNote(string $SharedNoteSlug)
    {
        try {
            $SharedNote = $this->sharedNoteRepository->getSharedNote($SharedNoteSlug);
            return $SharedNote;
        } catch (Exception $e) {
            Log::error('SharedNoteService::getSharedNote', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
    public function createSharedNote(array $validatedData)
    {
        try {
            $validatedData['business_id'] = $this->businessId;
            $shortTitle = substr($validatedData['title'], 0, 5);
            $validatedData['slug'] = Helper::makeSlug($shortTitle, 'shared_notes');
            $SharedNote = $this->sharedNoteRepository->createSharedNote($validatedData);
            return $SharedNote;
        } catch (Exception $e) {
            Log::error('SharedNoteService::createSharedNote', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
    public function updateSharedNote(array $validatedData, string $SharedNoteSlug)
    {
        try {
            $SharedNote = $this->sharedNoteRepository->updateSharedNote($validatedData, $SharedNoteSlug);
            return $SharedNote;
        } catch (Exception $e) {
            Log::error('SharedNoteService::updateSharedNote', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
    public function deleteSharedNote(string $SharedNoteSlug)
    {
        try {
            $SharedNote = $this->sharedNoteRepository->deleteSharedNote($SharedNoteSlug);
            return $SharedNote;
        } catch (Exception $e) {
            Log::error('SharedNoteService::deleteSharedNote', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

}
