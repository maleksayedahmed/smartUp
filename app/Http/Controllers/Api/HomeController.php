<?php

namespace App\Http\Controllers\Api;



use App\Models\Card;
use App\Models\Banner;
use App\Models\Branch;
use App\Models\Client;
use App\Models\System;
use App\Models\Package;
use App\Models\Partner;
use App\Models\Support;
use App\Models\Testimony;
use App\Models\ContactInfo;
use App\Models\GalleryImage;
use App\Models\PrimaryImage;
use Illuminate\Http\Request;
use App\Models\SystemFeature;
use App\Models\PackageFeature;
use App\Models\SystemAttachmnt;
use App\Http\Controllers\Controller;
use App\Models\MainSystem;

class HomeController extends Controller
{

    public function get_banners(){
        $banners = Banner::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Banners retrieved successfully',
            'data' => $banners
        ],200);
    }

    public function get_main_systems(){
        $main_systems = MainSystem::all();

        return response()->json([
            'status' => 'success',
            'message' => 'main_systems retrieved successfully',
            'data' => $main_systems
        ],200);
    }


    public function get_contact_infos(){

        $contact_infos = ContactInfo::first();

        return response()->json([
            'status' => 'success',
            'message' => 'Contact Info retrieved successfully',
            'data' => $contact_infos
        ],200);
    }




    public function get_system_data(Request $request){

        $system = System::find($request->system_id);
        if(!$system) {
            return response()->json([
                'status' => 'error',
                'message' => 'System not found',
            ], 404);
        }

        $system["features"] = SystemFeature::where('system_id', $system->id)->get();
        $system["attachments"] = SystemAttachmnt::where('system_id', $system->id)->get();

        return response()->json([
            'status' => 'success',
            'message' => 'System retrieved successfully',
            'data' => $system
        ],200);

    }
    public function get_primary_images(){

        $primary_images = PrimaryImage::all();


        return response()->json([
            'status' => 'success',
            'message' => 'primary images retrieved successfully',
            'data' => $primary_images
        ],200);

    }


    public function get_packages(){

        $packages = Package::with('features')->with('packageSpec')->get();

        // foreach($packages as $p) {
        //    $p["package_features"] = PackageFeature::where('package_id', $p->id)->get();
        //    $p["active"] = true;
        // }

        return response()->json([
            'status' => 'success',
            'message' => 'packages retrieved successfully',
            'data' => $packages
        ],200);
    }

    public function get_systems(Request $request){

        $systems = System::get();

        // foreach($systems as $s) {
        //    $s["system_features"] = SystemFeature::where('system_id', $s->id)->get();
        //    $s["active"] = true;
        // }

        return response()->json([
            'status' => 'success',
            'message' => 'systems retrieved successfully',
            'data' => $systems
        ],200);
    }



    public function get_supports(){

        $suports = Support::get();


        return response()->json([
            'status' => 'success',
            'message' => 'supports retrieved successfully',
            'data' => $suports
        ],200);
    }


    public function send_info(Request $request){




         try {

            $request->validate([
                'name' => 'required',
                'mobile' => 'required',
                'email' => 'required|email',
                'subject' => 'required',
                'topic' => 'required',
            ], [
                // 'name.required' => 'هذا الاسم مطلوب',
            ]);


                $client = new Client();

                $client->name = $request->name;
                $client->mobile = $request->mobile;
                $client->email = $request->email;
                $client->subject = $request->subject;
                $client->topic = $request->topic;

                $client->save();



                return response()->json([
                    'status' => true,
                    'msg' => 'تمت الاضافة بنجاح',
                ]);


        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'msg' => 'حدث خطأ أثناء تعديل الحالة. يرجى المحاولة لاحقًا.',
                'error' => $e->getMessage(), // يمكن إزالتها في بيئات الإنتاج
            ], 500);
        }

    }


    public function get_cards(){
        $cards = Card::all();

        return response()->json([
            'status' => 'success',
            'message' => 'cards retrieved successfully',
            'data' => $cards
        ],200);
    }

    public function get_testimonials(){
        $testimonials = Testimony::all();

        return response()->json([
            'status' => 'success',
            'message' => 'testimonials retrieved successfully',
            'data' => $testimonials
        ],200);
    }


    public function get_partners(){

        $pratners = Partner::all();

        return response()->json([
            'status' => 'success',
            'message' => 'parnters retrieved successfully',
            'data' => $pratners
        ],200);
    }

    public function get_branches(){

        $branches = Branch::all();

        return response()->json([
            'status' => 'success',
            'message' => 'branches retrieved successfully',
            'data' => $branches
        ],200);
    }

}
