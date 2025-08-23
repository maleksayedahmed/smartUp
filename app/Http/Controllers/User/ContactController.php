<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ContactFormMail;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function submitForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ], [
            'name.required' => __('validation.required', ['attribute' => __('packages.contact.form.name')]),
            'email.required' => __('validation.required', ['attribute' => __('packages.contact.form.email')]),
            'email.email' => __('validation.email'),
            'phone.required' => __('validation.required', ['attribute' => __('packages.contact.form.phone')]),
            'subject.required' => __('validation.required', ['attribute' => __('packages.contact.form.subject')]),
            'message.required' => __('validation.required', ['attribute' => __('packages.contact.form.message')]),
        ]);

        if ($validator->fails()) {
            // Log incoming request for debugging when validation fails
            Log::info('Contact form validation failed', [
                'input' => $request->all(),
                'errors' => $validator->errors()->all(),
            ]);

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all(),
                // include submitted input to help debug why fields appear empty
                'input' => $request->all(),
            ], 422);
        }

        try {
            // Persist the validated data and log the created ID for debugging
            $data = $validator->validated();
            $created = ContactMessage::create($data);

            Log::info('Contact message created', [
                'id' => $created->id ?? null,
                'data' => $data,
            ]);

            // Optionally send email to admin
            // Mail::to(config('mail.admin_email', 'admin@smartup.com'))
            //     ->send(new ContactFormMail($data));

            return response()->json([
                'status' => true,
                'message' => app()->getLocale() === 'ar'
                    ? 'تم إرسال رسالتك بنجاح. سنتواصل معك قريباً.'
                    : 'Your message has been sent successfully. We will contact you soon.'
            ]);

        } catch (\Exception $e) {
            Log::error('Contact message create failed', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return response()->json([
                'status' => false,
                'message' => app()->getLocale() === 'ar'
                    ? 'حدث خطأ أثناء إرسال الرسالة. يرجى المحاولة مرة أخرى.'
                    : 'An error occurred while sending your message. Please try again.'
            ], 500);
        }
    }

    public function bookConsultation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'package_interest' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 422);
        }

        try {
            // Store consultation request or send notification

            return response()->json([
                'status' => true,
                'message' => app()->getLocale() === 'ar'
                    ? 'تم حجز موعد الاستشارة بنجاح. سنتواصل معك قريباً.'
                    : 'Consultation appointment booked successfully. We will contact you soon.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => app()->getLocale() === 'ar'
                    ? 'حدث خطأ أثناء حجز الموعد. يرجى المحاولة مرة أخرى.'
                    : 'An error occurred while booking the appointment. Please try again.'
            ], 500);
        }
    }
}

