<?php

namespace App\Http\Controllers\Dashboard;



use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PackageSpec;
use App\Models\PackageSpecFeature;
use App\Models\PackageSpecAttachmnt;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PackageSpecController extends Controller
{
    public function package_spec($id = null)
    {

        $package_spec = PackageSpec::all();

        return view('dashboard.package_spec.index', compact('id', 'package_spec'));
    }

    public function get_all_package_spec(Request $request, $id = null)
    {
        if ($request->ajax()) {

            $data = PackageSpec::where('package_id', $id)->orderBy('id', 'desc');

            return Datatables::of($data)

                ->addIndexColumn()

                // ->editColumn('name', function ($data) {
                //     return '<span style="color:black">'.$data->name.'</span>';
                // })

                ->addColumn('image', function ($data) {
                    return  '<img src="' . $data->image . '" alt="" style="width:30%">';
                })




                ->addColumn('action', function ($data) {
                    return view('dashboard.package_spec.btn.action', compact('data'));
                })

                ->rawColumns(['image', 'features', 'package_spec_attachments'])

                ->make(true);
        }
    }


    public function store_package_spec(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title_ar' => 'required|string',
                'title_en' => 'required|string',
                'desc_ar'  => 'required|string',
                'desc_en'  => 'required|string',
                'image'    => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ], [
                'title_ar.required' => 'العنوان بالعربية مطلوب',
                'title_en.required' => 'العنوان بالإنجليزية مطلوب',
                'desc_ar.required'  => 'الوصف بالعربية مطلوب',
                'desc_en.required'  => 'الوصف بالإنجليزية مطلوب',
                'image.required'    => 'الصورة مطلوبة',
                'image.image'       => 'الملف يجب أن يكون صورة',
                'image.mimes'       => 'يجب أن تكون الصورة بصيغة jpeg, png, jpg, gif, svg أو webp',
                'image.max'         => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages()
                ], 422);
            }

            $user = new PackageSpec();
            $user->package_id       = $request->package_id;
            $user->title_ar         = $request->title_ar;
            $user->title_en         = $request->title_en;
            $user->desctiption_ar   = $request->desc_ar;
            $user->desctiption_en   = $request->desc_en;

            if ($request->hasFile('image')) {
                // حذف الصورة القديمة لو موجودة (رغم انه جديد، بس لو تحب تحتاط)
                $oldImagePath = public_path('attachments/package_spec/' . $user->image);
                if (file_exists($oldImagePath) && $user->image) {
                    unlink($oldImagePath);
                }

                $image_url = Str::uuid() . '.' . $request->image->getClientOriginalExtension();
                $user->image = $image_url;

                $request->image->move(public_path('attachments/package_spec'), $image_url);
            }

            $user->save();

            if ($user) {
                return response()->json([
                    'status' => true,
                    'msg' => 'تمت الاضافة بنجاح',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => 'فشل الحفظ برجاء المحاوله مجددا',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'حدث خطأ أثناء تعديل الحالة. يرجى المحاولة لاحقًا.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update_package_spec(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title_ar' => 'required|string',
                'title_en' => 'required|string',
                'desc_ar'  => 'required|string',
                'desc_en'  => 'required|string',
                'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ], [
                'title_ar.required' => 'العنوان بالعربية مطلوب',
                'title_en.required' => 'العنوان بالإنجليزية مطلوب',
                'desc_ar.required'  => 'الوصف بالعربية مطلوب',
                'desc_en.required'  => 'الوصف بالإنجليزية مطلوب',
                'image.image'       => 'الملف يجب أن يكون صورة',
                'image.mimes'       => 'يجب أن تكون الصورة بصيغة jpeg, png, jpg, gif, svg أو webp',
                'image.max'         => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages()
                ], 422);
            }

            $system = PackageSpec::findOrFail($request->id);
            $system->package_id       = $request->package_id;
            $system->title_ar         = $request->title_ar;
            $system->title_en         = $request->title_en;
            $system->desctiption_ar   = $request->desc_ar;
            $system->desctiption_en   = $request->desc_en;

            if ($request->hasFile('image')) {
                $oldImagePath = public_path('attachments/package_spec/' . $system->image);
                if (file_exists($oldImagePath) && $system->image) {
                    unlink($oldImagePath);
                }

                $image_url = Str::uuid() . '.' . $request->image->getClientOriginalExtension();
                $system->image = $image_url;

                $request->image->move(public_path('attachments/package_spec'), $image_url);
            }

            $system->save();

            if ($system) {
                return response()->json([
                    'status' => true,
                    'msg' => 'تم التعديل بنجاح',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => 'فشل التعديل برجاء المحاوله مجددا',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'حدث خطأ أثناء تعديل الحالة. يرجى المحاولة لاحقًا.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function destroy_package_spec(Request $request)
    {

        try {

            $system = PackageSpec::find($request->id);
            $system->delete();
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
