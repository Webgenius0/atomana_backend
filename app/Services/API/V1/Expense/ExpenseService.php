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
     * get perpage and business->id and based on that,
     * get expenses
     * @param mixed $expenseFor
     */
    public function getExpenses($expenseFor)
    {
        try{
            $perPage = request()->query('per_page', 25);
            $businessId = $this->user->business()->id;
            $data = $this->expenseRepository->getAllExpense($expenseFor->id, $perPage, $businessId);
            return $data;
        }catch(Exception $e) {
            Log::error("ExpenseService::getExpenses", ['error' => $e->getMessage()]);
            throw $e;
        }
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
            $businessId = $this->user->business()->id;
            
            $recetp = null;
            $recept_url = null;

            if ($credentials['recept'] != null) {
                $recept_url = Helper::uploadFile($credentials['recept'], 'business/' . $businessId . '/recept');
                $recetp = $credentials['recept']->getClientOriginalName();
            }

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
