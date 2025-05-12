<?php

namespace App\Repositories\API\V1\Property\AccessInstruction;

use App\Models\Property;
use App\Models\PropertyAccessInstruction;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException;

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
            return Property::select(['id', 'address'])->whereBusinessId($businessId)
            ->wherehas('accessInstruction')->with(['accessInstruction:id,property_id'])->orderBy('created_at', 'desc')->paginate($perPage);
        } catch (Exception $e) {
            Log::error('AccessInstructionRepository::index', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * create
     * @param array $data
     * @return PropertyAccessInstruction
     */
    public function create(array $data): PropertyAccessInstruction
    {
        try {
            $existingInstruction = PropertyAccessInstruction::where('property_id', $data['property_id'])->first();

            if ($existingInstruction) {
                throw new PreconditionFailedHttpException('Access Instruction already exists for this property.',);
            }

            return PropertyAccessInstruction::create([
                "property_id"          => $data["property_id"],
                "property_type_id"    => $data["property_type_id"],
                "size"                 => $data["size"],
                "access_key"           => $data["access_key"],
                "lock_box_location"    => $data["lock_box_location"],
                "pickup_instructions"  => $data["pickup_instructions"],
                "gate_code"            => $data["gate_code"],
                "gete_access_location" => $data["gete_access_location"],
                "visitor_parking"      => $data["visitor_parking"],
                "note"                 => $data["note"],
            ]);
        } catch (PreconditionFailedHttpException $e) {
            Log::error('AccessInstructionRepository::create', ['error' => $e->getMessage()]);
            throw $e;
        } catch (Exception $e) {
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
            return PropertyAccessInstruction::with([
                'propertyType:id,name',
                'property',
                'property.agent:id,first_name,last_name',
                'property.coAgent:id,first_name,last_name',
                'property.source:id,name'
            ])->findOrFail($accessInstructionId);
        } catch (Exception $e) {
            Log::error('AccessInstructionRepository::singel', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * bulkDelete
     * @param array $ids
     * @return void
     */
    public function bulkDelete(array $ids): void
    {
        try {
            PropertyAccessInstruction::destroy($ids);
        } catch (Exception $e) {
            Log::error('AccessInstructionRepository:bulkDelete', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
