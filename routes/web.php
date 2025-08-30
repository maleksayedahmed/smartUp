<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\User\PackagesPageController;
use App\Http\Controllers\User\HomeController as UserHomeController;
use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\Dashboard\CardController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\BannerController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\SystemController;
use App\Http\Controllers\Dashboard\PackageController;
use App\Http\Controllers\Dashboard\PartnerController;
use App\Http\Controllers\Dashboard\BranchesController;
use App\Http\Controllers\Dashboard\ContactInfoController;
use App\Http\Controllers\Dashboard\SupportController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\PackageSpecController;
use App\Http\Controllers\Dashboard\TestimonialsController;
use App\Http\Controllers\Dashboard\GalleryImagesController;
use App\Http\Controllers\Dashboard\MainSystemsController;
use App\Http\Controllers\Dashboard\PrimaryImagesController;
use App\Http\Controllers\Dashboard\SystemFeaturesController;
use App\Http\Controllers\Dashboard\PackageFeaturesController;
use App\Http\Controllers\Dashboard\SystemAttachmentsController;

Route::get('/dcsc', function() {
    $exitCode = Artisan::call('optimize:clear');
    return 'what you want';
});

Route::get('/', [UserHomeController::class, 'index'])->name('home');
Route::get('/contact-us', [UserHomeController::class, 'contactUs'])->name('contact-us');
Route::get('/userpackages', [PackagesPageController::class, 'index'])->name('userpackages');

// Language switching route
Route::get('/switch-language/{language}', [UserHomeController::class, 'switchLanguage'])->name('switch.language');

// Contact form and consultation routes
Route::post('/contact/submit', [ContactController::class, 'submitForm'])->name('contact.submit');
Route::post('/consultation/book', [ContactController::class, 'bookConsultation'])->name('consultation.book');
Route::post('/consultation/store', [\App\Http\Controllers\User\ConsultationController::class, 'store'])->name('consultation.store');

Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
})->middleware(['auth']);

Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
})->middleware(['auth']);



