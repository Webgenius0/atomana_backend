<?php

namespace App\Services\API\V1\AI;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DatabaseAIService
{
     protected $apiKey;

    /**
     * construct
     */
    public function __construct()
    {
        $this->apiKey = config('services.openai.key');
    }
    public function askAI(array $messages, array $functions = [], string $model = 'gpt-4')
{
    try {
        $payload = [
            'model' => $model,
            'messages' => $messages,
            'temperature' => 1,
            'max_tokens' => 2048,
            'top_p' => 1,
        ];

        if (!empty($functions)) {
            $payload['tools'] = [
                [
                    'type' => 'function',
                    'function' => $functions[0]
                ]
            ];
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type'  => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', $payload);

        return $response->json();
    } catch (Exception $e) {
        Log::error("App\Services\API\V1\AI\OpenAIService::chat", ['error' => $e->getMessage()]);
        return ['error' => $e->getMessage()];
    }
}

}
