<?php

namespace App\Http\Controllers\Dashboard;



use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Dashboard\Student;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function students(){

        return view('dashboard.students.index');
    }

    public function get_all_students(Request $request)
    {
        if ($request->ajax()) {
            $data = Student::orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->editColumn('name', function ($data) {
                    return '<span style="color:black">'.$data->name.'</span>';
                })

                ->addColumn('is_view', function ($data) {
                    return view('dashboard.students.btn.action2', compact('data'));
                })

                ->addColumn('image', function ($data) {
                    return  '<img src="' . env('APP_URL') . '/attachments/students/' . $data->image . '" alt="" style="width:30%">';
                })


                ->addColumn('action', function ($data) {
                    return view('dashboard.students.btn.action', compact('data'));
                })



                ->rawColumns(['image','name'])

                ->make(true);
        }
    }

    public function store_students(Request $request){

        try {
            $request->validate([
                'name' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'name.required' => 'هذا الاسم مطلوب',
                'image.required' => 'الصورة مطلوبة',
                'image.image' => 'يجب أن تكون الصورة من نوع صورة',
                'image.mimes' => 'الصور المدعومة هي: jpeg, png, jpg, gif',
                'image.max' => 'حجم الصورة يجب أن يكون أقل من 2 ميجابايت',
            ]);



            $user = new Student();
            $user ->name                  = $request->name;

            if ($request->hasFile('image')) {


                $image_url = Str::uuid() . '.' . $request->image->getClientOriginalExtension();

                $base_url = $image_url;

                $user -> image   = $base_url;

                $request->image-> move(public_path('attachments/students'), $image_url);

            }



            $user -> save();



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
                'error' => $e->getMessage(), // يمكن إزالتها في بيئات الإنتاج
            ], 500);
        }


    }

    public function update_students(Request $request){

        try {

            $request->validate([
                'name' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'name.required' => 'هذا الاسم مطلوب',
                'image.required' => 'الصورة مطلوبة',
                'image.image' => 'يجب أن تكون الصورة من نوع صورة',
                'image.mimes' => 'الصور المدعومة هي: jpeg, png, jpg, gif',
                'image.max' => 'حجم الصورة يجب أن يكون أقل من 2 ميجابايت',
            ]);


            $stud = Student::findorFail($request->id);


            $stud->name            = $request->name;

            if ($request->hasFile('image')) {


                // مسار الصورة القديمة
                $oldImagePath = public_path('attachments/students/' . $stud->image);

                // حذف الصورة القديمة إذا كانت موجودة
                if (file_exists($oldImagePath) && $stud->image) {
                    unlink($oldImagePath);
                }

                $image_url = Str::uuid() . '.' . $request->image->getClientOriginalExtension();
                $base_url = $image_url;

                $stud -> image   = $base_url;

                $request->image-> move(public_path('attachments/students'), $image_url);

            }

            $stud->save();

            if ($stud) {
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
                'error' => $e->getMessage(), // يمكن إزالتها في بيئات الإنتاج
            ], 500);
        }

    }

    public function destroy_students(Request $request){

        try {

            $stud = Student::find($request->id);
            $stud->delete();
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

    public function is_view_students(Request $request){

        try {
                $validatedData = $request->validate([
                    'id' => 'required|integer|exists:students,id',
                ], [
                    'id.required' => 'رقم الطالب مطلوب.',
                    'id.integer' => 'رقم الطالب يجب أن يكون رقمًا صحيحًا.',
                    'id.exists' => 'الطالب غير موجود في قاعدة البيانات.',
                ]);

                $student = Student::find($validatedData['id']);

                $student->is_view = !$student->is_view;

                $student->save();

                return response()->json([
                    'status' => true,
                    'msg' => 'تم التعديل بنجاح.',
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
