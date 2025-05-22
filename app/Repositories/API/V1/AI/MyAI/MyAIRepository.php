<?php

namespace App\Repositories\API\V1\AI\MyAI;

use App\Models\Contract;
use App\Models\Expense;
use App\Models\MyAI;
use App\Models\MyAIMessage;
use App\Models\Property;
use App\Models\SharedNote;
use App\Models\Target;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class MyAIRepository implements MyAIRepositoryInterface
{
    /**
     * createChat
     * @param int $user_id
     * @param string $name
     * @return MyAI
     */
    public function createChat(int $user_id, string $name)
    {
        try {
            return MyAI::create([
                'user_id' => $user_id,
                'name' => $name,
            ]);
        } catch (Exception $e) {
            Log::error('App\Repositories\API\V1\AI\MyAI\MYAIRepository::createChat', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * getChats
     * @param int $user_id
     */
    public function getChats(int $user_id)
    {
        try {
            return MyAI::whereUserId($user_id)->latest()->get();
        } catch (Exception $e) {
            Log::error('App\Repositories\API\V1\AI\MyAI\MYAIRepository::getChats', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

      public function getMyAI(int $userId): MyAI
    {
        return MyAI::where('user_id', $userId)->firstOrFail();
    }

    public function buildUserContext(User $user): string
    {
        $context = "User: {$user->first_name} {$user->last_name}\nEmail: {$user->email}\n";

        if ($user->profile) {
            $context .= "Date of Birth: {$user->profile->date_of_birth}\n";
        }

        // Load all related data in one shot
        $expenses = Expense::where('user_id', $user->id)->get();
        $contracts = Contract::where('agent', $user->id)->get();
        $properties = Property::where('agent', $user->id)->get();
        $targets = Target::where('user_id', $user->id)->get();
        $notes = SharedNote::where('business_id', optional($user->businesses->first())->id)->take(3)->get();

        // Expenses context
       if ($expenses->count()) {
    $context .= "Recent Expenses:\n";
    foreach ($expenses as $exp) {
        $context .= "- ID: {$exp->id}\n";
        $context .= "  Business ID: {$exp->business_id}\n";
        $context .= "  User ID: {$exp->user_id}\n";
        $context .= "  Expense For ID: {$exp->expense_for_id}\n";
        $context .= "  Category ID: {$exp->expense_category_id}\n";
        $context .= "  Subcategory ID: {$exp->expense_sub_category_id}\n";
        $context .= "  Description: {$exp->description}\n";
        $context .= "  Amount: {$exp->amount}\n";
        $context .= "  Payment Method ID: {$exp->payment_method_id}\n";
        $context .= "  Payee: {$exp->payee}\n";
        $context .= "  Receipt Name: {$exp->recept_name}\n";
        $context .= "  Receipt URL: {$exp->recept_url}\n";
        $context .= "  Reimbursable: " . ($exp->reimbursable ? 'Yes' : 'No') . "\n";
        $context .= "  Listing: {$exp->listing}\n";
        $context .= "  Note: {$exp->note}\n";
        $context .= "  Status: {$exp->status}\n";
        $context .= "  Archived: " . ($exp->archive ? 'Yes' : 'No') . "\n";
        $context .= "  Deleted At: {$exp->deleted_at}\n";
        $context .= "  Created At: {$exp->created_at}\n";
        $context .= "  Updated At: {$exp->updated_at}\n";
        $context .= "--------------------------\n";
    }
} else {
    $context .= "No recent expenses.\n";
}

        // Contracts
        if ($contracts->count()) {
            $context .= "Recent Contracts:\n";
            foreach ($contracts as $contract) {
                $context .= "- {$contract->address}, Price: {$contract->price}, Closing Date: {$contract->closing_data}\n";
            }
        } else {
            $context .= "No recent contracts.\n";
        }

        // Properties
        if ($properties->count()) {
            $context .= "Properties:\n";
            foreach ($properties as $property) {
                $context .= "- {$property->address} | Price: {$property->price}, Beds: {$property->beds}\n";
            }
        } else {
            $context .= "No recent properties.\n";
        }

        // Targets
        if ($targets->count()) {
            $context .= "Sales Targets:\n";
            foreach ($targets as $target) {
                $context .= "- {$target->month}: {$target->amount} for {$target->for}\n";
            }
        } else {
            $context .= "No recent targets.\n";
        }

        // Notes
        if ($notes->count()) {
            $context .= "Shared Notes:\n";
            foreach ($notes as $note) {
                $context .= "- {$note->title}: {$note->notes}\n";
            }
        } else {
            $context .= "No recent notes.\n";
        }

        return $context;
    }

    public function saveChatMessage(int $myAIId, string $question, string $response): void
    {
        MyAIMessage::create([
            'my_a_i_id' => $myAIId,
            'message' => $question,
            'response' => $response
        ]);
    }
}
