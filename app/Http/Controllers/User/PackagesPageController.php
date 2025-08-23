<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Testimony;
use App\Models\ContactInfo;
use Illuminate\Http\Request;

class PackagesPageController extends Controller
{
    public function index(Request $request)
    {
        $packages = Package::with(['systems.features', 'features', 'benefits'])->get();
        $testimonials = Testimony::orderBy('id')->take(3)->get();
        $contactInfo = ContactInfo::first();
        
        return view('user.packages', compact('packages', 'testimonials', 'contactInfo'));
    }
}


