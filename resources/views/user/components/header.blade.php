 <!-- Top Navigation Area -->
 <div class="top-nav-area">
     <!-- Consultation Button - Outside Header -->
     <div class="consultation-button-container">
         <button class="btn btn-primary" onclick="openConsultationModal()">
             <img src="{{ asset('assets/images/arrow.svg') }}" alt="" class="btn-icon">
             <span>{{ __('components.header.book_consultation') }}</span>
         </button>
         <div class="language-separator d-none d-md-block">|</div>
         <a href="{{ route('switch.language', app()->getLocale() == 'ar' ? 'en' : 'ar') }}"
             class="language-text d-none d-md-block">{{ __('components.header.language_toggle') }}</a>
     </div>

     <!-- Main Header Frame -->
     <nav class="navbar" id="navbar">
         <div class="nav-center">
             <ul class="nav-links" id="navLinks">
                 <li><a href="{{ route('home') }}"
                         class="{{ request()->routeIs('home') ? 'active' : '' }}">{{ __('components.header.menu.home') }}</a>
                 </li>
                 <li><a href="{{ route('userpackages') }}"
                         class="{{ request()->routeIs('userpackages') ? 'active' : '' }}">{{ __('components.header.menu.packages') }}</a>
                 </li>
                 <li><a href="{{ route('contact-us') }}"
                         class="{{ request()->routeIs('contact-us') ? 'active' : '' }}">{{ __('components.header.menu.contact') }}</a>
                 </li>
                 <a href="{{ route('switch.language', app()->getLocale() == 'ar' ? 'en' : 'ar') }}"
                     class="language-text d-block d-md-none">{{ __('components.header.language_toggle') }}</a>
             </ul>

         </div>

         <div class="nav-right">

             <div class="logo" onclick="window.location.href='{{ route('home') }}'">
                 <!-- Desktop & Tablet Logo -->
                 <img src="{{ asset('assets/images/Logo.svg') }}" alt="SMARTUP" class="logo-image d-none d-md-block">

                 <!-- Mobile Logo -->
                 <img src="{{ asset('assets/images/logo-2.svg') }}" alt="SMARTUP" class="logo-image d-block d-md-none"
                     aria-hidden="true">


             </div>

         </div>

         <div class="menu-toggle" id="menuToggle">
             <span></span>
             <span></span>
             <span></span>
         </div>
     </nav>
 </div>
