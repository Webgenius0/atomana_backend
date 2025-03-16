<?php

namespace App\Services\API\V1\AI;

use Illuminate\Support\Facades\Http;

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


    public function chat($message, $model = 'gpt-3.5-turbo')
    {
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
    }
}
