<?php

namespace App\Http\Controllers\Dashboard;



use App\Models\MainSystem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MainSystemsController extends Controller
{
    public function main_systems()
    {

        return view('dashboard.main_systems.index');
    }

    public function get_all_main_systems(Request $request)
    {
        if ($request->ajax()) {
            $data = MainSystem::orderBy('id', 'desc');
            return Datatables::of($data)

                ->addIndexColumn()

                // ->editColumn('name', function ($data) {
                //     return '<span style="color:black">'.$data->name.'</span>';
                // })

                ->addColumn('image', function ($data) {
                    return  '<img src="' . $data->image . '" alt="" style="width:30%">';
                })


                ->addColumn('action', function ($data) {
                    return view('dashboard.main_systems.btn.action', compact('data'));
                })

                ->rawColumns(['image'])

                ->make(true);
        }
    }

    public function store_main_systems(Request $request)
    {
        try {


            $validator = Validator::make(
                $request->all(),
                [
                    'name_ar' => 'required|string|max:255',
                    'name_en' => 'required|string|max:255',
                    'description_ar' => 'required|string',
                    'description_en' => 'required|string',
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                ],
                [
                    'name_ar.required' => 'الاسم بالعربية مطلوب',
                    'name_en.required' => 'الاسم بالإنجليزية مطلوب',
                    'description_ar.required' => 'الوصف بالعربية مطلوب',
                    'description_en.required' => 'الوصف بالإنجليزية مطلوب',
                    'image.required' => 'الصورة مطلوبة',
                    'image.image' => 'الملف يجب أن يكون صورة',
                    'image.mimes' => 'يجب أن تكون الصورة بصيغة jpeg, png, jpg, gif, svg أو webp',
                    'image.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages()
                ], 422);
            }

            $main_system = new MainSystem();
            $main_system->name_ar = $request->name_ar;
            $main_system->name_en = $request->name_en;
            $main_system->description_ar = $request->description_ar;
            $main_system->description_en = $request->description_en;

            if ($request->hasFile('image')) {
                $image_url = Str::uuid() . '.' . $request->image->getClientOriginalExtension();
                $main_system->image = $image_url;
                $request->image->move(public_path('attachments/main_systems'), $image_url);
            }

            $main_system->save();

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

    public function update_main_systems(Request $request)
    {
        try {


            $validator = Validator::make(
                $request->all(),
                [
                     'name_ar' => 'required|string|max:255',
                'name_en' => 'required|string|max:255',
                'description_ar' => 'required|string',
                'description_en' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                ],
                [
                    'name_ar.required' => 'الاسم بالعربية مطلوب',
                'name_en.required' => 'الاسم بالإنجليزية مطلوب',
                'description_ar.required' => 'الوصف بالعربية مطلوب',
                'description_en.required' => 'الوصف بالإنجليزية مطلوب',
                'image.image' => 'الملف يجب أن يكون صورة',
                'image.mimes' => 'يجب أن تكون الصورة بصيغة jpeg, png, jpg, gif, svg أو webp',
                'image.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages()
                ], 422);
            }

            $main_system = MainSystem::findOrFail($request->id);

            $main_system->name_ar = $request->name_ar;
            $main_system->name_en = $request->name_en;
            $main_system->description_ar = $request->description_ar;
            $main_system->description_en = $request->description_en;

            if ($request->hasFile('image')) {
                $oldImagePath = public_path('attachments/main_systems/' . $main_system->image);
                if (file_exists($oldImagePath) && $main_system->image) {
                    unlink($oldImagePath);
                }

                $image_url = Str::uuid() . '.' . $request->image->getClientOriginalExtension();
                $main_system->image = $image_url;
                $request->image->move(public_path('attachments/main_systems'), $image_url);
            }

            $main_system->save();

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

    public function destroy_main_systems(Request $request)
    {

        try {

            $main_system = MainSystem::find($request->id);
            $main_system->delete();
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
