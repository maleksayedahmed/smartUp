<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Banner;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    // قواعد التحقق المشتركة
    private $validationRules = [
        'title_ar' => 'required|string|max:255',
        'title_en' => 'required|string|max:255',
        'desc_ar' => 'required|string',
        'desc_en' => 'required|string'
    ];

    // رسائل الأخطاء المخصصة
    private $validationMessages = [
        'title_ar.required' => 'حقل العنوان العربي مطلوب',
        'title_en.required' => 'حقل العنوان الإنجليزي مطلوب',
        'desc_ar.required' => 'حقل الوصف العربي مطلوب',
        'desc_en.required' => 'حقل الوصف الإنجليزي مطلوب',
        'title_ar.max' => 'يجب ألا يتجاوز العنوان العربي 255 حرفًا',
        'title_en.max' => 'يجب ألا يتجاوز العنوان الإنجليزي 255 حرفًا'
    ];

    public function banners()
    {
        return view('dashboard.banners.index');
    }

    public function get_all_banners(Request $request)
    {
        if ($request->ajax()) {
            $data = Banner::orderBy('id', 'desc');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return view('dashboard.banners.btn.action', compact('data'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store_banners(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validationRules, $this->validationMessages);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->messages()
            ], 422);
        }

        try {
            $banner = Banner::create([
                'title_ar' => $request->title_ar,
                'title_en' => $request->title_en,
                'description_ar' => $request->desc_ar,
                'description_en' => $request->desc_en
            ]);

            return response()->json([
                'status' => true,
                'msg' => 'تمت الإضافة بنجاح'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'حدث خطأ أثناء الإضافة: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update_banners(Request $request)
    {
        // إضافة قاعدة التحقق لوجود الـ ID
        $rules = array_merge($this->validationRules, ['id' => 'required|exists:banners,id']);

        $validator = Validator::make($request->all(), $rules, $this->validationMessages);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->messages()
            ], 422);
        }

        try {
            $banner = Banner::findOrFail($request->id);

            $banner->update([
                'title_ar' => $request->title_ar,
                'title_en' => $request->title_en,
                'description_ar' => $request->desc_ar,
                'description_en' => $request->desc_en
            ]);

            return response()->json([
                'status' => true,
                'msg' => 'تم التحديث بنجاح'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'حدث خطأ أثناء التحديث: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy_banners(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:banners,id'
        ], [
            'id.required' => 'معرف البانر مطلوب',
            'id.exists' => 'البانر المحدد غير موجود'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->messages()
            ], 422);
        }

        try {
            $banner = Banner::findOrFail($request->id);
            $banner->delete();

            return response()->json([
                'status' => true,
                'msg' => 'تم الحذف بنجاح'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'حدث خطأ أثناء الحذف: ' . $e->getMessage()
            ], 500);
        }
    }
}
