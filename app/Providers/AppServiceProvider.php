<?php

namespace App\Providers;

use App\Repositories\API\V1\Admin\AgentRepository;
use App\Repositories\API\V1\Admin\AgentRepositoryInterface;
use App\Repositories\API\V1\AI\MyAI\MyAIMessageRepository;
use App\Repositories\API\V1\AI\MyAI\MyAIMessageRepositoryInterface;
use App\Repositories\API\V1\AI\MyAI\MyAIRepository;
use App\Repositories\API\V1\AI\MyAI\MyAIRepositoryInterface;
use App\Repositories\API\V1\AI\MyPR\MyPRMessageRepository;
use App\Repositories\API\V1\AI\MyPR\MyPRMessageRepositoryInterface;
use App\Repositories\API\V1\AI\MyPR\MyPRRepository;
use App\Repositories\API\V1\AI\MyPR\MyPRRepositoryInterface;
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
use App\Repositories\API\V1\Method\PaymentMethodRepository;
use App\Repositories\API\V1\Method\PaymentMethodRepositoryInterface;
use App\Repositories\API\V1\OpenHouse\OpenHouseRepository;
use App\Repositories\API\V1\OpenHouse\OpenHouseRepositoryInterface;
use App\Repositories\API\V1\PasswordList\PasswordListRepository;
use App\Repositories\API\V1\PasswordList\PasswordListRepositoryInterface;
use App\Repositories\API\V1\Profile\ProfileRepository;
use App\Repositories\API\V1\Profile\ProfileRepositoryInterface;
use App\Repositories\API\V1\Property\PropertyRepository;
use App\Repositories\API\V1\Property\PropertyRepositoryInterface;
use App\Repositories\API\V1\Property\Source\PropertySourceRepository;
use App\Repositories\API\V1\Property\Source\PropertySourceRepositoryInterface;
use App\Repositories\API\V1\SalesTrack\SalesTrackRepository;
use App\Repositories\API\V1\SalesTrack\SalesTrackRepositoryInterface;
use App\Repositories\API\V1\SharedNote\SharedNoteRepository;
use App\Repositories\API\V1\SharedNote\SharedNoteRepositoryInterface;
use App\Repositories\API\V1\Target\TargetRepository;
use App\Repositories\API\V1\Target\TargetRepositoryInterface;
use App\Repositories\API\V1\User\UserRepository as UserRepo;
use App\Repositories\API\V1\User\UserRepositoryInterface as UserRepoInter;
use App\Repositories\API\V1\UserYTC\UserYTCRepository;
use App\Repositories\API\V1\UserYTC\UserYTCRepositoryInterface;
use App\Repositories\API\V1\Vendor\VendorRepository;
use App\Repositories\API\V1\Vendor\VendorRepositoryInterface;
use App\Repositories\API\V1\VendorCategory\VendorCategoryRepository;
use App\Repositories\API\V1\VendorCategory\VendorCategoryRepositoryInterface;
use App\Repositories\API\V1\VendorReview\VendorReviewRepository;
use App\Repositories\API\V1\VendorReview\VendorReviewRepositoryInterface;
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
        $this->app->bind(ExpenseCategoryRepositoryInterface::class, ExpenseCategoryRepository::class);
        $this->app->bind(ExpenseSubCategoryRepositoryInterface::class, ExpenseSubCategoryRepository::class);
        $this->app->bind(ExpenseRepositoryInterface::class, ExpenseRepository::class);

        // product
        $this->app->bind(PropertyRepositoryInterface::class, PropertyRepository::class);
        $this->app->bind(PropertySourceRepositoryInterface::class, PropertySourceRepository::class);

        // moetod
        $this->app->bind(PaymentMethodRepositoryInterface::class, PaymentMethodRepository::class);

        // open house
        $this->app->bind(OpenHouseRepositoryInterface::class, OpenHouseRepository::class);

        // vendors category
        $this->app->bind(VendorCategoryRepositoryInterface::class, VendorCategoryRepository::class);

        // vendors
        $this->app->bind(VendorRepositoryInterface::class, VendorRepository::class);

        // vendors review
        $this->app->bind(VendorReviewRepositoryInterface::class, VendorReviewRepository::class);

        // target
        $this->app->bind(TargetRepositoryInterface::class, TargetRepository::class);

        // myai
        $this->app->bind(MyAIRepositoryInterface::class, MyAIRepository::class);
        $this->app->bind(MyAIMessageRepositoryInterface::class, MyAIMessageRepository::class);
        $this->app->bind(MyPRRepositoryInterface::class, MyPRRepository::class);
        $this->app->bind(MyPRMessageRepositoryInterface::class, MyPRMessageRepository::class);

        //shared note
        $this->app->bind(SharedNoteRepositoryInterface::class, SharedNoteRepository::class);

        //password list
        $this->app->bind(PasswordListRepositoryInterface::class, PasswordListRepository::class);

        // ytc
        $this->app->bind(UserYTCRepositoryInterface::class, UserYTCRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
