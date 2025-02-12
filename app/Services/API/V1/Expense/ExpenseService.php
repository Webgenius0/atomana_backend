<?php

namespace App\Services\API\V1\Expense;

use App\Helpers\Helper;
use App\Models\ExpenseFor;
use App\Repositories\API\V1\Expense\ExpenseRepository;
use App\Repositories\API\V1\Expense\ExpenseRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ExpenseService extends ExpenseRepository
{

    protected $user;
    protected ExpenseRepositoryInterface $expenseRepository;

    /**
     * construct
     * @param \App\Repositories\API\V1\Expense\ExpenseRepositoryInterface $expenseRepository
     */
    public function __construct(ExpenseRepositoryInterface $expenseRepository)
    {
        $this->user = Auth::user();
        $this->expenseRepository = $expenseRepository;
    }

    /**
     * store Expense
     * @param array $credentials
     * @param mixed $expenseFor
     * @return mixed
     */
    public function storeExpense(array $credentials, $expenseFor): mixed
    {
        try {
            $businessId = $this->user->business()->id;;
            $recept_url = Helper::uploadFile($credentials['recept'], 'business/' . $businessId . '/recept');
            $recetp = $credentials['recept']->getClientOriginalName();
            $data = $this->expenseRepository->createExpense(
                $credentials,
                $recept_url,
                $recetp,
                $businessId,
                $expenseFor->id
            );
            return $data;
        } catch (Exception $e) {
            Log::error("ExpenseService::storeExpense", ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
