@extends('user.layout.layout')

@section('content')
    <section class="hero">

        @include('user.components.header')

        <!-- Floating Elements -->
        <div class="floating-orbs">
            <div class="orb orb-1"></div>
            <div class="orb orb-2"></div>
            <div class="orb orb-3"></div>
        </div>

        <!-- Hero Content -->
        <div class="hero-content">

            @if ($banner)
                <h1>
                    {!! $banner->getTranslation('title', app()->getLocale()) !!}
                </h1>

                <p>
                    {{ $banner->getTranslation('description', app()->getLocale()) }}
                </p>
            @endif

            <div class="cta-buttons">
                <button class="btn btn-primary" onclick="openConsultationModal()">
                    <img src="{{ asset('assets/images/arrow.svg') }}" alt="" class="btn-icon">
                    <span>{{ __('home.hero.book_consultation') }}</span>
                </button>

                <button class="btn btn-secondary" onclick="window.location.href='{{ route('userpackages') }}'">
                    {{ __('home.hero.explore_packages') }}
                </button>
            </div>

            <!-- Partners Section -->
            <section class="partners py-4">
                <div class="container-fluid">
                    <div class="partners-slider">
                        <div class="title-with-lines">{{ __('home.partners.title') }}</div>
                        <div class="slider-track" id="partnersTrack">
                            @foreach ($partners as $partner)
                                <div class="slide">
                                    <img src="{{ $partner->image }}" alt="{{ $partner->name }}" class="partner-logo">
                                </div>
                            @endforeach

                            <!-- Duplicate for seamless scrolling -->
                            @foreach ($partners as $partner)
                                <div class="slide">
                                    <img src="{{ $partner->image }}" alt="{{ $partner->name }}" class="partner-logo">
                                </div>
                            @endforeach

                            <!-- Third set for seamless scrolling -->
                            @foreach ($partners as $partner)
                                <div class="slide">
                                    <img src="{{ $partner->image }}" alt="{{ $partner->name }}" class="partner-logo">
                                </div>
                            @endforeach
                        </div>

                        <!-- slider controls removed to restore auto-scrolling on all sizes -->
                    </div>
                </div>
            </section>
        </div>




        </div>

    </section>

    <div class="journey-section" id="about">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <span class="breadcrumb-text">{{ __('home.about.breadcrumb') }}</span>
            <div class="breadcrumb-dot"></div>
        </div>

        <!-- Main Title -->
        <h1 class="main-title">
            {!! __('home.about.title') !!}
        </h1>

        <!-- Description -->
        <p class="description">
            {!! __('home.about.description') !!}
        </p>

        <!-- Cards Grid -->
        <style>
            /* Flex-based cards grid for the "نبذة عن سمارت أب" section */
            .cards-grid {
                display: flex;
                flex-wrap: wrap;
                gap: 24px;
                align-items: stretch;
                justify-content: space-between;
            }

            .cards-grid .card {
                flex: 1 1 calc(50% - 12px);
                /* two cards per row on >=768px */
                box-sizing: border-box;
                min-width: 200px;
            }

            @media (max-width: 767.98px) {
                .cards-grid .card {
                    flex: 1 1 100%;
                }
            }

            /* Order mapping so the second wrapped row appears reversed relative to the first */
            .card-1 {
                order: 1;
            }

            .card-2 {
                order: 2;
            }

            .card-3 {
                order: 4;
            }

            .card-4 {
                order: 3;
            }
        </style>

        <div class="cards-grid">
            @foreach ($cards as $index => $card)
                <div class="card card-{{ $index + 1 }}">
                    <div class="card-icon-container">
                        <div class="star star-1">✦</div>
                        <div class="star star-2">✦</div>
                        <div class="star star-3">✦</div>
                        <div class="card-icon-outer">
                            <div class="card-icon">
                                <img src="{{ asset('assets/images/elements.svg') }}" alt="icon" class="icon-image">
                            </div>
                        </div>
                    </div>
                    <div class="title-inner">
                        <h3 class="card-title">{{ $card->getTranslation('title', app()->getLocale()) }}</h3>
                        <p class="card-text">
                            {{ $card->getTranslation('description', app()->getLocale()) }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Services -->

    <section class="services-section" id="services">
        <img src="{{ asset('assets/images/home-Background.png') }}" alt="background" class="section-bg-image">
        <div class="services-content">
            <!-- Main Title and Description -->
            <h2 class="services-title">{{ __('home.services.title') }}</h2>
            <p class="services-description">{{ __('home.services.subtitle') }}</p>

            <!-- Services Grid -->
            <div class="services-grid">
                @foreach ($mainSystems as $system)
                    <div class="service-box">
                        <div class="service-front">
                            <div class="service-icon">
                                <img src="{{ $system->image }}"
                                    alt="{{ $system->getTranslation('name', app()->getLocale()) }}" class="icon-image">
                            </div>
                            <h3 class="service-title">{{ $system->getTranslation('name', app()->getLocale()) }}</h3>
                        </div>
                        <div class="service-back">
                            <h3 class="service-back-title">{{ $system->getTranslation('name', app()->getLocale()) }}</h3>
                            <p class="service-back-description">
                                {{ $system->getTranslation('description', app()->getLocale()) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- More Section -->
            <div class="more-section">
                <h3 class="more-title">{{ __('home.services.more_title') }}</h3>
                <div class="more-box">
                    <h4 class="more-subtitle">{{ __('home.services.support_title') }}</h4>
                    <p class="more-description">
                        {{ __('home.services.support_description') }}
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- gallery -->
    <section class="gallery-section">
        <div class="gallery-container">
            <h2 class="gallery-title">{{ __('home.gallery.title') }}</h2>

            <div class="gallery-grid">
                @php
                    $mainItems = $galleryImages->take(3);
                @endphp
                @foreach ($mainItems as $index => $item)
                    <div class="gallery-item gallery-item-{{ $index + 1 }}" onclick="openModal(this)"
                        data-src="{{ $item->image }}"
                        data-title="{{ $item->getTranslation('title', app()->getLocale()) }}"
                        data-description="{{ $item->getTranslation('description', app()->getLocale()) }}">
                        <img src="{{ $item->image }}" alt="{{ $item->getTranslation('title', app()->getLocale()) }}">
                        <div class="gallery-overlay">
                            <div class="overlay-title">{{ $item->getTranslation('title', app()->getLocale()) }}</div>
                            <div class="overlay-subtitle">{{ __('home.gallery.year') }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Bottom Row -->
            <div class="gallery-bottom">
                @php
                    $bottomItems = $galleryImages->skip(3)->take(3);
                @endphp
                @foreach ($bottomItems as $item)
                    <div class="gallery-item" onclick="openModal(this)" data-src="{{ $item->image }}"
                        data-title="{{ $item->getTranslation('title', app()->getLocale()) }}"
                        data-description="{{ $item->getTranslation('description', app()->getLocale()) }}">
                        <img src="{{ $item->image }}" alt="{{ $item->getTranslation('title', app()->getLocale()) }}">
                        <div class="gallery-overlay">
                            <div class="overlay-title">{{ $item->getTranslation('title', app()->getLocale()) }}</div>
                            <div class="overlay-subtitle">{{ __('home.gallery.year') }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div id="imageModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <img class="modal-image" id="modalImage" src="" alt="">
            <div class="modal-info">
                <h3 class="modal-title" id="modalTitle">عنوان الصورة</h3>
                <p class="modal-description" id="modalDescription">وصف تفصيلي للصورة وما تحتويه من أنظمة ذكية وحلول
                    تقنية متطورة.</p>
            </div>
        </div>
    </div>

    <section class="pricing-section">
        <div class="pricing-container">
            <h2 class="pricing-title">{{ __('home.pricing.title') }}</h2>
            <p class="pricing-subtitle">{{ __('home.pricing.subtitle') }}</p>

            <!-- الثلاث باقات الأساسية -->
            <div class="pricing-grid">
                @foreach ($packages ?? collect() as $idx => $pkg)
                    <div class="pricing-card {{ $idx === 1 ? 'featured' : '' }}">
                        <div class="plan-header">
                            <div class="plan-header-inner">
                                <h3 class="plan-name">{{ $pkg->getTranslation('title', app()->getLocale()) }}</h3>
                                <div class="plan-badge">{{ __('home.packages.support_badge') }}</div>
                            </div>
                            <p class="plan-description">{{ $pkg->getTranslation('desc', app()->getLocale()) }}</p>
                        </div>
                        <h4 class="features-title">{{ __('home.packages.features_title') }}</h4>
                        <ul class="features-list">
                            @foreach (($pkg->features ?? collect())->take(8) as $f)
                                <li>{{ $f->getTranslation('title', app()->getLocale()) }}</li>
                            @endforeach
                        </ul>
                        <a class="cta-button" href="{{ route('userpackages') }}">
                            <img src="{{ asset('assets/images/next.svg') }}" alt="" class="button-icon">
                            {{ __('home.packages.see_details') }}
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Custom Package - منفصلة في رو لوحدها -->
            <div class="custom-package">
                <div class="custom-content">

                    <div class="custom-header">
                        <h3 class="custom-title">{{ __('home.packages.custom_title') }}</h3>
                        <p class="custom-description">
                            {{ __('home.packages.custom_description') }}
                        </p>
                    </div>
                    <div>
                        <h4 class="features-title">{{ __('home.packages.features_title') }}</h4>
                        <div class="custom-features">
                            @foreach (__('home.packages.custom_features') as $feature)
                                <div class="feature-item">{{ $feature }}</div>
                            @endforeach
                        </div>
                        <div class="custom-cta">
                            <button class="cta-button">
                                <img src="{{ asset('assets/images/next.svg') }}" alt="" class="button-icon">
                                {{ __('home.packages.see_details') }}
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Testmeniolas -->
    <section class="services-section" id="testimonials">
        <img src="{{ asset('assets/images/homefinal.svg') }}" alt="background" class="section-bg-image">

        <div class="breadcrumb">
            <span class="breadcrumb-text">{{ __('home.testimonials.breadcrumb') }}</span>
            <div class="breadcrumb-dot"></div>
        </div>

        <h1 class="testimonials-main-title">{{ __('home.testimonials.title') }}</h1>

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
            <button class="testimonial-nav-btn testimonial-nav-btn-prev d-none d-md-none" onclick="previousTestimonial()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 18l-6-6 6-6" />
                </svg>
            </button>

            <button class="testimonial-nav-btn testimonial-nav-btn-next d-block d-md-none" onclick="nextTestimonial()">
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

        <!-- Tranc Content within Testimonials -->
        <div class="tranc-content-in-testimonials">
            <div class="tranc-logo-container">
                <img src="{{ asset('assets/images/tranc_logo.svg') }}" alt="Tranc Logo" class="tranc-logo">
            </div>

            <h2 class="tranc-title">{{ __('home.testimonials.cta_title') }}</h2>

            <div class="tranc-buttons">
                <button class="btn btn-primary btn-small" onclick="openConsultationModal()">
                    <img src="{{ asset('assets/images/arrow.svg') }}" alt="" class="btn-icon">
                    <span>{{ __('home.testimonials.book_consultation') }}</span>
                </button>

                <button class="btn btn-secondary btn-small" onclick="window.location.href='{{ route('userpackages') }}'">
                    {{ __('home.testimonials.explore_packages') }}
                </button>
            </div>
        </div>
    </section>

    <!-- Contact Us -->
    <section class="contact-section" id="contact">
        <div class="contact-container">
            <!-- Title Section -->
            <div class="contact-header">
                <h2 class="contact-main-title">{{ __('home.contact.title') }}</h2>
            </div>

            <div class="contact-content">
                <!-- Contact Info Section -->
                <div class="contact-info-section">
                    <h3>{{ __('home.contact.info_title') }}</h3>

                    <div class="contact-info-item">
                        <div class="contact-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                            </svg>
                        </div>
                        <div class="contact-details">
                            <span class="contact-label">{{ __('home.contact.phone_label') }}</span>
                            <span class="contact-value">{{ $contactInfo->mobile ?? '+966853853835' }}</span>
                        </div>
                        <button class="copy-btn"
                            onclick="copyToClipboard('{{ $contactInfo->mobile ?? '+966853853835' }}')"
                            title="{{ __('home.contact.copy_phone') }}">
                            <img src="{{ asset('assets/images/copyicon.svg') }}"
                                alt="{{ __('home.contact.copy_phone') }}">
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
                            <span class="contact-label">{{ __('home.contact.email_label') }}</span>
                            <span class="contact-value">{{ $contactInfo->email ?? 'info@smartup.com' }}</span>
                        </div>
                        <button class="copy-btn"
                            onclick="copyToClipboard('{{ $contactInfo->email ?? 'info@smartup.com' }}')"
                            title="{{ __('home.contact.copy_email') }}">
                            <img src="{{ asset('assets/images/copyicon.svg') }}"
                                alt="{{ __('home.contact.copy_email') }}">
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
                            <span class="contact-label">{{ __('home.contact.location_label') }}</span>
                            <span class="contact-value">{!! $contactInfo->address ?? 'الرياض<br>مركبة، طريق الملك فهد' !!}</span>
                        </div>
                        <button class="link-btn"
                            onclick="window.open('https://maps.google.com/?q={{ urlencode($contactInfo->address ?? 'الرياض مركبة طريق الملك فهد') }}', '_blank')"
                            title="{{ __('home.contact.open_location') }}">
                            <img src="{{ asset('assets/images/link-icon.svg') }}"
                                alt="{{ __('home.contact.open_location') }}">
                        </button>
                    </div>

                    <div class="contact-social">
                        <span class="social-label">{{ __('home.contact.social_label') }}</span>
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
<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff" transform="rotate(0)matrix(1, 0, 0, 1, 0, 0)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 18C15.3137 18 18 15.3137 18 12C18 8.68629 15.3137 6 12 6C8.68629 6 6 8.68629 6 12C6 15.3137 8.68629 18 12 18ZM12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16Z" fill="#0F0F0F"></path> <path d="M18 5C17.4477 5 17 5.44772 17 6C17 6.55228 17.4477 7 18 7C18.5523 7 19 6.55228 19 6C19 5.44772 18.5523 5 18 5Z" fill="#0F0F0F"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M1.65396 4.27606C1 5.55953 1 7.23969 1 10.6V13.4C1 16.7603 1 18.4405 1.65396 19.7239C2.2292 20.8529 3.14708 21.7708 4.27606 22.346C5.55953 23 7.23969 23 10.6 23H13.4C16.7603 23 18.4405 23 19.7239 22.346C20.8529 21.7708 21.7708 20.8529 22.346 19.7239C23 18.4405 23 16.7603 23 13.4V10.6C23 7.23969 23 5.55953 22.346 4.27606C21.7708 3.14708 20.8529 2.2292 19.7239 1.65396C18.4405 1 16.7603 1 13.4 1H10.6C7.23969 1 5.55953 1 4.27606 1.65396C3.14708 2.2292 2.2292 3.14708 1.65396 4.27606ZM13.4 3H10.6C8.88684 3 7.72225 3.00156 6.82208 3.0751C5.94524 3.14674 5.49684 3.27659 5.18404 3.43597C4.43139 3.81947 3.81947 4.43139 3.43597 5.18404C3.27659 5.49684 3.14674 5.94524 3.0751 6.82208C3.00156 7.72225 3 8.88684 3 10.6V13.4C3 15.1132 3.00156 16.2777 3.0751 17.1779C3.14674 18.0548 3.27659 18.5032 3.43597 18.816C3.81947 19.5686 4.43139 20.1805 5.18404 20.564C5.49684 20.7234 5.94524 20.8533 6.82208 20.9249C7.72225 20.9984 8.88684 21 10.6 21H13.4C15.1132 21 16.2777 20.9984 17.1779 20.9249C18.0548 20.8533 18.5032 20.7234 18.816 20.564C19.5686 20.1805 20.1805 19.5686 20.564 18.816C20.7234 18.5032 20.8533 18.0548 20.9249 17.1779C20.9984 16.2777 21 15.1132 21 13.4V10.6C21 8.88684 20.9984 7.72225 20.9249 6.82208C20.8533 5.94524 20.7234 5.49684 20.564 5.18404C20.1805 4.43139 19.5686 3.81947 18.816 3.43597C18.5032 3.27659 18.0548 3.14674 17.1779 3.0751C16.2777 3.00156 15.1132 3 13.4 3Z" fill="#0F0F0F"></path> </g></svg>                            </a>
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
                                <label for="phone">{{ __('home.contact.form.phone') }}</label>
                                <div class="phone-input-group">
                                    <span class="country-flag">🇸🇦</span>
                                    <input type="tel" id="phone" name="phone"
                                        placeholder="{{ __('home.contact.form.phone_placeholder') }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">{{ __('home.contact.form.name') }}</label>
                                <input type="text" id="name" name="name"
                                    placeholder="{{ __('home.contact.form.name_placeholder') }}" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="subject">{{ __('home.contact.form.subject') }}</label>
                                <input type="text" id="subject" name="subject"
                                    placeholder="{{ __('home.contact.form.subject_placeholder') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('home.contact.form.email') }}</label>
                                <input type="email" id="email" name="email"
                                    placeholder="{{ __('home.contact.form.email_placeholder') }}" required>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label for="message">{{ __('home.contact.form.message') }}</label>
                            <textarea id="message" name="message" rows="2" placeholder="{{ __('home.contact.form.message_placeholder') }}" required></textarea>
                        </div>

                        <button type="submit" class="contact-submit-btn">
                            <span>{{ __('home.contact.form.submit') }}</span>
                            <img src="{{ asset('assets/images/send.svg') }}"
                                alt="{{ __('home.contact.form.submit') }}">
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/forms.js') }}"></script>
@endsection
