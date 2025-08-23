<?php

namespace App\Http\Controllers\Dashboard;




use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Testimony;
use Illuminate\Support\Facades\Validator;

class TestimonialsController extends Controller
{



    public function testimonials()
    {

        return view('dashboard.testimonials.index');
    }

    public function get_all_testimonials(Request $request)
    {
        if ($request->ajax()) {
            $data = Testimony::orderBy('id', 'asc');

            return Datatables::of($data)

                ->addIndexColumn()



                ->addColumn('action', function ($data) {
                    return view('dashboard.testimonials.btn.action', compact('data'));
                })

                ->rawColumns(['image'])

                ->make(true);
        }
    }

    public function store_testimonials(Request $request)
    {
        try {


            $validator = Validator::make($request->all(),
                [
                    'name_ar' => 'required|string|max:255',
                    'name_en' => 'required|string|max:255',
                    'position_ar'  => 'required|string|max:255',
                    'position_en'  => 'required|string|max:255',
                    'content_ar' => 'required|string',
                    'content_en' => 'required|string',
                ],
                [
                    'name_ar.required' => 'الاسم بالعربية مطلوب',
                    'name_en.required' => 'الاسم بالإنجليزية مطلوب',
                    'position_ar.required' => 'المسمى الوظيفي بالعربية مطلوب',
                    'position_en.required' => 'المسمى الوظيفي بالإنجليزية مطلوب',
                    'content_ar.required' => 'المحتوى بالعربية مطلوب',
                    'content_en.required' => 'المحتوى بالإنجليزية مطلوب',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages()
                ], 422);
            }



            $testimony = new Testimony();
            $testimony->name_ar      = $request->name_ar;
            $testimony->name_en      = $request->name_en;
            $testimony->position_ar  = $request->position_ar;
            $testimony->position_en  = $request->position_en;
            $testimony->content_ar   = $request->content_ar;
            $testimony->content_en   = $request->content_en;
            $testimony->save();

            return response()->json([
                'status' => true,
                'msg' => 'تمت الاضافة بنجاح',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'حدث خطأ أثناء الإضافة. يرجى المحاولة لاحقًا.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update_testimonials(Request $request)
    {
        try {
             $validator = Validator::make($request->all(),
                [
                'name_ar' => 'required|string|max:255',
                'name_en' => 'required|string|max:255',
                'position_ar'  => 'required|string|max:255',
                'position_en'  => 'required|string|max:255',
                'content_ar' => 'required|string',
                'content_en' => 'required|string',

                ],
                [
                'name_ar.required' => 'الاسم بالعربية مطلوب',
                'name_en.required' => 'الاسم بالإنجليزية مطلوب',
                'position_ar.required' => 'المسمى الوظيفي بالعربية مطلوب',
                'position_en.required' => 'المسمى الوظيفي بالإنجليزية مطلوب',
                'content_ar.required' => 'المحتوى بالعربية مطلوب',
                'content_en.required' => 'المحتوى بالإنجليزية مطلوب',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages()
                ], 422);
            }

            $testimony = Testimony::findOrFail($request->id);
            $testimony->name_ar      = $request->name_ar;
            $testimony->name_en      = $request->name_en;
            $testimony->position_ar  = $request->position_ar;
            $testimony->position_en  = $request->position_en;
            $testimony->content_ar   = $request->content_ar;
            $testimony->content_en   = $request->content_en;
            $testimony->save();

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


    public function destroy_testimonials(Request $request)
    {

        try {

            $testimony = Testimony::find($request->id);
            $testimony->delete();
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
