<!-- Social Media Floating Buttons -->
@php
    $contactInfo = $contactInfo ?? App\Models\ContactInfo::first();
    $whatsappNumber = $contactInfo?->whatsapp ?? ($contactInfo?->mobile ?? '+966853853835');
    $whatsappLink = 'https://wa.me/' . str_replace(['+', ' ', '-'], '', $whatsappNumber);
@endphp
<div class="social-float">
    <a href="{{ $whatsappLink }}" target="_blank" class="whatsapp-btn whatsapp-float" style="background-color: #31a760;">
        <div class="whatsapp-content">
            <img src="{{ asset('assets/images/WhatsApp_Icon.svg') }}" alt="{{ __('components.whatsapp.text') }}"
                class="whatsapp-icon">
            <span class="whatsapp-text d-none d-md-block">{{ __('components.whatsapp.text') }}</span>
        </div>
    </a>
