<?php

namespace App\Services\API\V1\AI\MyAI;

use App\Models\MyAI;
use App\Models\MyAIMessage;
use App\Repositories\API\V1\AI\MyAI\MyAIMessageRepositoryInterface;
use App\Repositories\API\V1\AI\MyAI\MyAIRepositoryInterface;
use App\Services\API\V1\AI\OpenAIService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MyAIService
{
    protected MyAIRepositoryInterface $myAIRepository;
    protected MyAIMessageRepositoryInterface $myAIMessageRepository;
    protected OpenAIService $openAIService;
    protected $user;

    protected string $systemPrompt = <<<PROMPT
You are a controlled‑response assistant.

INSTRUCTIONS
1. Strip leading/trailing spaces and make the user’s question lowercase.
2. Compare it to the five “allowed questions” below (also lowercase).
3. If the user’s question is **semantically almost identical** to one of the allowed questions—e.g., it asks for the same information with the same meaning, even if phrased differently—return the paired answer *word‑for‑word* (no additions, omissions, or re‑formatting).
4. If it does **not** clearly match any allowed question, respond only with:
   I’m sorry this is just a beta version

ALLOWED QUESTIONS → AUTHORIZED ANSWERS

Q1: how do i access 3504 e county hwy 30a?
A1:
Here are the access instructions for 3504 E County Hwy 30A:

Gate Code: #4321

Once through the gate, follow the road to the right. The home is located third house on the left, just past the white fence.

There is ample parking in the circular drive.

Front door lockbox code: 8890

Lockbox is located on the right side of the door, mounted under the light fixture.

Please ensure you lock the door and scramble the code after the showing.

Wi‑Fi info is listed inside on the kitchen counter if needed for your device during the showing.

–––

Q2: can you give me the main details for 3504 e county hwy 30a?
A2:
Certainly! Here's a detailed summary of 3504 E County Hwy 30A:

Bedrooms/Bathrooms: 5 Bed / 5.5 Bath
Square Footage: 3,800 sq ft
Year Built: 2021
Lot Size: 0.45 acres
Rental Ready: Fully furnished, turnkey property
Location: Gulf‑front, right on 30A with private beach access
Foundation: Elevated on concrete pilings – excellent for flood and storm resistance
Interior: Open‑concept floorplan, Frame TVs in every room for a sleek modern look, designer lighting and furnishings
Kitchen: Sub‑Zero and Wolf appliances, quartz countertops
Extras: Heated private pool, outdoor kitchen, elevator, multiple gulf‑facing balconies
HOA Fees: None
Rental Projections: ~$375,000/year

This property is a high‑performance rental asset with strong appreciation potential in a prime location.

–––

Q3: how is sally sue performing this year?
A3:
Here’s Sally Sue’s performance summary so far this year:

Total Sales Volume: $8,000,000
Total Units Sold: 10
Average Sales Price: $800,000

Commission Rate: 2.5% on all deals
Gross Commission (2.5%): $200,000
Brokerage Cut (10% off the top): $20,000
Net Commission After Brokerage: $180,000

Split (You 30% / Sally 70%):
Sally’s Take: $126,000
Your Take: $54,000

Lead Source Breakdown:
• Internet Leads – 4 deals (~$3.2 M)
• Repeat Clients – 3 deals (~$2.4 M)
• Sign Calls – 2 deals (~$1.4 M)
• Agent Referral – 1 deal (~$1 M)

Sally’s strongest channels are internet leads and repeat clients, with the highest volume and most consistent conversion. Her performance is solid, and she’s bringing in a healthy mix of lead sources.

--
Maria Coukoulis
Chief Operating Officer
Head of Public Relations
C: 561‑504‑3583
www.spearsgroupfl.com

–––

Q4: how much have i spent on marketing for 3504 e county hwy 30a?
A4:
Here’s a breakdown of your marketing expenses for 3504 E County Hwy 30A so far:

Professional Photography & Videography: $1,200
3D Matterport Tour: $450
Property Website & Domain: $275
Facebook & Instagram Ads: $1,000
Google Display Ads: $600
Email Blast Campaigns (×3): $375
Local Print Ad (Emerald Coast Magazine): $650
Direct Mail Postcards (500 units): $320
Twilight Drone Shoot Add‑On: $250
Staging Consultation Fee: $500

Total Spent: **$5,620**

–––

Q5: how many open houses have i held for 3504 e county hwy 30a?
A5:
You’ve held **3** open houses for 3504 E County Hwy 30A. Here’s the feedback recap:

📅 Feb 10 2025 – Agent Mike Reynolds: “Loved the finishes; add outdoor screening for privacy.”
📅 Mar  3 2025 – Agent Kayla Tran: “Pool great for renters; closet felt tight.”
📅 Apr  6 2025 – Agent Taylor Scott: “Visitors said home is ‘move‑in ready’; some insurance‑cost concern.”
PROMPT;


    /**
     * construct
     * @param \App\Repositories\API\V1\AI\MyAI\MyAIRepositoryInterface $myAIRepository
     * @param \App\Repositories\API\V1\AI\MyAI\MyAIMessageRepositoryInterface $myAIMessageRepository
     * @param \App\Services\API\V1\AI\OpenAIService $openAIService
     */
    public function __construct(MyAIRepositoryInterface $myAIRepository, MyAIMessageRepositoryInterface $myAIMessageRepository, OpenAIService $openAIService)
    {
        $this->myAIRepository = $myAIRepository;
        $this->myAIMessageRepository = $myAIMessageRepository;
        $this->openAIService = $openAIService;
        $this->user = Auth::user();
    }

    /**
     * getChat
     */
    public function getChat()
    {
        try {
            return $this->myAIRepository->getChats($this->user->id);
        } catch (Exception $e) {
            Log::error('App\Services\API\V1\AI\MyAI\MYAIService::getMessageList', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * createNewChat
     * @param string $message
     * @throws Exception
     * @return array{message: mixed, message_id: mixed, new_chat_id: mixed, new_chat_name: mixed, response: mixed}
     */
    public function createNewChat(string $message): array
    {
        try {
            $message = $this->systemPrompt. ' ' . $message;
            $response = $this->openAIService->chat($message);
            if (isset($response['id'])) {
                $responseMessage = $response['output'][0]['content'][0]['text'];
                $newChat = $this->myAIRepository->createChat($this->user->id, substr($responseMessage, 0, 10) . '...');
                $message = $this->myAIMessageRepository->saveChat($newChat->id, $message, $responseMessage,);
                return [
                    $newChat,
                    $message
                ];
            }
            throw new Exception($response);
        } catch (Exception $e) {
            Log::error('App\Services\API\V1\AI\MyAI\MYAIService::createNewChat', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * getChatMessages
     * @param int $myAIId
     */
    public function getChatMessages(int $myAIId)
    {
        try {
            return $this->myAIMessageRepository->getChets($myAIId);
        } catch (Exception $e) {
            Log::error('App\Services\API\V1\AI\MyAI\MYAIService::getMessageChat', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * saveChat
     * @param \App\Models\MyAI $myAI
     * @param string $message
     * @throws \Exception
     * @return MyAIMessage
     */
    public function saveChat(int $myAIId, string $message): MyAIMessage
    {
        try {
            $history = $this->myAIMessageRepository->getChets($myAIId);
            // Format the history
            $messages = [];
            foreach ($history as $item) {
                $messages[] = ['role' => 'user', 'content' => $item->message];
                $messages[] = ['role' => 'assistant', 'content' => $item->response];
            }
            $messages[] = ['role' => 'user', 'content' => $message];
            $response = $this->openAIService->chat($messages);
            if (isset($response['id'])) {
                $responseMessage = $response['output'][0]['content'][0]['text'];

                $message = $this->myAIMessageRepository->saveChat($myAIId, $message, $responseMessage);
                return $message;
            }
            throw new Exception($response);
        } catch (Exception $e) {
            Log::error('App\Services\API\V1\AI\MyAI\MYAIService::saveChat', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
