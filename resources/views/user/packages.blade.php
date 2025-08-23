@extends('user.layout.layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/packages.css') }}">
@endsection

@section('content')
    @include('user.components.header')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-title-container">
                    @php
                        $activePackage = $packages->firstWhere('slug', 'security') ?? $packages->first();
                    @endphp
                    <h1 class="hero-title">{{ $activePackage?->getTranslation('title', app()->getLocale()) ?? 'باقة' }}</h1>
                    <p class="hero-subtitle">{{ $activePackage?->getTranslation('desc', app()->getLocale()) ?? '' }}</p>
                    <script type="application/json" id="packages-json" data-locale="{{ app()->getLocale() }}">
                        {!! $packages->map(function($p){
                            return [
                                'slug' => $p->slug,
                                'title' => $p->getTranslations('title'),
                                'desc' => $p->getTranslations('desc'),
                                'benefits' => $p->benefits->map(function($b){
                                    return [
                                        'number' => $b->number,
                                        'label' => $b->getTranslations('label'),
                                    ];
                                })->values(),
                                'systems' => $p->systems->map(function($s){
                                    return [
                                        'slug' => $s->slug,
                                        'title' => $s->getTranslations('title'),
                                        'description' => $s->getTranslations('description'),
                                        'images' => $s->getMedia('images')->map(fn($m)=>$m->getUrl())->values(),
                                        'features' => $s->features->map(fn($f)=>$f->getTranslations('title'))->values(),
                                    ];
                                })->values(),
                            ];
                        })->values()->toJson(JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}
                    </script>
                </div>

                <!-- Package Tabs -->
                <div class="package-tabs">
                    @foreach ($packages ?? collect() as $pkg)
                        <button class="package-tab {{ $loop->first ? 'active' : '' }}"
                            data-package="{{ $pkg->slug ?? 'pkg' . $pkg->id }}" data-default-system="cameras"
                            data-title="{{ $pkg->getTranslation('title', app()->getLocale()) }}"
                            data-subtitle="{{ $pkg->getTranslation('desc', app()->getLocale()) }}">{{ $pkg->title }}</button>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Integrated Systems and Package Detail Section -->
    <section class="package-detail-section">
        <div class="package-detail-container">
            <!-- Systems Tabs -->
            <div class="systems-tabs-container">
                <h2 class="systems-title">{{ __('packages.systems_title') }}</h2>
                <div class="systems-tabs">
                    @php $systems = ($activePackage?->systems ?? collect()); @endphp
                    @foreach ($systems as $sys)
                        <button class="system-tab {{ $loop->first ? 'active' : '' }}"
                            data-system="{{ $sys->slug ?? 'sys' . $sys->id }}">
                            {{ $sys->getTranslation('title', app()->getLocale()) }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- System Content -->
            <div class="system-content">
                @foreach ($systems as $sys)
                    <div class="system-detail {{ $loop->first ? 'active' : '' }}"
                        data-system="{{ $sys->slug ?? 'sys' . $sys->id }}">
                        <div class="package-detail-content">
                            <div class="package-visuals">
                                <div class="surveillance-video">
                                    <div class="video-container">
                                        <video src="" poster="{{ asset('assets/images/image-1.svg') }}" controls
                                            playsinline></video>
                                    </div>
                                </div>
                                <div class="camera-images">
                                    @foreach ($sys->getMedia('images') ?? collect() as $media)
                                        <div class="camera-image gallery-item" onclick="openModal(this)"
                                            data-src="{{ $media->getUrl() }}" data-title="" data-description="">
                                            <img src="{{ $media->getUrl() }}"
                                                alt="{{ $sys->getTranslation('title', app()->getLocale()) }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="package-content">
                                <div class="package-icon">
                                    <img src="{{ asset('assets/images/Security Camera Icon.svg') }}" alt="icon">
                                </div>
                                <div class="package-header">
                                    <h3 class="package-name">{{ $sys->getTranslation('title', app()->getLocale()) }}</h3>
                                    <p class="package-description">
                                        {{ $sys->getTranslation('description', app()->getLocale()) }}</p>
                                </div>
                                <div class="feature-tags">
                                    @foreach ($sys->features ?? collect() as $f)
                                        <span
                                            class="feature-tag">{{ $f->getTranslation('title', app()->getLocale()) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- <!-- Alarm System -->
                    <div class="system-detail" data-system="alarm">
                        <div class="package-detail-content">
                            <!-- Left Column - Visuals -->
                            <div class="package-visuals">
                                <div class="surveillance-video">
                                    <div class="video-container">
                                        <video src="./videos/camera-demo.mp4" poster="{{ asset('assets/images/image-1.svg') }}"
                                            controls playsinline></video>
                                    </div>
                                </div>
                                <div class="camera-images">
                                    <div class="camera-image gallery-item" onclick="openModal(this)"
                                        data-src="{{ asset('assets/images/Security Camera Icon.svg') }}" data-title=""
                                        data-description="">
                                        <img src="{{ asset('assets/images/Security Camera Icon.svg') }}" alt="نظام إنذار">
                                    </div>
                                    <div class="camera-image gallery-item" onclick="openModal(this)"
                                        data-src="{{ asset('assets/images/Security Camera Icon.svg') }}" data-title=""
                                        data-description="">
                                        <img src="{{ asset('assets/images/Security Camera Icon.svg') }}" alt="نظام إنذار">
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Content -->
                            <div class="package-content">
                                <div class="package-icon">
                                    <img src="{{ asset('assets/images/Security Camera Icon.svg') }}" alt="إنذار">
                                </div>
                                <div class="package-header">
                                    <h3 class="package-name">نظام إنذار متكامل</h3>
                                    <p class="package-description">حماية متقدمة مع تنبيهات فورية ومراقبة شاملة</p>
                                </div>

                                <!-- Feature Tags -->
                                <div class="feature-tags">
                                    <span class="feature-tag">كشف التسلل</span>
                                    <span class="feature-tag">تنبيهات صوتية</span>
                                    <span class="feature-tag">مراقبة 24/7</span>
                                    <span class="feature-tag">اتصال بالشرطة</span>
                                    <span class="feature-tag">سجل الأحداث</span>
                                    <span class="feature-tag">حماية شاملة</span>
                                </div>

                                <!-- Key Benefits moved to global section -->
                            </div>
                        </div>
                    </div>

                    <!-- Irrigation System -->
                    <div class="system-detail" data-system="irrigation">
                        <div class="package-detail-content">
                            <!-- Left Column - Visuals -->
                            <div class="package-visuals">
                                <div class="surveillance-video">
                                    <div class="video-container">
                                        <video src="./videos/camera-demo.mp4" poster="{{ asset('assets/images/image-2.svg') }}"
                                            controls playsinline></video>
                                    </div>
                                </div>
                                <div class="camera-images">
                                    <div class="camera-image gallery-item" onclick="openModal(this)"
                                        data-src="{{ asset('assets/images/Security Camera Icon.svg') }}" data-title=""
                                        data-description="">
                                        <img src="{{ asset('assets/images/Security Camera Icon.svg') }}" alt="نظام ري">
                                    </div>
                                    <div class="camera-image gallery-item" onclick="openModal(this)"
                                        data-src="{{ asset('assets/images/Security Camera Icon.svg') }}" data-title=""
                                        data-description="">
                                        <img src="{{ asset('assets/images/Security Camera Icon.svg') }}" alt="نظام ري">
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Content -->
                            <div class="package-content">
                                <div class="package-icon">
                                    <img src="{{ asset('assets/images/Security Camera Icon.svg') }}" alt="ري">
                                </div>
                                <div class="package-header">
                                    <h3 class="package-name">نظام ذكي لري الحدائق</h3>
                                    <p class="package-description">ري ذكي يعتمد على الطقس والرطوبة لتوفير المياه</p>
                                </div>

                                <!-- Feature Tags -->
                                <div class="feature-tags">
                                    <span class="feature-tag">ري ذكي</span>
                                    <span class="feature-tag">استشعار الرطوبة</span>
                                    <span class="feature-tag">تحكم عن بعد</span>
                                    <span class="feature-tag">توفير المياه</span>
                                    <span class="feature-tag">جدولة الري</span>
                                    <span class="feature-tag">مراقبة الطقس</span>
                                </div>

                                <!-- Key Benefits moved to global section -->
                            </div>
                        </div>
                    </div>

                    <!-- Voltage Protection System -->
                    <div class="system-detail" data-system="voltage">
                        <div class="package-detail-content">
                            <!-- Left Column - Visuals -->
                            <div class="package-visuals">
                                <div class="surveillance-video">
                                    <div class="video-container">
                                        <video src="./videos/camera-demo.mp4"
                                            poster="{{ asset('assets/images/image-3.svg') }}" controls playsinline></video>
                                    </div>
                                </div>
                                <div class="camera-images">
                                    <div class="camera-image gallery-item" onclick="openModal(this)"
                                        data-src="{{ asset('assets/images/Security Camera Icon.svg') }}" data-title=""
                                        data-description="">
                                        <img src="{{ asset('assets/images/Security Camera Icon.svg') }}" alt="حماية الجهد">
                                    </div>
                                    <div class="camera-image gallery-item" onclick="openModal(this)"
                                        data-src="{{ asset('assets/images/Security Camera Icon.svg') }}" data-title=""
                                        data-description="">
                                        <img src="{{ asset('assets/images/Security Camera Icon.svg') }}" alt="حماية الجهد">
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Content -->
                            <div class="package-content">
                                <div class="package-icon">
                                    <img src="{{ asset('assets/images/Security Camera Icon.svg') }}" alt="حماية">
                                </div>
                                <div class="package-header">
                                    <h3 class="package-name">حماية من ارتفاع وانخفاض الجهد الكهربائي</h3>
                                    <p class="package-description">حماية شاملة للأجهزة الكهربائية من تقلبات الجهد</p>
                                </div>

                                <!-- Feature Tags -->
                                <div class="feature-tags">
                                    <span class="feature-tag">حماية من الارتفاع</span>
                                    <span class="feature-tag">حماية من الانخفاض</span>
                                    <span class="feature-tag">مراقبة مستمرة</span>
                                    <span class="feature-tag">تنبيهات فورية</span>
                                    <span class="feature-tag">حماية الأجهزة</span>
                                    <span class="feature-tag">استقرار الجهد</span>
                                </div>

                                <!-- Key Benefits moved to global section -->
                            </div>
                        </div>
                    </div> --}}
            </div>
        </div>
    </section>

    <!-- Global Key Benefits Section -->
    <section class="key-benefits-section">
        <div class="key-benefits-container">
            <div class="key-benefits-global key-benefits">
                @foreach ($activePackage?->benefits ?? collect() as $benefit)
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="benefit-content">
                            <div class="benefit-number">{{ $benefit->number }}</div>
                            <div class="benefit-label">{{ $benefit->getTranslation('label', app()->getLocale()) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Compatibility Section -->
    <section class="compatibility-section">
        <div class="compatibility-container">
            <div class="compatibility-header">
                <h2 class="compatibility-title">{{ __('packages.compatibility.title') }}</h2>
                <p class="compatibility-description">
                    {{ __('packages.compatibility.description') }}
                </p>
            </div>

            <div class="compatibility-grid">
                <div class="First_row">
                    <!-- Google Home -->
                    <div class="compatibility-item">
                        <div class="compatibility-icon">
                            <img src="{{ asset('assets/images/google.svg') }}" alt="Google Home">
                        </div>
                        <div class="compatibility-name">
                            <div class="compatibility-support">{{ __('packages.compatibility.supports') }}</div>
                            <span class="compatibility-name-text">Google Home</span>
                        </div>
                    </div>

                    <!-- Samsung SmartThings -->
                    <div class="compatibility-item">
                        <div class="compatibility-icon">
                            <img src="{{ asset('assets/images/samsung SmartThings.svg') }}" alt="Samsung SmartThings">
                        </div>
                        <div class="compatibility-name">
                            <div class="compatibility-support">{{ __('packages.compatibility.supports') }}</div>
                            <span class="compatibility-name-text">Samsung SmartThings</span>
                        </div>
                    </div>

                    <!-- Matter -->
                    <div class="compatibility-item">
                        <div class="compatibility-icon">
                            <img src="{{ asset('assets/images/matter.svg') }}" alt="matter">
                        </div>
                        <div class="compatibility-name">
                            <div class="compatibility-support">{{ __('packages.compatibility.supports') }}</div>
                            <span class="compatibility-name-text">Matter</span>
                        </div>
                    </div>
                </div>
                <div class="Second_row">
                    <!-- Apple Home -->
                    <div class="compatibility-item">
                        <div class="compatibility-icon">
                            <img src="{{ asset('assets/images/appleHome.svg') }}" alt="Apple Home">
                        </div>
                        <div class="compatibility-name">
                            <div class="compatibility-support">{{ __('packages.compatibility.supports') }}</div>
                            <span class="compatibility-name-text">Apple Home</span>
                        </div>
                    </div>

                    <!-- Alexa -->
                    <div class="compatibility-item">
                        <div class="compatibility-icon">
                            <img src="{{ asset('assets/images/Amazon Alexa Logo 1.svg') }}" alt="Alexa">
                        </div>
                        <div class="compatibility-name">
                            <div class="compatibility-support">{{ __('packages.compatibility.supports') }}</div>
                            <span class="compatibility-name-text">Alexa</span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="compatibility-cta">
                <div class="cta-content">
                    <div class="cta-text">
                        <h3 class="cta-title">{{ __('packages.cta.ready_title') }}</h3>
                        <p class="cta-description">{{ __('packages.cta.ready_description') }}</p>
                    </div>
                    <button class="consultation-cta-button" onclick="openConsultationModal()">
                        <span>{{ __('packages.cta.book_consultation') }}</span>
                        <img src="{{ asset('assets/images/arrowBlack.svg') }}" alt="" class="btn-icon">
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Testmeniolas -->
    <section class="services-section">
        <div class="breadcrumb">
            <span class="breadcrumb-text">{{ __('packages.testimonials.breadcrumb') }}</span>
            <div class="breadcrumb-dot"></div>
        </div>

        <h1 class="testimonials-main-title">{{ __('packages.testimonials.title') }}</h1>

        <div class="testimonials-slider">
            <div class="testimonials-track">
                @foreach ($testimonials as $index => $testimonial)
                    <div class="testimonial-card {{ $index === 0 ? 'active' : '' }}">
                        <div class="testimonial-content">
                            <div class="testimonial-header">
                                <h3 class="testimonial-client-name">
                                    {{ app()->getLocale() === 'ar' ? $testimonial->name_ar : $testimonial->name_en }}</h3>
                                <p class="testimonial-client-title">
                                    {{ app()->getLocale() === 'ar' ? $testimonial->position_ar : $testimonial->position_en }}
                                </p>
                            </div>
                            <p class="testimonial-text">
                                {{ app()->getLocale() === 'ar' ? $testimonial->content_ar : $testimonial->content_en }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Navigation Arrows -->
            <button class="testimonial-nav-btn testimonial-nav-btn-prev d-none d-md-block"
                onclick="previousTestimonial()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 18l-6-6 6-6" />
                </svg>
            </button>

            <button class="testimonial-nav-btn testimonial-nav-btn-next d-none d-md-block" onclick="nextTestimonial()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 18l6-6-6-6" />
                </svg>
            </button>
        </div>

        <!-- Dots Indicator -->
        <div class="testimonials-dots-indicator">
            @foreach ($testimonials as $index => $testimonial)
                <div class="testimonials-dot {{ $index === 0 ? 'active' : '' }}"
                    onclick="goToTestimonial({{ $index }})"></div>
            @endforeach
        </div>
    </section>

    <!-- Full Width CTA Banner -->
    <section class="cta-banner">
        <!-- Tranc Content within Testimonials -->
        <div class="tranc-content-in-testimonials">
            <div class="tranc-logo-container">
                <img src="{{ asset('assets/images/tranc_logo.svg') }}" alt="Tranc Logo" class="tranc-logo">
            </div>

            <h2 class="tranc-title">{{ __('packages.cta.main_title') }}</h2>

            <div class="tranc-buttons">
                <button class="consultation-cta-button" onclick="openConsultationModal()">
                    <span>{{ __('packages.cta.book_consultation') }}</span>
                    <img src="{{ asset('assets/images/arrowBlack.svg') }}" alt="" class="btn-icon">
                </button>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
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
                        <button class="copy-btn"
                            onclick="copyToClipboard('{{ $contactInfo->mobile ?? '+966853853835' }}')"
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

@section('scripts')
    <script src="{{ asset('assets/js/packages.js') }}"></script>
    <script src="{{ asset('assets/js/forms.js') }}"></script>
@endsection
