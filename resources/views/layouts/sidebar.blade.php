 <!-- BEGIN: Main Menu-->
 <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ asset('/')}}"><span class="brand-logo">
                      </span>
                    <h2 class="brand-text">لوحة التحكم</h2>
                </a></li>
            {{-- <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li> --}}
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">


            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('dashboard.banners') }}"><i data-feather="flag"></i><div class="menu-title text-truncate" data-i18n="Banners">البانر</div></a></li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('dashboard.partners') }}"><i data-feather="users"></i><div class="menu-title text-truncate" data-i18n="Partners">الشركاء</div></a></li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('dashboard.cards') }}"><i data-feather="credit-card"></i><div class="menu-title text-truncate" data-i18n="Cards">نبذة عن سمارت اب</div></a></li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('dashboard.main_systems') }}"><i data-feather="monitor"></i><div class="menu-title text-truncate" data-i18n="main_systems"> أنظمة الواجهة الرئيسية</div></a></li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('dashboard.packages') }}"><i data-feather="box"></i><div class="menu-title text-truncate" data-i18n="Packages">الباقات</div></a></li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('dashboard.systems') }}"><i data-feather="cpu"></i><div class="menu-title text-truncate" data-i18n="Systems">أنظمة الباقات</div></a></li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('dashboard.primaryImages') }}"><i data-feather="image"></i><div class="menu-title text-truncate" data-i18n="Gallery">معرض الصور</div></a></li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('dashboard.testimonials') }}"><i data-feather="message-square"></i><div class="menu-title text-truncate" data-i18n="Testimonials">شهادات العملاء</div></a></li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('dashboard.supports') }}"><i data-feather="globe"></i><div class="menu-title text-truncate" data-i18n="Supports">الخدمات المدعومة</div></a></li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('dashboard.branches') }}"><i data-feather="map-pin"></i><div class="menu-title text-truncate" data-i18n="Branches">فروعنا</div></a></li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('dashboard.clients') }}"><i data-feather="users"></i><div class="menu-title text-truncate" data-i18n="Clients">استفسارات الزبائن</div></a></li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('dashboard.contact_infos') }}"><i data-feather="phone"></i><div class="menu-title text-truncate" data-i18n="Contact_Info">معلومات التواصل </div></a></li>

            {{-- @can('الصلاحيات')
                 <li class=" nav-item {{ Route::is('dashboard.roles.index')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('dashboard.roles.index') }}"><i class="fa-solid fa-periscope"></i><span class="menu-title "> الصلاحيات</span></a></li>
            @endcan

            @can('فريق النظام')
                <li class=" nav-item {{ Route::is('dashboard.admins')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('dashboard.admins') }}"><i class="fa-solid fa-person"></i><span class="menu-title ">فريق النظام</span></a></li>
            @endcan --}}

            {{-- <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i><span class="menu-title text-truncate" data-i18n="Invoice">صفحات</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="app-invoice-list.html"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">صفحة 1</span></a></li>

                    <li><a class="d-flex align-items-center" href="app-invoice-preview.html"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Preview">صفحة 2</span></a></li>

                    <li><a class="d-flex align-items-center" href="app-invoice-edit.html"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Edit">صفحة 3</span></a> </li>
                    </li>
                </ul>
            </li> --}}

        </ul>
    </div>
</div>
<!-- END: Main Menu-->
