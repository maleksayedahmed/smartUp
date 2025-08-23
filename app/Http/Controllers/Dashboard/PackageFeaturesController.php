<?php

namespace App\Http\Controllers\Dashboard;



use App\Models\PackageFeature;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PackageFeaturesController extends Controller
{
    public function packages_features($id)
    {

        return view('dashboard.packages_features.index', compact('id'));
    }

    public function get_all_packages_features(Request $request, $id)
    {

        if ($request->ajax()) {
            $data = PackageFeature::where('package_id', $id)->orderBy('id', 'desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('dashboard.packages_features.btn.action', compact('data'));
                })

                ->rawColumns(['features'])

                ->make(true);
        }
    }

    public function store_packages_features(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'title_ar'   => 'required|string|max:255',
                    'title_en'   => 'required|string|max:255',
                    'package_id' => 'required|integer|exists:packages,id',
                ],
                [
                    'title_ar.required'   => 'العنوان بالعربية مطلوب',
                    'title_en.required'   => 'العنوان بالإنجليزية مطلوب',
                    'package_id.required' => 'يجب اختيار الباقة',
                    'package_id.integer'  => 'معرف الباقة يجب أن يكون رقمًا',
                    'package_id.exists'   => 'الباقة المحددة غير موجودة',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages()
                ], 422);
            }

            $feature = new PackageFeature();
            $feature->title_ar   = $request->title_ar;
            $feature->title_en   = $request->title_en;
            $feature->package_id = $request->package_id;
            if (method_exists($feature, 'setTranslations')) {
                $feature->setTranslations('title', ['ar' => $request->title_ar, 'en' => $request->title_en]);
            }

            $feature->save();

            return response()->json([
                'status' => true,
                'msg' => 'تمت الإضافة بنجاح',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'حدث خطأ أثناء الإضافة. يرجى المحاولة لاحقًا.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update_packages_features(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'title_ar'   => 'required|string|max:255',
                    'title_en'   => 'required|string|max:255',
                    'package_id' => 'required|integer|exists:packages,id',
                ],
                [
                    'title_ar.required'   => 'العنوان بالعربية مطلوب',
                    'title_en.required'   => 'العنوان بالإنجليزية مطلوب',
                    'package_id.required' => 'يجب اختيار الباقة',
                    'package_id.integer'  => 'معرف الباقة يجب أن يكون رقمًا',
                    'package_id.exists'   => 'الباقة المحددة غير موجودة',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages()
                ], 422);
            }

            $feature = PackageFeature::findOrFail($request->id);
            $feature->title_ar   = $request->title_ar;
            $feature->title_en   = $request->title_en;
            $feature->package_id = $request->package_id;
            if (method_exists($feature, 'setTranslations')) {
                $feature->setTranslations('title', ['ar' => $request->title_ar, 'en' => $request->title_en]);
            }

            $feature->save();

            return response()->json([
                'status' => true,
                'msg' => 'تم التعديل بنجاح',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'حدث خطأ أثناء التعديل. يرجى المحاولة لاحقًا.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy_packages_features(Request $request)
    {

        try {

            $banner = PackageFeature::find($request->id);
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
