<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PropertySearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    private const OPENAI_URL = 'https://api.openai.com/v1/chat/completions';

    private PropertySearchService $propertySearch;

    public function __construct(PropertySearchService $propertySearch)
    {
        $this->propertySearch = $propertySearch;
    }

    /**
     * Proxy for OpenAI chat with tool (search_properties). Keeps API key server-side.
     */
    public function openai(Request $request): JsonResponse
    {
        $apiKey = config('services.openai.api_key');
        if (empty($apiKey)) {
            return response()->json(['error' => 'OpenAI API key not configured'], 500);
        }

        $userMessage = $request->input('userMessage');
        $history = $request->input('history', []);

        if (empty($userMessage) || ! is_string($userMessage)) {
            return response()->json(['error' => 'userMessage is required'], 400);
        }

        if (! is_array($history)) {
            $history = [];
        }

        $messages = array_merge($history, [
            ['role' => 'user', 'content' => $userMessage],
        ]);

        $tools = $this->getToolsDefinition();

        $firstPayload = [
            'model' => 'gpt-4o-mini',
            'messages' => $messages,
            'tools' => $tools,
            'tool_choice' => 'auto',
            'temperature' => 0.5,
            'max_tokens' => 300,
        ];

        $response = Http::withToken($apiKey)
            ->timeout(60)
            ->post(self::OPENAI_URL, $firstPayload);

        if (! $response->successful()) {
            Log::warning('OpenAI API error (step 1)', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return response()->json([
                'error' => 'OpenAI API error',
                'details' => $response->json(),
            ], 500);
        }

        $data = $response->json();
        $firstMessage = $data['choices'][0]['message'] ?? null;

        if (! $firstMessage) {
            return response()->json(['error' => 'Invalid OpenAI response'], 500);
        }

        $toolCalls = $firstMessage['tool_calls'] ?? [];
        if (empty($toolCalls)) {
            $reply = $firstMessage['content'] ?? 'I could not generate a response.';
            return response()->json(['reply' => $reply]);
        }

        $allProperties = [];
        $messages[] = [
            'role' => 'assistant',
            'content' => $firstMessage['content'] ?? null,
            'tool_calls' => $firstMessage['tool_calls'],
        ];

        foreach ($toolCalls as $toolCall) {
            $name = $toolCall['function']['name'] ?? '';
            if ($name !== 'search_properties') {
                continue;
            }
            $args = json_decode($toolCall['function']['arguments'] ?? '{}', true);
            if (! is_array($args)) {
                $args = [];
            }
            $results = $this->propertySearch->searchForChat($args);
            $allProperties = array_merge($allProperties, $results);
            $messages[] = [
                'role' => 'tool',
                'tool_call_id' => $toolCall['id'],
                'content' => json_encode(['results' => $results]),
            ];
        }

        $secondPayload = [
            'model' => 'gpt-4o-mini',
            'messages' => $messages,
            'tools' => $tools,
            'tool_choice' => 'none',
            'temperature' => 0.6,
            'max_tokens' => 400,
        ];

        $response2 = Http::withToken($apiKey)
            ->timeout(60)
            ->post(self::OPENAI_URL, $secondPayload);

        if (! $response2->successful()) {
            Log::warning('OpenAI API error (step 2)', [
                'status' => $response2->status(),
                'body' => $response2->body(),
            ]);
            return response()->json(['error' => 'OpenAI API error (step 2)'], 500);
        }

        $data2 = $response2->json();
        $finalMessage = $data2['choices'][0]['message'] ?? null;
        $finalReply = $finalMessage['content'] ?? 'Here are some properties that match your criteria.';

        $payload = ['reply' => $finalReply];
        if (! empty($allProperties)) {
            $payload['properties'] = $allProperties;
        }

        return response()->json($payload);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function getToolsDefinition(): array
    {
        return [
            [
                'type' => 'function',
                'function' => [
                    'name' => 'search_properties',
                    'description' => 'Search Dubai property listings from Savoir Privé backend',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'propertyType' => ['type' => 'string'],
                            'bedrooms' => ['type' => 'integer'],
                            'location' => ['type' => 'string'],
                            'minPrice' => ['type' => 'number'],
                            'maxPrice' => ['type' => 'number'],
                            'status' => ['type' => 'string', 'enum' => ['ready', 'off-plan']],
                            'purpose' => ['type' => 'string', 'enum' => ['buy', 'rent']],
                            'sortBy' => ['type' => 'string'],
                            'limit' => ['type' => 'integer'],
                        ],
                    ],
                ],
            ],
        ];
    }
}