Route::group(['middleware'=>['auth'],'as'=>'dashboard.'], function(){




    // banners
    Route::get('/banners',                [BannerController::class, 'banners'])->name('banners');
    Route::get('/get_all_banners',        [BannerController::class, 'get_all_banners'])->name('get_all_banners');
    Route::post('/store_banners',         [BannerController::class, 'store_banners'])->name('store_banners');
    Route::post('/update_banners',        [BannerController::class, 'update_banners'])->name('update_banners');
    Route::post('/destroy_banners',       [BannerController::class, 'destroy_banners'])->name('destroy_banners');


    // cards
    Route::get('/cards',                [CardController::class, 'cards'])->name('cards');
    Route::get('/get_all_cards',        [CardController::class, 'get_all_cards'])->name('get_all_cards');
    Route::get('/preview_cards/{id}',   [CardController::class, 'preview_cards'])->name('preview_cards');
    Route::post('/store_cards',         [CardController::class, 'store_cards'])->name('store_cards');
    Route::put('/preview-cards/{id}', [CardController::class, 'update'])->name('preview-cards.update');
    Route::post('/destroy_cards',       [CardController::class, 'destroy_cards'])->name('destroy_cards');

    //primaryImages
    Route::get('/primaryImages',                [PrimaryImagesController::class, 'primaryImages'])->name('primaryImages');
    Route::get('/get_all_primaryImages',        [PrimaryImagesController::class, 'get_all_primaryImages'])->name('get_all_primaryImages');
    Route::post('/store_primaryImages',         [PrimaryImagesController::class, 'store_primaryImages'])->name('store_primaryImages');
    Route::post('/update_primaryImages',        [PrimaryImagesController::class, 'update_primaryImages'])->name('update_primaryImages');
    Route::post('/destroy_primaryImages',       [PrimaryImagesController::class, 'destroy_primaryImages'])->name('destroy_primaryImages');
    Route::post('/is_main',                     [PrimaryImagesController::class, 'is_main'])->name('is_main');



    //supports
    Route::get('/supports',                [SupportController::class, 'supports'])->name('supports');
    Route::get('/get_all_supports',        [SupportController::class, 'get_all_supports'])->name('get_all_supports');
    Route::post('/store_supports',         [SupportController::class, 'store_supports'])->name('store_supports');
    Route::post('/update_supports',        [SupportController::class, 'update_supports'])->name('update_supports');
    Route::post('/destroy_supports',       [SupportController::class, 'destroy_supports'])->name('destroy_supports');


    //main_systems
    Route::get('/main_systems',                [MainSystemsController::class, 'main_systems'])->name('main_systems');
    Route::get('/get_all_main_systems',        [MainSystemsController::class, 'get_all_main_systems'])->name('get_all_main_systems');
    Route::post('/store_main_systems',         [MainSystemsController::class, 'store_main_systems'])->name('store_main_systems');
    Route::post('/update_main_systems',        [MainSystemsController::class, 'update_main_systems'])->name('update_main_systems');
    Route::post('/destroy_main_systems',       [MainSystemsController::class, 'destroy_main_systems'])->name('destroy_main_systems');


    //contact_infos
    Route::get('/contact_infos',                [ContactInfoController::class, 'contact_infos'])->name('contact_infos');
    Route::get('/get_all_contact_infos',        [ContactInfoController::class, 'get_all_contact_infos'])->name('get_all_contact_infos');
    Route::post('/store_contact_infos',         [ContactInfoController::class, 'store_contact_infos'])->name('store_contact_infos');
    Route::post('/update_contact_infos',        [ContactInfoController::class, 'update_contact_infos'])->name('update_contact_infos');
    Route::post('/destroy_contact_infos',       [ContactInfoController::class, 'destroy_contact_infos'])->name('destroy_contact_infos');


    //galleryImages
    Route::get('/galleryImages/{id}',                [galleryImagesController::class, 'galleryImages'])->name('galleryImages');
    Route::get('/get_all_galleryImages/{id}',        [galleryImagesController::class, 'get_all_galleryImages'])->name('get_all_galleryImages');
    Route::post('/store_galleryImages',         [galleryImagesController::class, 'store_galleryImages'])->name('store_galleryImages');
    Route::post('/update_galleryImages',        [galleryImagesController::class, 'update_galleryImages'])->name('update_galleryImages');
    Route::post('/destroy_galleryImages',       [galleryImagesController::class, 'destroy_galleryImages'])->name('destroy_galleryImages');


    // testimonials
    Route::get('/testimonials',                [TestimonialsController::class, 'testimonials'])->name('testimonials');
    Route::get('/get_all_testimonials',        [TestimonialsController::class, 'get_all_testimonials'])->name('get_all_testimonials');
    Route::post('/store_testimonials',         [TestimonialsController::class, 'store_testimonials'])->name('store_testimonials');
    Route::post('/update_testimonials',        [TestimonialsController::class, 'update_testimonials'])->name('update_testimonials');
    Route::post('/destroy_testimonials',       [TestimonialsController::class, 'destroy_testimonials'])->name('destroy_testimonials');


    // systems
    Route::get('/systems/{id?}',           [SystemController::class, 'systems'])->name('systems');
    Route::get('/get_all_systems/{id?}',   [SystemController::class, 'get_all_systems'])->name('get_all_systems');
    Route::get('/get_all_systems2/{id?}',   [SystemController::class, 'get_all_systems2'])->name('get_all_systems2');
    Route::post('/store_systems',         [SystemController::class, 'store_systems'])->name('store_systems');
    Route::post('/update_systems',        [SystemController::class, 'update_systems'])->name('update_systems');
    Route::post('/destroy_systems',       [SystemController::class, 'destroy_systems'])->name('destroy_systems');


    // clients
    Route::get('/clients',                [ClientController::class, 'clients'])->name('clients');
    Route::get('/get_all_clients',        [ClientController::class, 'get_all_clients'])->name('get_all_clients');
    Route::get('/preview_clients/{id}',        [ClientController::class, 'preview_clients'])->name('preview_clients');
    Route::post('/store_clients',         [ClientController::class, 'store_clients'])->name('store_clients');
    Route::post('/update_clients',        [ClientController::class, 'update_clients'])->name('update_clients');
    Route::post('/destroy_clients',       [ClientController::class, 'destroy_clients'])->name('destroy_clients');


    // packages
    Route::get('/packages',                [PackageController::class, 'packages'])->name('packages');
    Route::get('/packages/create',         [PackageController::class, 'create'])->name('packages.create');
    Route::post('/packages',               [PackageController::class, 'storeFull'])->name('packages.storeFull');
    Route::get('/packages/{id}/edit',      [PackageController::class, 'edit'])->name('packages.edit');
    Route::put('/packages/{id}',           [PackageController::class, 'updateFull'])->name('packages.updateFull');
    Route::get('/preview_packages/{id}',                [PackageController::class, 'preview_packages'])->name('preview_packages');
    Route::get('/get_all_packages',        [PackageController::class, 'get_all_packages'])->name('get_all_packages');
    Route::post('/store_packages',         [PackageController::class, 'store_packages'])->name('store_packages');
    Route::post('/update_packages',        [PackageController::class, 'update_packages'])->name('update_packages');
    Route::post('/destroy_packages',       [PackageController::class, 'destroy_packages'])->name('destroy_packages');
    Route::post('/destroy_systems_for_package',       [PackageController::class, 'destroy_systems_for_package'])->name('destroy_systems_for_package');


    // package_spec
    Route::get('/package_spec/{id}',                [PackageSpecController::class, 'package_spec'])->name('package_spec');
    Route::get('/get_all_package_spec/{id}',        [PackageSpecController::class, 'get_all_package_spec'])->name('get_all_package_spec');
    Route::post('/store_package_spec',         [PackageSpecController::class, 'store_package_spec'])->name('store_package_spec');
    Route::post('/update_package_spec',        [PackageSpecController::class, 'update_package_spec'])->name('update_package_spec');
    Route::post('/destroy_package_spec',       [PackageSpecController::class, 'destroy_package_spec'])->name('destroy_package_spec');


    // packages_features
    Route::get('/packages_features/{id}',                [PackageFeaturesController::class, 'packages_features'])->name('packages_features');
    Route::get('/get_all_packages_features/{id}',        [PackageFeaturesController::class, 'get_all_packages_features'])->name('get_all_packages_features');
    Route::post('/store_packages_features',         [PackageFeaturesController::class, 'store_packages_features'])->name('store_packages_features');
    Route::post('/update_packages_features',        [PackageFeaturesController::class, 'update_packages_features'])->name('update_packages_features');
    Route::post('/destroy_packages_features',       [PackageFeaturesController::class, 'destroy_packages_features'])->name('destroy_packages_features');


    // systems_features
    Route::get('/systems_features/{id}',                [SystemFeaturesController::class, 'systems_features'])->name('systems_features');
    Route::get('/get_all_systems_features/{id}',        [SystemFeaturesController::class, 'get_all_systems_features'])->name('get_all_systems_features');
    Route::post('/store_systems_features',         [SystemFeaturesController::class, 'store_systems_features'])->name('store_systems_features');
    Route::post('/update_systems_features',        [SystemFeaturesController::class, 'update_systems_features'])->name('update_systems_features');
    Route::post('/destroy_systems_features',       [SystemFeaturesController::class, 'destroy_systems_features'])->name('destroy_systems_features');


    // system_attachments
    Route::get('/systems_attachments/{id}',                [SystemAttachmentsController::class, 'systems_attachments'])->name('systems_attachments');
    Route::get('/get_all_systems_attachments/{id}',        [SystemAttachmentsController::class, 'get_all_systems_attachments'])->name('get_all_systems_attachments');
    Route::post('/store_systems_attachments',         [SystemAttachmentsController::class, 'store_systems_attachments'])->name('store_systems_attachments');
    Route::post('/update_systems_attachments',        [SystemAttachmentsController::class, 'update_systems_attachments'])->name('update_systems_attachments');
    Route::post('/destroy_systems_attachments',       [SystemAttachmentsController::class, 'destroy_systems_attachments'])->name('destroy_systems_attachments');


    // partners
    Route::get('/partners',                [PartnerController::class, 'partners'])->name('partners');
    Route::get('/get_all_partners',        [PartnerController::class, 'get_all_partners'])->name('get_all_partners');
    Route::post('/store_partners',         [PartnerController::class, 'store_partners'])->name('store_partners');
    Route::post('/update_partners',        [PartnerController::class, 'update_partners'])->name('update_partners');
    Route::post('/destroy_partners',       [PartnerController::class, 'destroy_partners'])->name('destroy_partners');


    // branches
    Route::get('/branches',                [BranchesController::class, 'branches'])->name('branches');
    Route::get('/get_all_branches',        [BranchesController::class, 'get_all_branches'])->name('get_all_branches');
    Route::post('/store_branches',         [BranchesController::class, 'store_branches'])->name('store_branches');
    Route::post('/update_branches',        [BranchesController::class, 'update_branches'])->name('update_branches');
    Route::post('/destroy_branches',       [BranchesController::class, 'destroy_branches'])->name('destroy_branches');


    //admins
    Route::get('/admins',               [AdminController::class, 'admins'])->name('admins')->middleware(['permission:فريق النظام']);
    Route::get('/get_all_admins',       [AdminController::class, 'get_all_admins'])->name('get_all_admins')->middleware(['permission:فريق النظام']);
    Route::post('/store_admins',        [AdminController::class, 'store_admins'])->name('store_admins')->middleware(['permission:فريق النظام']);
    Route::post('/update_admins',       [AdminController::class, 'update_admins'])->name('update_admins')->middleware(['permission:فريق النظام']);
    Route::post('/destroy_admins',      [AdminController::class, 'destroy_admins'])->name('destroy_admins')->middleware(['permission:فريق النظام']);


    Route::resource('roles',        RoleController::class)->middleware(['permission:الصلاحيات']);
    Route::post('/update_rolee',    [RoleController::class,       'update_rolee'])->name('update_rolee')->middleware(['permission:الصلاحيات']);
    Route::get('/get_all_role',     [PermissionController::class, 'get_all_role'])->name('get_all_role')->middleware(['permission:الصلاحيات']);

    Route::get('/myprofile',             [AdminController::class,'myprofile'])->name('myprofile');
    Route::post('/myprofile_update',     [AdminController::class,'myprofile_update'])->name('myprofile_update');

});



// });

require __DIR__.'/auth.php';
