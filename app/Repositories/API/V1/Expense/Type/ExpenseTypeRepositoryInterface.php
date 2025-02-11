<?php

namespace App\Repositories\API\V1\Expense\Type;

use App\Models\ExpenseType;

interface ExpenseTypeRepositoryInterface
{
    /**
     * gets all the data form the expense type table
     * @return \Illuminate\Database\Eloquent\Collection<int, ExpenseType>
     */
    public function getExpenseTypes();
}
