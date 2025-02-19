<?php

namespace App\Providers;

use App\Repositories\API\V1\Admin\AgentRepository;
use App\Repositories\API\V1\Admin\AgentRepositoryInterface;
use App\Repositories\API\V1\Auth\ForgetPasswordRepository;
use App\Repositories\API\V1\Auth\ForgetPasswordRepositoryInterface;
use App\Repositories\API\V1\Auth\OTPRepository;
use App\Repositories\API\V1\Auth\OTPRepositoryInterface;
use App\Repositories\API\V1\Auth\PasswordRepository;
use App\Repositories\API\V1\Auth\PasswordRepositoryInterface;
use App\Repositories\API\V1\Auth\UserRepository;
use App\Repositories\API\V1\Auth\UserRepositoryInterface;
use App\Repositories\API\V1\Expense\Catetory\ExpenseCategoryRepository;
use App\Repositories\API\V1\Expense\Catetory\ExpenseCategoryRepositoryInterface;
use App\Repositories\API\V1\Expense\ExpenseRepository;
use App\Repositories\API\V1\Expense\ExpenseRepositoryInterface;
use App\Repositories\API\V1\Expense\SubCatetory\ExpenseSubCategoryRepository;
use App\Repositories\API\V1\Expense\SubCatetory\ExpenseSubCategoryRepositoryInterface;
use App\Repositories\API\V1\Expense\Type\ExpenseTypeRepository;
use App\Repositories\API\V1\Expense\Type\ExpenseTypeRepositoryInterface;
use App\Repositories\API\V1\Expense\Vendor\VendorRepository;
use App\Repositories\API\V1\Expense\Vendor\VendorRepositoryInterface;
use App\Repositories\API\V1\Method\PaymentMethodRepository;
use App\Repositories\API\V1\Method\PaymentMethodRepositoryInterface;
use App\Repositories\API\V1\Profile\ProfileRepository;
use App\Repositories\API\V1\Profile\ProfileRepositoryInterface;
use App\Repositories\API\V1\Property\PropertyRepository;
use App\Repositories\API\V1\Property\PropertyRepositoryInterface;
use App\Repositories\API\V1\SalesTrake\SalesTrackRepository;
use App\Repositories\API\V1\SalesTrake\SalesTrackRepositoryInterface;
use App\Repositories\API\V1\User\UserRepository as UserRepo;
use App\Repositories\API\V1\User\UserRepositoryInterface as UserRepoInter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // auth
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ForgetPasswordRepositoryInterface::class, ForgetPasswordRepository::class);
        $this->app->bind(OTPRepositoryInterface::class, OTPRepository::class);
        $this->app->bind(PasswordRepositoryInterface::class, PasswordRepository::class);

        // user
        $this->app->bind(UserRepoInter::class, UserRepo::class);

        // profile
        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class);

        // agent
        $this->app->bind(AgentRepositoryInterface::class, AgentRepository::class);
        $this->app->bind(SalesTrackRepositoryInterface::class, SalesTrackRepository::class);

        // expences
        $this->app->bind(ExpenseTypeRepositoryInterface::class, ExpenseTypeRepository::class);
        $this->app->bind(ExpenseCategoryRepositoryInterface::class, ExpenseCategoryRepository::class);
        $this->app->bind(ExpenseSubCategoryRepositoryInterface::class, ExpenseSubCategoryRepository::class);
        $this->app->bind(VendorRepositoryInterface::class, VendorRepository::class);
        $this->app->bind(ExpenseRepositoryInterface::class, ExpenseRepository::class);

        // product
        $this->app->bind(PropertyRepositoryInterface::class, PropertyRepository::class);

        // moetod
        $this->app->bind(PaymentMethodRepositoryInterface::class, PaymentMethodRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
