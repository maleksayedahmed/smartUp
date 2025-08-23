<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Partner;
use App\Models\Testimony;
use App\Models\Banner;
use App\Models\Card;
use App\Models\MainSystem;
use App\Models\PrimaryImage;
use App\Models\ContactInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        $banner = Banner::first();
        $cards = Card::orderBy('id')->get();
        $mainSystems = MainSystem::orderBy('id')->get();
        $galleryImages = PrimaryImage::orderBy('id')->get();
        $packages = Package::with('features')->orderBy('id')->take(3)->get();
        $partners = Partner::orderBy('id')->take(10)->get();
        $testimonials = Testimony::orderBy('id')->take(3)->get();
        $contactInfo = ContactInfo::first();
        
        return view('user.home', compact(
            'banner', 'cards', 'mainSystems', 'galleryImages', 
            'packages', 'partners', 'testimonials', 'contactInfo'
        ));
    }

    public function contactUs()
    {
        $contactInfo = ContactInfo::first();
        $body = 'contact-page' ;
        return view('user.contact-us', compact('contactInfo', 'body'));
    }

    public function switchLanguage($language)
    {
        // Validate language
        if (in_array($language, ['ar', 'en'])) {
            Session::put('locale', $language);
        }
        
        return redirect()->back();
    }
}


