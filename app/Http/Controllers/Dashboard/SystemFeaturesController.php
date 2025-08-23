<?php

namespace App\Http\Controllers\Dashboard;



use App\Models\SystemFeature;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SystemFeaturesController extends Controller
{
    public function systems_features($id)
    {

        return view('dashboard.systems_features.index', compact('id'));
    }

    public function get_all_systems_features(Request $request, $id)
    {

        if ($request->ajax()) {
            $data = SystemFeature::where('system_id', $id)->orderBy('id', 'desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('dashboard.systems_features.btn.action', compact('data'));
                })

                ->rawColumns(['features'])

                ->make(true);
        }
    }


    public function store_systems_features(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title_ar' => 'required',
                'title_en' => 'required',
                'system_id' => 'required',
            ]
            ,
                [
                    'title_ar.required' => 'العنوان بالعربية مطلوب',
                    'title_en.required' => 'العنوان بالإنجليزية مطلوب',
                    'system_id.required' => 'يجب اختيار النظام',
                ]
        );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'msg' => 'فشل في التحقق من البيانات',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $user = new SystemFeature();
            $user->title_ar = $request->title_ar;
            $user->title_en = $request->title_en;
            $user->system_id = $request->system_id;
            if (method_exists($user, 'setTranslations')) {
                $user->setTranslations('title', ['ar' => $request->title_ar, 'en' => $request->title_en]);
            }

            $user->save();

            return response()->json([
                'status' => true,
                'msg' => 'تمت الاضافة بنجاح',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'حدث خطأ أثناء تعديل الحالة. يرجى المحاولة لاحقًا.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update_systems_features(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title_ar' => 'required',
                'title_en' => 'required',
                'system_id' => 'required',
            ],
                [
                    'title_ar.required' => 'العنوان بالعربية مطلوب',
                    'title_en.required' => 'العنوان بالإنجليزية مطلوب',
                    'system_id.required' => 'يجب اختيار النظام',
                ]
        );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'msg' => 'فشل في التحقق من البيانات',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $banner = SystemFeature::findOrFail($request->id);
            $banner->title_ar = $request->title_ar;
            $banner->title_en = $request->title_en;
            $banner->system_id = $request->system_id;
            if (method_exists($banner, 'setTranslations')) {
                $banner->setTranslations('title', ['ar' => $request->title_ar, 'en' => $request->title_en]);
            }

            $banner->save();

            return response()->json([
                'status' => true,
                'msg' => 'تم التعديل بنجاح',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'حدث خطأ أثناء تعديل الحالة. يرجى المحاولة لاحقًا.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function destroy_systems_features(Request $request)
    {

        try {

            $banner = SystemFeature::find($request->id);
            $banner->delete();
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
