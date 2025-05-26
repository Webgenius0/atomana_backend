<?php

namespace App\Repositories\API\V1\AI\MyAI;

use App\Models\Contract;
use App\Models\Expense;
use App\Models\MyAI;
use App\Models\MyAIMessage;
use App\Models\Property;
use App\Models\SalesTrack;
use App\Models\SharedNote;
use App\Models\Target;
use App\Models\User;
use App\Models\Vendor;
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

    /**
     * 
     */
    public function buildUserContext(User $user): string
    {
        $context = "User: {$user->first_name} {$user->last_name}\nEmail: {$user->email}\n";

        if ($user->profile) {
            $context .= "Date of Birth: {$user->profile->date_of_birth}\n";
        }

        // Load all related data in one shot
        $expenses = Expense::with('expenseFor', 'category', 'subCategory', 'paymentMethord', 'business')->where('user_id', $user->id)->get();
        $contracts = Contract::where('agent', $user->id)->get();
        $properties = Property::with('business', 'openHouseFeedback', 'openHouses', 'accessInstruction', 'source')->whereIn('business_id', $user->businesses->pluck('id'))->get();
        $salesTracks = SalesTrack::with('property')->where('user_id', $user->id)->latest()->get();
        $targets = Target::where('user_id', $user->id)->get();
        $notes = SharedNote::where('business_id', optional($user->businesses->first())->id)->latest()->get();
        $vendor = Vendor::with('business', 'category')->whereIn('business_id', $user->businesses->pluck('id'))->get();
        $vendorReview = $user->vendorReviews()->latest()->get();

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
                if ($exp->expenseFor) {
                    $context .= "  Expense For: {$exp->expenseFor->name}\n";
                }
                if ($exp->category) {
                    $context .= "  Category: {$exp->category->name}\n";
                }
                if ($exp->subCategory) {
                    $context .= "  Subcategory: {$exp->subCategory->name}\n";
                }
                if ($exp->paymentMethord) {
                    $context .= "  Payment Method: {$exp->paymentMethord->name}\n";
                }
                if ($exp->business) {
                    $context .= "  Licence: {$exp->business->licence}\n";
                    $context .= "  ECAR ID: {$exp->business->ecar_id}\n";
                }

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
                $context .= "- Address: " . ($property->address ?: 'Not provided') . "\n";
                $context .= "  Price: {$property->price}\n";
                $context .= "  Beds: {$property->beds}\n";
                $context .= "  Baths: {$property->full_baths}\n";
                $context .= "  Size: {$property->size}\n";
                $context .= "  Link: {$property->link}\n";
                $context .= "  Note: {$property->note}\n";

                $feedback = $property->openHouseFeedback->first();
                if ($feedback) {
                    $context .= "  Open House Feedback: {$feedback->feedback}\n";
                    $context .= "  Additional Feedback: {$feedback->additional_feedback}\n";
                    $context .= "  People Count: {$feedback->people_count}\n";
                }
                $openHouse = $property->openHouses->first();
                if ($openHouse) {
                    $context .= "  Open House Date: {$openHouse->date}\n";
                    $context .= "  Open House start time: {$openHouse->start_time}\n";
                    $context .= "  Open House end time: {$openHouse->end_time}\n";
                    $context .= "  Open House sign number: {$openHouse->sign_number}\n";
                }
                if ($property->accessInstruction) {
                    $context .= "  Access Instruction Size: {$property->accessInstruction->size}\n";
                    $context .= "  Access Instruction Key: {$property->accessInstruction->access_key}\n";
                    $context .= "  Access Instruction Location: {$property->accessInstruction->lock_box_location}\n";
                    $context .= "  Access Instruction Pickup Instructions: {$property->accessInstruction->pickup_instructions}\n";
                    $context .= "  Access Instruction Gate Code: {$property->accessInstruction->gate_code}\n";
                    $context .= "  Access Instruction Gate Location: {$property->accessInstruction->gete_access_location}\n";
                    $context .= "  Access Instruction Visitor Parking: {$property->accessInstruction->visitor_parking}\n";
                    $context .= "  Access Instruction Note: {$property->accessInstruction->note}\n";
                }
                if ($property->source) {
                    $context .= "  Source: {$property->source->name}\n";
                }
            }
        } else {
            $context .= "No recent properties.\n";
        }
        // Sales Tracks
        if ($salesTracks->count()) {
            $context .= "Recent Sales Tracks:\n";
            foreach ($salesTracks as $track) {

                $context .= "  Date Under Contract: {$track->date_under_contract}\n";
                $context .= "  Date Closing Date: {$track->closing_date}\n";
                $context .= "  Purchase Price: {$track->purchase_price}\n";
                $context .= "  Buyer Seller: {$track->buyer_seller}\n";
                $context .= "  Referral Fee: {$track->referral_fee_pct}\n";
                $context .= "  Commission On Sale: {$track->commission_on_sale}\n";
                $context .= "  Override Split: {$track->override_split}\n";
                $context .= "  Note: {$track->note}\n";
            }
        } else {
            $context .= "No recent sales tracks.\n";
        }

        // Targets
        if ($targets->count()) {
            $context .= "Sales Targets:\n";
            foreach ($targets as $target) {
                $context .= "  Target Date: {$target->month}\n";
                $context .= "  Target Amount: {$target->amount}\n";
            }
        } else {
            $context .= "No recent targets.\n";
        }

        // share Notes
        if ($notes->count()) {
            $context .= "Shared Notes:\n";
            foreach ($notes as $note) {
                $context .= "- {$note->title}: {$note->notes}\n";
            }
        } else {
            $context .= "No recent notes.\n";
        }
        if ($vendor->count()) {
            $context .= "Vendors:\n";
            foreach ($vendor as $ven) {
                $context .= "- Name: {$ven->name}\n";
                $context .= "  Website: {$ven->website}\n";
                $context .= "  Email: {$ven->email}\n";
                $context .= "  Phone: {$ven->phone}\n";
                $context .= "  About: {$ven->about}\n";
                $context .= "  Additional Note: {$ven->additional_note}\n";
                if ($ven->category) {
                    $context .= "  Category: {$ven->category->name}\n";
                }
                $context .= "--------------------------\n";
            }
        } else {
            $context .= "No recent vendors.\n";
        }

        // Vendor Reviews
        if ($vendorReview->count()) {
            $context .= "Vendor Reviews:\n";
            foreach ($vendorReview as $review) {
                $context .= "- Comment: {$review->comment}\n";
            }
        } else {
            $context .= "No recent vendor reviews.\n";
        }

        // dd($context);

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
