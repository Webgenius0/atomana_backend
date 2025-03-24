<?php

namespace App\Repositories\API\V1\SharedNote;
use App\Models\SharedNote;
use Exception;
use Illuminate\Support\Facades\Log;

class SharedNoteRepository implements SharedNoteRepositoryInterface
{
    /**
     * Gets all the shared notes in paginated way.
     * 
     * @param int $perPage The number of items to be returned per page.
     * 
     * @return mixed
     */
    public function getAllSharedNote(int $perPage = 25): mixed
    {
        try {
            $SharedNotes = SharedNote::where('business_id', auth()->user()->business()->id)->select('id', 'business_id', 'title', 'notes', 'slug')->latest()->get();
            return $SharedNotes;
        } catch (Exception $e) {
            Log::error('SharedNoteRepository::getAllSharedNote', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Get a shared note by its slug.
     * 
     * @param string $SharedNoteSlug The slug of the shared note to be retrieved.
     * 
     * @return mixed The retrieved shared note.
     */
    public function getSharedNote(string $SharedNoteSlug): mixed
    {
        try {
            $SharedNote = SharedNote::where('business_id', auth()->user()->business()->id)->select('id', 'business_id', 'title', 'notes', 'slug')->where('slug', $SharedNoteSlug)->firstOrFail();
            return $SharedNote;
        } catch (Exception $e) {
            Log::error('SharedNoteRepository::getSharedNote', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Create a new shared note.
     * 
     * This function attempts to create a new shared note using the provided validated data.
     * If successful, it returns the created shared note.
     * 
     * @param array $validatedData The validated data for creating a shared note.
     * 
     * @return mixed The created shared note.
     * 
     * @throws Exception If an error occurs during the creation process.
     */

    public function createSharedNote(array $validatedData): mixed
    {
        try {
            $SharedNote = SharedNote::create($validatedData);
            return $SharedNote;
        } catch (Exception $e) {
            Log::error('SharedNoteRepository::createSharedNote', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
    /**
     * Updates a shared note by its slug.
     * 
     * This function attempts to update a shared note using the provided validated data.
     * If successful, it returns the updated shared note.
     * 
     * @param array $validatedData The validated data for updating a shared note.
     * @param string $SharedNoteSlug The slug of the shared note to be updated.
     * 
     * @return mixed The updated shared note.
     * 
     * @throws Exception If an error occurs during the update process.
     */
    public function updateSharedNote(array $validatedData, string $SharedNoteSlug): mixed
    {
        try {
            $SharedNote = SharedNote::where('business_id', auth()->user()->business()->id)->where('slug', $SharedNoteSlug)->firstOrFail();
            $SharedNote->update($validatedData);
            return $SharedNote;
        } catch (Exception $e) {
            Log::error('SharedNoteRepository::updateSharedNote', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Delete a shared note by its slug.
     * 
     * This function attempts to delete a shared note using the provided slug.
     * If successful, it returns true.
     * 
     * @param string $SharedNoteSlug The slug of the shared note to be deleted.
     * 
     * @return mixed True if the deletion was successful, otherwise an exception is thrown.
     * 
     * @throws Exception If an error occurs during the deletion process.
     */
    public function deleteSharedNote(string $SharedNoteSlug): mixed
    {
        try {
            $SharedNote = SharedNote::where('business_id', auth()->user()->business()->id)->where('slug', $SharedNoteSlug)->firstOrFail();
            $SharedNote->delete();
            return true;
        } catch (Exception $e) {
            Log::error('SharedNoteRepository::deleteSharedNote', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
