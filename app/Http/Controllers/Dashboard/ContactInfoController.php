<?php

namespace App\Http\Controllers\Dashboard;



use App\Models\ContactInfo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ContactInfoController extends Controller
{
    public function contact_infos()
    {

        $contact_infos = ContactInfo::first();

        return view('dashboard.contact_infos.index', compact('contact_infos'));
    }

    public function get_all_contact_infos(Request $request)
    {
        if ($request->ajax()) {
            $data = ContactInfo::orderBy('id', 'desc');
            return Datatables::of($data)

                ->addIndexColumn()

                // ->editColumn('name', function ($data) {
                //     return '<span style="color:black">'.$data->name.'</span>';
                // })

                ->addColumn('action', function ($data) {
                    return view('dashboard.contact_infos.btn.action', compact('data'));
                })

                ->rawColumns([''])

                ->make(true);
        }
    }



    public function update_contact_infos(Request $request)
    {
        try {

             $validator = Validator::make($request->all(),
                [
                    'email' => 'required|email',
                'mobile' => 'nullable|string|max:20',
                'facebook' => 'nullable|url',
                'instagram' => 'nullable|url',
                'tiktok' => 'nullable|url',
                'youtube' => 'nullable|url',
                'address' => 'nullable|string|max:255',
                'X' => 'nullable|url',
                'linkedin' => 'nullable|url',
                'whatsapp' => 'nullable|string|max:20',
                'site_name' => 'nullable|string|max:255',
                'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'

                ],
                [
                     'email.required' => 'البريد الإلكتروني مطلوب',
                    'email.email' => 'يجب إدخال بريد إلكتروني صالح',
                    'logo.image' => 'الملف المرفوع يجب أن يكون صورة',
                     'logo.mimes' => 'الصورة يجب أن تكون بصيغة jpg أو jpeg أو png أو webp',
                    'logo.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages()
                ], 422);
            }

            $contact_info = ContactInfo::findOrFail($request->id);

            // تحديث الحقول النصية
            $contact_info->mobile = $request->mobile;
            $contact_info->email = $request->email;
            $contact_info->facebook = $request->facebook;
            $contact_info->instagram = $request->instagram;
            $contact_info->tiktok = $request->tiktok;
            $contact_info->youtube = $request->youtube;
            $contact_info->address = $request->address;
            $contact_info->X = $request->X;
            $contact_info->linkedin = $request->linkedin;
            $contact_info->whatsapp = $request->whatsapp;
            $contact_info->site_name = $request->site_name;

            // معالجة صورة الشعار
            if ($request->hasFile('logo')) {
                $oldImagePath = public_path('attachments/contact_infos/' . $contact_info->logo);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }

                $image = $request->file('logo');
                $image_name = Str::uuid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('attachments/contact_infos'), $image_name);
                $contact_info->logo = $image_name;
            }

            $contact_info->save();

            return response()->json([
                'status' => true,
                'msg' => 'تم التعديل بنجاح',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'حدث خطأ أثناء التعديل: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy_contact_infos(Request $request)
    {

        try {

            $contact_info = ContactInfo::find($request->id);
            $contact_info->delete();
            return response()->json([
                'status' => true,
                'msg' => 'deleted Successfully',
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'msg' => 'حدث خطأ أثناء تعديل الحالة. يرجى المحاولة لاحقًا.',
                'error' => $e->getMessage(), // يمكن إزالتها في بيئات الإنتاج
            ], 500);
        }
    }
}
