<?php

namespace App\Services\API\V1\AI;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    protected $apiKey;

    /**
     * construct
     */
    public function __construct()
    {
        $this->apiKey = config('services.openai.key');
    }

    /**
     * chat
     * @param mixed $message
     * @param mixed $model
     */
    public function chat($message, $model = 'gpt-4-turbo')
    {
        try{
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model'    => $model,
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                    ['role' => 'user', 'content' => $message],
                ],
                'temperature' => 0.7,
                'max_tokens'  => 150,
            ]);

            return $response->json();
        }catch (Exception $e){
            Log::error("App\Services\API\V1\AI\OpenAIService::chat", ['error' => $e->getMessage()]);
        }

    }
}
