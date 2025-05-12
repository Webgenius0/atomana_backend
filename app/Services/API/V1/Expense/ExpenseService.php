<?php

namespace App\Services\API\V1\Expense;

use App\Helpers\Helper;
use App\Models\Expense;
use App\Repositories\API\V1\Expense\ExpenseRepository;
use App\Repositories\API\V1\Expense\ExpenseRepositoryInterface;
use App\Repositories\API\V1\SalesTrack\SalesTrackRepositoryInterface;
use App\Repositories\API\V1\Target\TargetRepositoryInterface;
use App\Traits\V1\DateManager;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ExpenseService extends ExpenseRepository
{
    use DateManager;
    protected $user;
    protected $businessId;
    protected ExpenseRepositoryInterface $expenseRepository;
    protected TargetRepositoryInterface $targetRepository;
    protected SalesTrackRepositoryInterface $salesTrackRepository;

    /**
     * construct
     * @param \App\Repositories\API\V1\Expense\ExpenseRepositoryInterface $expenseRepository
     */
    public function __construct(
        ExpenseRepositoryInterface $expenseRepository,
        TargetRepositoryInterface $targetRepository,
        SalesTrackRepositoryInterface $salesTrackRepository
    ) {
        $this->user              = Auth::user();
        $this->businessId        = Auth::user()->business()->id;
        $this->expenseRepository = $expenseRepository;
        $this->targetRepository  = $targetRepository;
        $this->salesTrackRepository = $salesTrackRepository;
    }


    /**
     * get perpage and business->id and based on that,
     * get expenses
     * @param mixed $expenseFor
     */
    public function getExpenses($expenseFor)
    {
        try {
            $perPage = request()->query('per_page', 25);
            $businessId = $this->user->business()->id;
            $data = $this->expenseRepository->getAllExpense($expenseFor->id, $perPage, $businessId);
            return $data;
        } catch (Exception $e) {
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

            if (isset($credentials['recept'])) {
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

    /**
     * expenseStatistics
     * @param string $filter
     * @return array|null
     */
    public function expenseStatistics(string $filter)
    {
        try {
            $role = $this->user->role->slug;
            $response = null;
            if ($role == 'admin') {
                $response = $this->adminExpenseStatistics($filter);
            } else if ($role == 'agent') {
                $response = $this->agetnExpenseStatistics($filter);
            }

            return $response;
        } catch (Exception $e) {
            Log::error('ExpenseService::expenseStatistics', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * agetnExpenseStatistics
     * @param string $filter
     * @return array
     */
    public function agetnExpenseStatistics(string $filter)
    {
        try {
            $currentDate = Carbon::now();
            $currentCount = null;
            $target = null;
            $percentage = null;
            if ($filter == 'monthly') {
                $startOfMonth = $this->getStartOfMonth($currentDate);
                $endOfMonth = $currentDate->endOfMonth();
                $currentCount = $this->expenseRepository->agentsExpenseSum($this->user->id, $startOfMonth, $endOfMonth);
                $target = $this->targetRepository->getRangeTarget($this->user->id, $startOfMonth, $endOfMonth, 'units_sold');
            } else if ($filter == 'quarterly') {
                $quarterStart = $this->getCurrentQuarterStartDate($currentDate);
                $quarterEnd = $this->getCurrentQuarterEndDate($currentDate);
                $currentCount = $this->expenseRepository->agentsExpenseSum($this->user->id, $quarterStart, $quarterEnd);
                $target = $this->targetRepository->getRangeTarget($this->user->id, $quarterStart, $quarterEnd, 'units_sold');
            } else if ($filter == 'yearly') {
                $yearStart = $this->getCurrentYearStartDate($currentDate);
                $yearEnd = $this->getCurrentYearEndDate($currentDate);
                $currentCount = $this->expenseRepository->agentsExpenseSum($this->user->id, $yearStart, $yearEnd);
                $target = $this->targetRepository->getRangeTarget($this->user->id, $yearStart, $yearEnd, 'units_sold');
            }
            if ($target) {
                $percentage = ($currentCount * 100) / $target;
            }
            return [
                'target' => number_format((float) $target, 2),
                'expense' => number_format((float) $currentCount, 2),
                'percentage' => number_format((float) $percentage, 2),
            ];
        } catch (Exception $e) {
            Log::error('ExpenseService::agetnExpenseStatistics', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * adminExpenseStatistics
     * @param string $filter
     * @return array
     */
    public function adminExpenseStatistics(string $filter)
    {
        try {
            $currentDate = Carbon::now();
            $currentCount = null;
            $target = null;
            $percentage = null;
            if ($filter == 'monthly') {
                $startOfMonth = $this->getStartOfMonth($currentDate);
                $endOfMonth = $currentDate->endOfMonth();
                $currentCount = $this->expenseRepository->businessExpenseSum($this->businessId, $startOfMonth, $endOfMonth);
                $target = $this->targetRepository->getRangeTarget($this->user->id, $startOfMonth, $endOfMonth, 'units_sold');
            } else if ($filter == 'quarterly') {
                $quarterStart = $this->getCurrentQuarterStartDate($currentDate);
                $quarterEnd = $this->getCurrentQuarterEndDate($currentDate);
                $currentCount = $this->expenseRepository->businessExpenseSum($this->businessId, $quarterStart, $quarterEnd);
                $target = $this->targetRepository->getRangeTarget($this->user->id, $quarterStart, $quarterEnd, 'units_sold');
            } else if ($filter == 'yearly') {
                $yearStart = $this->getCurrentYearStartDate($currentDate);
                $yearEnd = $this->getCurrentYearEndDate($currentDate);
                $currentCount = $this->expenseRepository->businessExpenseSum($this->businessId, $yearStart, $yearEnd);
                $target = $this->targetRepository->getRangeTarget($this->user->id, $yearStart, $yearEnd, 'units_sold');
            }
            if ($target) {
                $percentage = ($currentCount * 100) / $target;
            }
            return [
                'target' => number_format((float) $target, 2),
                'expense' => number_format((float) $currentCount, 2),
                'percentage' => number_format((float) $percentage, 2),
            ];
        } catch (Exception $e) {
            Log::error('ExpenseService::adminExpenseStatistics', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    /**
     * netProfitStatistics
     * @param string $filter
     * @return array|null
     */
    public function netProfitStatistics(string $filter)
    {
        try {
            $role = $this->user->role->slug;
            $response = null;
            if ($role == 'admin') {
                $response = $this->adminNetProfitStatistics($filter);
            } else if ($role == 'agent') {
                $response = $this->agentNetProfitStatistics($filter);
            }

            return $response;
        } catch (Exception $e) {
            Log::error('ExpenseService::expenseStatistics', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * adminNetProfitStatistics
     * @param string $filter
     * @return array{net profit: string, percentage: string, target: string}
     */
    public function adminNetProfitStatistics(string $filter)
    {
        try {
            $currentDate = Carbon::now();
            $currentNetProfit = null;
            $target = null;
            $percentage = null;
            if ($filter == 'monthly') {
                $startOfMonth = $this->getStartOfMonth($currentDate);
                $endOfMonth = $currentDate->endOfMonth();
                $totalExpence = $this->expenseRepository->agentsExpenseSum($this->user->id, $startOfMonth, $endOfMonth);
                $totalIncome = $this->salesTrackRepository->agentColseSalesTrackTotalPurchasePriceByRange($this->user->id, $startOfMonth, $endOfMonth);
                $currentNetProfit = $totalIncome - $totalExpence;
                $target = $this->targetRepository->getRangeTarget($this->user->id, $startOfMonth, $endOfMonth, 'net_profit');
            } else if ($filter == 'quarterly') {
                $quarterStart = $this->getCurrentQuarterStartDate($currentDate);
                $quarterEnd = $this->getCurrentQuarterEndDate($currentDate);
                $totalExpence = $this->expenseRepository->agentsExpenseSum($this->user->id, $quarterStart, $quarterEnd);
                $totalIncome = $this->salesTrackRepository->agentColseSalesTrackTotalPurchasePriceByRange($this->user->id, $quarterStart, $quarterEnd);
                $currentNetProfit = $totalIncome - $totalExpence;
                $target = $this->targetRepository->getRangeTarget($this->user->id, $quarterStart, $quarterEnd, 'net_profit');
            } else if ($filter == 'yearly') {
                $yearStart = $this->getCurrentYearStartDate($currentDate);
                $yearEnd = $this->getCurrentYearEndDate($currentDate);
                $totalExpence = $this->expenseRepository->agentsExpenseSum($this->user->id, $yearStart, $yearEnd);
                $totalIncome = $this->salesTrackRepository->agentColseSalesTrackTotalPurchasePriceByRange($this->user->id, $yearStart, $yearEnd);
                $currentNetProfit = $totalIncome - $totalExpence;
                $target = $this->targetRepository->getRangeTarget($this->user->id, $yearStart, $yearEnd, 'net_profit');
            }
            if ($target) {
                $percentage = ($currentNetProfit * 100) / $target;
            }
            return [
                'target' => number_format((float) $target, 2),
                'net profit' => number_format((float) $currentNetProfit, 2),
                'percentage' => number_format((float) $percentage, 2),
            ];
        } catch (Exception $e) {
            Log::error('ExpenseService::adminNetProfitStatistics', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    /**
     * agentNetProfitStatistics
     * @param string $filter
     * @return array{net profit: string, percentage: string, target: string}
     */
    public function agentNetProfitStatistics(string $filter)
    {
        try {
            $currentDate = Carbon::now();
            $currentNetProfit = null;
            $target = null;
            $percentage = null;

            if ($filter == 'monthly') {
                $startOfMonth = $this->getStartOfMonth($currentDate);
                $endOfMonth = $currentDate->endOfMonth();
                $totalExpence = $this->expenseRepository->businessExpenseSum($this->businessId, $startOfMonth, $endOfMonth);
                $totalIncome = $this->salesTrackRepository->busnessColseSalesTrackTotalPurchasePriceByRange($this->businessId, $startOfMonth, $endOfMonth);
                $currentNetProfit = $totalIncome - $totalExpence;
                $target = $this->targetRepository->getRangeTarget($this->user->id, $startOfMonth, $endOfMonth, 'net_profit');
            } else if ($filter == 'quarterly') {
                $quarterStart = $this->getCurrentQuarterStartDate($currentDate);
                $quarterEnd = $this->getCurrentQuarterEndDate($currentDate);
                $totalExpence = $this->expenseRepository->businessExpenseSum($this->businessId, $quarterStart, $quarterEnd);
                $totalIncome = $this->salesTrackRepository->busnessColseSalesTrackTotalPurchasePriceByRange($this->businessId, $quarterStart, $quarterEnd);
                $currentNetProfit = $totalIncome - $totalExpence;
                $target = $this->targetRepository->getRangeTarget($this->user->id, $quarterStart, $quarterEnd, 'net_profit');
            } else if ($filter == 'yearly') {
                $yearStart = $this->getCurrentYearStartDate($currentDate);
                $yearEnd = $this->getCurrentYearEndDate($currentDate);
                $totalExpence = $this->expenseRepository->businessExpenseSum($this->businessId, $yearStart, $yearEnd);
                $totalIncome = $this->salesTrackRepository->busnessColseSalesTrackTotalPurchasePriceByRange($this->businessId, $yearStart, $yearEnd);
                $currentNetProfit = $totalIncome - $totalExpence;
                $target = $this->targetRepository->getRangeTarget($this->user->id, $yearStart, $yearEnd, 'net_profit');
            }
            if ($target) {
                $percentage = ($currentNetProfit * 100) / $target;
            }
            return [
                'target' => number_format((float) $target, 2),
                'net profit' => number_format((float) $currentNetProfit, 2),
                'percentage' => number_format((float) $percentage, 2),
            ];
        } catch (Exception $e) {
            Log::error('ExpenseService::agentNetProfitStatistics', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateUser
     * @param int $id
     * @param int $userId
     * @return void
     */
    public function updateUser(int $id, int $userId)
    {
        try {
            $this->expenseRepository->updateUser($id, $userId);
        } catch (Exception $e) {
            Log::error('ExpenseService::updateUser', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateCategory
     * @param int $id
     * @param int $categoryId
     * @return void
     */
    public function updateCategory(int $id, int $categoryId)
    {
        try {
            $this->expenseRepository->updateCategory($id, $categoryId);
        } catch (Exception $e) {
            Log::error('ExpenseService::updateCategory', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateSubCategory
     * @param int $id
     * @param int $categoryId
     * @return void
     */
    public function updateSubCategory(int $id, int $subCategoryId)
    {
        try {
            $this->expenseRepository->updateSubCategory($id, $subCategoryId);
        } catch (Exception $e) {
            Log::error('ExpenseService::updateSubCategory', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateDescriptions
     * @param int $id
     * @param int $description
     * @return void
     */
    public function updateDescriptions(int $id, int $description)
    {
        try {
            $this->expenseRepository->updateDescription($id, $description);
        } catch (Exception $e) {
            Log::error('ExpenseService::updateDescriptions', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateAmount
     * @param int $id
     * @param float $amount
     * @return void
     */
    public function updateAmount(int $id, float $amount)
    {
        try {
            $this->expenseRepository->updateAmount($id, $amount);
        } catch (Exception $e) {
            Log::error('ExpenseService::updateAmount', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updatePaymentMethodAmount
     * @param int $id
     * @param int $paymentMethodId
     * @return void
     */
    public function updatePaymentMethod(int $id, int $paymentMethodId)
    {
        try {
            $this->expenseRepository->updatePaymentMethod($id, $paymentMethodId);
        } catch (Exception $e) {
            Log::error('ExpenseService::updatePaymentMethodAmount', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updatePayee
     * @param int $id
     * @param string $payee
     * @return void
     */
    public function updatePayee(int $id, string $payee)
    {
        try {
            $this->expenseRepository->updatePayee($id, $payee);
        } catch (Exception $e) {
            Log::error('ExpenseService::updatePayee', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateReimbursable
     * @param int $id
     * @return void
     */
    public function updateReimbursable(int $id)
    {
        try {
            $this->expenseRepository->updateReimbursable($id);
        } catch (Exception $e) {
            Log::error('ExpenseService::updateReimbursable', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateListing
     * @param int $id
     * @param string $listing
     * @return void
     */
    public function updateListing(int $id, string $listing)
    {
        try {
            $this->expenseRepository->updateListing($id, $listing);
        } catch (Exception $e) {
            Log::error('ExpenseService::updateListing', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateNote
     * @param int $id
     * @param string $note
     * @return void
     */
    public function updateNote(int $id, string $note)
    {
        try {
            $this->expenseRepository->updateNote($id, $note);
        } catch (Exception $e) {
            Log::error('ExpenseService::updateNote', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


        /**
     * bulkDestory
     * @param array $ids
     */
    public function bulkDestory(array $ids)
    {
        try {
            return $this->expenseRepository->bulkDelete($ids);
        } catch (Exception $e) {
            Log::error('ExpenseService:bulkDestory', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

}
