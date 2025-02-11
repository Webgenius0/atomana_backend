<?php

namespace App\Repositories\API\V1\Expense\Type;

use App\Models\ExpenseType;
use Exception;
use Illuminate\Support\Facades\Log;

class ExpenseTypeRepository implements ExpenseTypeRepositoryInterface
{

    /**
     * gets all the data form the expense type table
     * @return \Illuminate\Database\Eloquent\Collection<int, ExpenseType>
     */
    public function getExpenseTypes()
    {
        try {
            $types = ExpenseType::all();
            return $types;
        }catch (Exception $e) {
            Log::error('TypeRepository::getExpenseTypes', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
