<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiController extends Controller
{
    /**
     * Generate a property description using Gemini API.
     */
    public function generateDescription(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'city' => 'required|string',
            'property_type_id' => 'required|exists:property_types,id',
        ]);

        $type = PropertyType::find($validated['property_type_id']);
        
        $prompt = "Generate a professional, compelling, and concise real-estate property description for a " . $type->name . " located in " . $validated['city'] . " with the title: '" . $validated['title'] . "'. The description should highlight luxury, convenience, and be around 3 to 4 sentences long. Do not use any markdown formatting like ** or ##. Just return plain text.";

        $apiKey = config('services.gemini.key');

        if (empty($apiKey)) {
            // Local fallback template if no API key is provided
            return response()->json([
                'success' => true,
                'description' => "Experience the best of {$validated['city']} living with this spectacular {$type->name}. \"{$validated['title']}\" offers a perfect blend of modern convenience and timeless elegance. Enjoy spacious interiors, premium finishes, and a vibrant neighborhood that caters to all your lifestyle needs. Don't miss this rare opportunity to secure your dream home."
            ]);
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 800,
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $description = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
                
                return response()->json([
                    'success' => true,
                    'description' => trim($description)
                ]);
            }

            Log::error('Gemini API Error: ' . $response->body());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate description from AI API.'
            ], 500);

        } catch (\Exception $e) {
            Log::error('Gemini API Exception: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while communicating with the AI service.'
            ], 500);
        }
    }
}
