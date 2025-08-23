@extends('user.layout.layout')

@section('content')
    @include('user.components.header')
    <!-- Contact Form Only -->
    <section class="contact-section">
        <div class="contact-container">
            <!-- Title Section -->
            <div class="contact-header">
                <h2 class="contact-main-title">{{ __('packages.contact.title') }}</h2>
            </div>

            <div class="contact-content">
                <!-- Contact Info Section -->
                <div class="contact-info-section">
                    <h3>{{ __('packages.contact.info_title') }}</h3>

                    <div class="contact-info-item">
                        <div class="contact-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                            </svg>
                        </div>
                        <div class="contact-details">
                            <span class="contact-label">{{ __('packages.contact.phone_label') }}</span>
                            <span class="contact-value">{{ $contactInfo->mobile ?? '+966853853835' }}</span>
                        </div>
                        <button class="copy-btn" onclick="copyToClipboard('{{ $contactInfo->mobile ?? '+966853853835' }}')"
                            title="{{ __('packages.contact.copy_phone') }}">
                            <img src="{{ asset('assets/images/copyicon.svg') }}"
                                alt="{{ __('packages.contact.copy_phone') }}">
                        </button>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                        </div>
                        <div class="contact-details">
                            <span class="contact-label">{{ __('packages.contact.email_label') }}</span>
                            <span class="contact-value">{{ $contactInfo->email ?? 'info@smartup.com' }}</span>
                        </div>
                        <button class="copy-btn"
                            onclick="copyToClipboard('{{ $contactInfo->email ?? 'info@smartup.com' }}')"
                            title="{{ __('packages.contact.copy_email') }}">
                            <img src="{{ asset('assets/images/copyicon.svg') }}"
                                alt="{{ __('packages.contact.copy_email') }}">
                        </button>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                        </div>
                        <div class="contact-details">
                            <span class="contact-label">{{ __('packages.contact.location_label') }}</span>
                            <span class="contact-value">{!! $contactInfo->address ?? 'الرياض<br>مركبة، طريق الملك فهد' !!}</span>
                        </div>
                        <button class="link-btn"
                            onclick="window.open('https://maps.google.com/?q={{ urlencode($contactInfo->address ?? 'الرياض مركبة طريق الملك فهد') }}', '_blank')"
                            title="{{ __('packages.contact.open_location') }}">
                            <img src="{{ asset('assets/images/link-icon.svg') }}"
                                alt="{{ __('packages.contact.open_location') }}">
                        </button>
                    </div>

                    <div class="contact-social">
                        <span class="social-label">{{ __('packages.contact.social_label') }}</span>
                        <div class="social-links">
                            @if ($contactInfo && $contactInfo->X)
                                <a href="{{ $contactInfo->X }}" class="social-link">
                                @else
                                    <a href="#" class="social-link">
                            @endif
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                            </svg>
                            </a>
                            @if ($contactInfo && $contactInfo->instagram)
                                <a href="{{ $contactInfo->instagram }}" class="social-link">
                                @else
                                    <a href="#" class="social-link">
                            @endif
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z" />
                            </svg>
                            </a>
                            @if ($contactInfo && $contactInfo->linkedin)
                                <a href="{{ $contactInfo->linkedin }}" class="social-link">
                                @else
                                    <a href="#" class="social-link">
                            @endif
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.097.118.112.222.083.343-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.001z" />
                            </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Form Section -->
                <div class="contact-form-section">
                    <form class="contact-form" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone">{{ __('packages.contact.form.phone') }}</label>
                                <div class="phone-input-group">
                                    <span class="country-flag">🇸🇦</span>
                                    <input type="tel" id="phone" name="phone"
                                        placeholder="{{ __('packages.contact.form.phone_placeholder') }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">{{ __('packages.contact.form.name') }}</label>
                                <input type="text" id="name" name="name"
                                    placeholder="{{ __('packages.contact.form.name_placeholder') }}" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="subject">{{ __('packages.contact.form.subject') }}</label>
                                <input type="text" id="subject" name="subject"
                                    placeholder="{{ __('packages.contact.form.subject_placeholder') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('packages.contact.form.email') }}</label>
                                <input type="email" id="email" name="email"
                                    placeholder="{{ __('packages.contact.form.email_placeholder') }}" required>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label for="message">{{ __('packages.contact.form.message') }}</label>
                            <textarea id="message" name="message" rows="2"
                                placeholder="{{ __('packages.contact.form.message_placeholder') }}" required></textarea>
                        </div>

                        <button type="submit" class="contact-submit-btn">
                            <span>{{ __('packages.contact.form.submit') }}</span>
                            <img src="{{ asset('assets/images/send.svg') }}"
                                alt="{{ __('packages.contact.form.submit') }}">
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection


