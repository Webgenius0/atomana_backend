<?php

namespace App\Repositories\API\V1\Expense\Type;

use App\Models\ExpenseType;
use Illuminate\Database\Eloquent\Collection;

interface ExpenseTypeRepositoryInterface
{
    /**
     * gets all the data form the expense type table
     * @return \Illuminate\Database\Eloquent\Collection<int, ExpenseType>
     */
    public function getExpenseTypes():Collection;
}
