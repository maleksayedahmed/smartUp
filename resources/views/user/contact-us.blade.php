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
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff" transform="rotate(0)matrix(1, 0, 0, 1, 0, 0)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 18C15.3137 18 18 15.3137 18 12C18 8.68629 15.3137 6 12 6C8.68629 6 6 8.68629 6 12C6 15.3137 8.68629 18 12 18ZM12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16Z" fill="#0F0F0F"></path> <path d="M18 5C17.4477 5 17 5.44772 17 6C17 6.55228 17.4477 7 18 7C18.5523 7 19 6.55228 19 6C19 5.44772 18.5523 5 18 5Z" fill="#0F0F0F"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M1.65396 4.27606C1 5.55953 1 7.23969 1 10.6V13.4C1 16.7603 1 18.4405 1.65396 19.7239C2.2292 20.8529 3.14708 21.7708 4.27606 22.346C5.55953 23 7.23969 23 10.6 23H13.4C16.7603 23 18.4405 23 19.7239 22.346C20.8529 21.7708 21.7708 20.8529 22.346 19.7239C23 18.4405 23 16.7603 23 13.4V10.6C23 7.23969 23 5.55953 22.346 4.27606C21.7708 3.14708 20.8529 2.2292 19.7239 1.65396C18.4405 1 16.7603 1 13.4 1H10.6C7.23969 1 5.55953 1 4.27606 1.65396C3.14708 2.2292 2.2292 3.14708 1.65396 4.27606ZM13.4 3H10.6C8.88684 3 7.72225 3.00156 6.82208 3.0751C5.94524 3.14674 5.49684 3.27659 5.18404 3.43597C4.43139 3.81947 3.81947 4.43139 3.43597 5.18404C3.27659 5.49684 3.14674 5.94524 3.0751 6.82208C3.00156 7.72225 3 8.88684 3 10.6V13.4C3 15.1132 3.00156 16.2777 3.0751 17.1779C3.14674 18.0548 3.27659 18.5032 3.43597 18.816C3.81947 19.5686 4.43139 20.1805 5.18404 20.564C5.49684 20.7234 5.94524 20.8533 6.82208 20.9249C7.72225 20.9984 8.88684 21 10.6 21H13.4C15.1132 21 16.2777 20.9984 17.1779 20.9249C18.0548 20.8533 18.5032 20.7234 18.816 20.564C19.5686 20.1805 20.1805 19.5686 20.564 18.816C20.7234 18.5032 20.8533 18.0548 20.9249 17.1779C20.9984 16.2777 21 15.1132 21 13.4V10.6C21 8.88684 20.9984 7.72225 20.9249 6.82208C20.8533 5.94524 20.7234 5.49684 20.564 5.18404C20.1805 4.43139 19.5686 3.81947 18.816 3.43597C18.5032 3.27659 18.0548 3.14674 17.1779 3.0751C16.2777 3.00156 15.1132 3 13.4 3Z" fill="#0F0F0F"></path> </g></svg>
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
