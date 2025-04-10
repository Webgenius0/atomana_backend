<?php

namespace App\Repositories\API\V1\Property\AccessInstruction;

use App\Models\Property;
use App\Models\PropertyAccessInstruction;
use Exception;
use Illuminate\Support\Facades\Log;

class AccessInstructionRepository implements AccessInstructionRepositoryInterface
{
    /**
     * getList
     * @param int $businessId
     * @param int $perPage
     */
    public function getList(int $businessId, int $perPage = 25)
    {
        try {
            return Property::whereBusinessId($businessId)->with(['accessInstruction'])->paginate($perPage);
        }catch(Exception $e) {
            Log::error('AccessInstructionRepository::index', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * create
     * @param array $data
     * @return PropertyAccessInstruction
     */
    public function create(array $data):PropertyAccessInstruction
    {
        try {
            return PropertyAccessInstruction::create([
                "property_id"          => $data["property_id"],
                "property_types_id"    => $data["property_types_id"],
                "size"                 => $data["size"],
                "access_key"           => $data["access_key"],
                "lock_box_location"    => $data["lock_box_location"],
                "pickup_instructions"  => $data["pickup_instructions"],
                "gate_code"            => $data["gate_code"],
                "gete_access_location" => $data["gete_access_location"],
                "visitor_parking"      => $data["visitor_parking"],
                "note"                 => $data["note"],
            ]);
        }catch (Exception $e) {
            Log::error('AccessInstructionRepository::create', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * show
     * @param int $accessInstructionId
     * @return PropertyAccessInstruction
     */
    public function show(int $accessInstructionId): PropertyAccessInstruction
    {
        try {
            return PropertyAccessInstruction::with(['property'])->findOrFail($accessInstructionId);
        }catch (Exception $e) {
            Log::error('AccessInstructionRepository::singel', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
