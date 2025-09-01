<!-- Footer -->
@php
    $contactInfo = $contactInfo ?? App\Models\ContactInfo::first();
@endphp
<footer class="footer">
    <div class="footer-container">
        <!-- Footer Content -->
        <div class="footer-content">
            <!-- Logo Section -->
            <div class="footer-section footer-logo-section">
                <div class="footer-logo">
                    <img src="{{ $contactInfo?->logo ?? asset('assets/images/Smart UP Logo_Artboard 4.svg') }}"
                        alt="SMARTUP" class="footer-logo-image">
                </div>
            </div>

            <!-- Services Section -->
            <div class="footer-section">
                <h3 class="footer-title">{{ __('components.footer.quick_links') }}</h3>
                <div class="footer-links footer-links-two-columns">
                    <div class="footer-links-column">
                        <a href="{{ route('home') }}#testimonials"
                            class="footer-link">{{ __('components.footer.links.testimonials') }}</a>
                        <a href="{{ route('home') }}" class="footer-link">{{ __('components.footer.links.home') }}</a>
                        <a href="{{ route('home') }}#about"
                            class="footer-link">{{ __('components.footer.links.branches') }}</a>
                        <a href="{{ route('home') }}#about"
                            class="footer-link">{{ __('components.footer.links.about') }}</a>
                    </div>
                    <div class="footer-links-column">
                        <a href="{{ route('contact-us') }}"
                            class="footer-link">{{ __('components.footer.links.contact') }}</a>
                        <a href="{{ route('home') }}#services"
                            class="footer-link">{{ __('components.footer.links.services') }}</a>
                        <a href="{{ route('userpackages') }}"
                            class="footer-link">{{ __('components.footer.links.packages') }}</a>
                    </div>
                </div>
            </div>

            <!-- Packages Section -->
            <div class="footer-section">
                <h3 class="footer-title">{{ __('components.footer.packages') }}</h3>
                <div class="footer-links">
                    <a href="{{ route('userpackages') }}"
                        class="footer-link">{{ __('components.footer.links.basic_package') }}</a>
                    <a href="{{ route('userpackages') }}"
                        class="footer-link">{{ __('components.footer.links.integrated_package') }}</a>
                    <a href="{{ route('userpackages') }}"
                        class="footer-link">{{ __('components.footer.links.security_package') }}</a>
                    <a href="{{ route('userpackages') }}"
                        class="footer-link">{{ __('components.footer.links.custom_package') }}</a>
                </div>
            </div>

            <!-- Contact Section -->
            <div class="footer-section">
                <h3 class="footer-title">{{ __('components.footer.contact') }}</h3>
                <div class="footer-links">
                    <a href="{{ route('contact-us') }}"
                        class="footer-link">{{ __('components.footer.links.contact') }}</a>
                    <div class="footer-contact-item">
                        <span>{{ $contactInfo?->mobile ?? '+966853853835' }}</span>
                    </div>
                    <div class="footer-contact-item">
                        <span>{{ $contactInfo?->email ?? 'SmartUp@gmail.com' }}</span>
                    </div>
                </div>
            </div>

            <!-- Social Media Section -->
            <div class="footer-section">
                <h3 class="footer-title">{{ __('components.footer.social_media') }}</h3>
                <div class="footer-social-icons">
                    @if ($contactInfo && $contactInfo->youtube)
                        <a href="{{ $contactInfo->youtube }}" class="footer-social-link">
                        @else
                            <a href="#" class="footer-social-link">
                    @endif
                     <i class="fab fa-youtube"></i>
                    @if ($contactInfo && $contactInfo->snapchat)
                        <a href="{{ $contactInfo->snapchat }}" class="footer-social-link">
                        @else
                            <a href="#" class="footer-social-link">
                    @endif
                    <i class="fab fa-snapchat"></i>
                    </a>
                    @if ($contactInfo && $contactInfo->tiktok)
                        <a href="{{ $contactInfo->tiktok }}" class="footer-social-link">
                        @else
                            <a href="#" class="footer-social-link">
                    @endif
                    <i class="fab fa-tiktok"></i>
                    </a>
                    @if ($contactInfo && $contactInfo->instagram)
                        <a href="{{ $contactInfo->instagram }}" class="footer-social-link">
                        @else
                            <a href="#" class="footer-social-link">
                    @endif
                    <i class="fab fa-instagram"></i>
                    </a>
                    @if ($contactInfo && $contactInfo->facebook)
                        <a href="{{ $contactInfo->facebook }}" class="footer-social-link">
                        @else
                            <a href="#" class="footer-social-link">
                    @endif
                    <i class="fab fa-facebook"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p class="footer-copyright">{{ __('components.footer.copyright') }}</p>
        </div>
    </div>
</footer>
