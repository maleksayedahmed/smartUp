<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ConsultationController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'action_date' => 'date|required',
            'action_time' => 'string|max:10',
        ], [
            'name.required' =>" __('validation.required')",
            'phone.required' => __('validation.required'),
            'email.email' => __('validation.email'),
            'action_date.required' => __('validation.required'),
            'action_date.date' => __('validation.date'),
            'action_time.string' => __('validation.time'),
        ]

    );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => __('validation.validation_failed'),
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Prepare data for CRM API
            $data = [
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email', ''),
                'action_date' => $request->input('action_date'),
                'action_time' => $request->input('action_time'),
            ];

            // Send request to CRM API
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->withOptions([
                'verify' => false, // Disable SSL verification for local development
                'timeout' => 30,   // Set timeout to 30 seconds
            ])->post('https://crm.smartup.sa/api/store-lead', $data);


            if ($response->successful()) {
                Log::info('CRM API Success: Lead stored successfully', ['data' => $data]);
                return response()->json([
                    'success' => true,
                    'message' => __('messages.consultation_success')
                ]);
            } else {
                Log::error('CRM API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'data_sent' => $data
                ]);
                return response()->json([
                    'success' => false,
                    'message' => __('messages.consultation_error')
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Consultation submission error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => __('messages.consultation_error')
            ], 500);
        }
    }
}
