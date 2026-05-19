<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\Property;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    /**
     * Store a newly created enquiry in storage (AJAX).
     */
    public function store(Request $request, Property $property)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        $validated['property_id'] = $property->id;

        $enquiry = Enquiry::create($validated);

        try {
            \Illuminate\Support\Facades\Mail::send(
                'emails.enquiry',
                ['enquiry' => $enquiry, 'property' => $property],
                function ($message) use ($property) {
                    $message->to(config('mail.from.address'))
                            ->subject("New Enquiry for: {$property->title}");
                }
            );
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send enquiry email: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Your enquiry has been successfully submitted. We will contact you soon.'
        ]);
    }
}
