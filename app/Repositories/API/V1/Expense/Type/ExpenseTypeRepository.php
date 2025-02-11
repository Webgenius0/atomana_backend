<?php

namespace App\Repositories\API\V1\Expense\Type;

use App\Models\ExpenseType;
use Exception;
use Illuminate\Support\Facades\Log;

class ExpenseTypeRepository implements ExpenseTypeRepositoryInterface
{
    public function getExpenseTypes()
    {
        try {
            $types = ExpenseType::all();
            return $types;
        }catch (Exception $e) {
            Log::error('TypeRepository::getTypes', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
