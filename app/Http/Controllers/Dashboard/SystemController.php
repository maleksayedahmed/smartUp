<?php

namespace App\Http\Controllers\Dashboard;



use App\Models\System;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PackageSystem;
use App\Models\SystemFeature;
use App\Models\SystemAttachmnt;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SystemController extends Controller
{
    public function systems($id = null)
    {

        $systems = System::all();

        return view('dashboard.systems.index', compact('id', 'systems'));
    }

    public function get_all_systems(Request $request, $id = null)
    {
        if ($request->ajax()) {
            $systems_ids = PackageSystem::where('package_id', $id)->pluck('system_id');
            if ($id == null) {
                $data = System::orderBy('id', 'desc');
            } else {

                $data = System::whereIn('id', $systems_ids)->orderBy('id', 'desc');
            }
            return Datatables::of($data)

                ->addIndexColumn()

                // ->editColumn('name', function ($data) {
                //     return '<span style="color:black">'.$data->name.'</span>';
                // })

                ->addColumn('image', function ($data) {
                    return  '<img src="' . $data->image . '" alt="" style="width:30%">';
                })

                ->addColumn('features', function ($data) {
                    $system_features = SystemFeature::where('system_id', $data->id)->count();

                    return '<a href="' . route('dashboard.systems_features', $data->id) . '" class="levels-link btn-link">' . $system_features . '</a>';
                })

                ->addColumn('systems_attachments', function ($data) {
                    $systems_attachments = SystemAttachmnt::where('system_id', $data->id)->count();

                    return '<a  href="' . route('dashboard.systems_attachments', $data->id) . '" class="levels-link btn-link">' . $systems_attachments . '</a>';
                })


                ->addColumn('action', function ($data) {
                    return view('dashboard.systems.btn.action', compact('data'));
                })

                ->rawColumns(['image', 'features', 'systems_attachments'])

                ->make(true);
        }
    }

    public function get_all_systems2(Request $request, $id = null)
    {
        if ($request->ajax()) {
            $systems_ids = PackageSystem::where('package_id', $id)->pluck('system_id');
            if ($id == null) {
                $data = System::orderBy('id', 'desc');
            } else {

                $data = System::whereIn('id', $systems_ids)->orderBy('id', 'desc');
            }
            return Datatables::of($data)

                ->addIndexColumn()

                // ->editColumn('name', function ($data) {
                //     return '<span style="color:black">'.$data->name.'</span>';
                // })

                ->addColumn('image', function ($data) {
                    return  '<img src="' . $data->image . '" alt="" style="width:30%">';
                })

                ->addColumn('features', function ($data) {
                    $system_features = SystemFeature::where('system_id', $data->id)->count();

                    return '<a href="' . route('dashboard.systems_features', $data->id) . '" class="levels-link btn-link">' . $system_features . '</a>';
                })

                ->addColumn('systems_attachments', function ($data) {
                    $systems_attachments = SystemAttachmnt::where('system_id', $data->id)->count();

                    return '<a  href="' . route('dashboard.systems_attachments', $data->id) . '" class="levels-link btn-link">' . $systems_attachments . '</a>';
                })


                ->addColumn('action', function ($data) {
                    return view('dashboard.systems.btn.action2', compact('data'));
                })

                ->rawColumns(['image', 'features', 'systems_attachments'])

                ->make(true);
        }
    }

    public function store_systems(Request $request)
    {
        try {
            if (isset($request->system_id)) {
                $package_system = PackageSystem::where('package_id', $request->package_id)
                    ->where('system_id', $request->system_id)
                    ->first();

                if ($package_system) {
                    return response()->json([
                        'status' => false,
                        'msg' => 'هذا النظام مضاف مسبقا',
                    ], 500);
                } else {
                    $package_system = new PackageSystem();
                    $package_system->package_id = $request->package_id;
                    $package_system->system_id = $request->system_id;
                    $package_system->save();

                    return response()->json([
                        'status' => true,
                        'msg' => 'تمت الاضافة بنجاح',
                    ]);
                }
            }

            $validator = Validator::make(
                $request->all(),
                [
                    'title_ar' => 'required|string|max:255',
                    'title_en' => 'required|string|max:255',
                    'desc_ar'  => 'required|string',
                    'desc_en'  => 'required|string',
                    'image'  => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                ],
                [
                    'title_ar.required' => 'العنوان بالعربية مطلوب',
                    'title_en.required' => 'العنوان بالإنجليزية مطلوب',
                    'desc_ar.required'  => 'الوصف بالعربية مطلوب',
                    'desc_en.required'  => 'الوصف بالإنجليزية مطلوب',
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

            $user = new System();
            $user->title_ar = $request->title_ar;
            $user->title_en = $request->title_en;
            $user->description_ar = $request->desc_ar;
            $user->description_en = $request->desc_en;

            if ($request->hasFile('image')) {
                $oldImagePath = public_path('attachments/systems/' . $user->image);
                if (file_exists($oldImagePath) && $user->image) {
                    unlink($oldImagePath);
                }

                $image_url = Str::uuid() . '.' . $request->image->getClientOriginalExtension();
                $user->image = $image_url;
                $request->image->move(public_path('attachments/systems'), $image_url);
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

    public function update_systems(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'title_ar' => 'required|string|max:255',
                    'title_en' => 'required|string|max:255',
                    'desc_ar'  => 'required|string',
                    'desc_en'  => 'required|string',
                    'image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                ],
                [
                    'title_ar.required' => 'العنوان بالعربية مطلوب',
                    'title_en.required' => 'العنوان بالإنجليزية مطلوب',
                    'desc_ar.required'  => 'الوصف بالعربية مطلوب',
                    'desc_en.required'  => 'الوصف بالإنجليزية مطلوب',
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

            $system = System::findOrFail($request->id);
            $system->title_ar = $request->title_ar;
            $system->title_en = $request->title_en;
            $system->description_ar = $request->desc_ar;
            $system->description_en = $request->desc_en;

            if ($request->hasFile('image')) {
                $oldImagePath = public_path('attachments/systems/' . $system->image);
                if (file_exists($oldImagePath) && $system->image) {
                    unlink($oldImagePath);
                }

                $image_url = Str::uuid() . '.' . $request->image->getClientOriginalExtension();
                $system->image = $image_url;
                $request->image->move(public_path('attachments/systems'), $image_url);
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


    public function destroy_systems(Request $request)
    {

        try {

            $system = System::find($request->id);
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
