<?php

namespace App\Http\Controllers\Dashboard;



use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Support\Facades\Validator;

class BranchesController extends Controller
{
    public function branches()
    {

        return view('dashboard.branches.index');
    }

    public function get_all_branches(Request $request)
    {
        if ($request->ajax()) {
            $data = Branch::orderBy('id', 'desc');

            return Datatables::of($data)

                ->addIndexColumn()

                // ->editColumn('name', function ($data) {
                //     return '<span style="color:black">'.$data->name.'</span>';
                // })

                ->addColumn('image', function ($data) {
                    return  '<img src="' . $data->image . '" alt="" style="width:30%">';
                })

                ->addColumn('action', function ($data) {
                    return view('dashboard.branches.btn.action', compact('data'));
                })

                ->rawColumns(['image'])

                ->make(true);
        }
    }

    public function store_branches(Request $request)
    {
        try {


             $validator = Validator::make($request->all(),
                [
                    'image' => 'required|image|mimes:jpg,jpeg,png,gif',
                ],
                [
                    'image.required' => 'الصورة مطلوبة',
                    'image.image' => 'الملف يجب أن يكون صورة',
                    'image.mimes' => 'يجب أن تكون صيغة الصورة jpg أو jpeg أو png أو gif',

                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages()
                ], 422);
            }

            $user = new Branch();

            if ($request->hasFile('image')) {
                $image_url = Str::uuid() . '.' . $request->image->getClientOriginalExtension();
                $base_url = $image_url;
                $user->image = $base_url;
                $request->image->move(public_path('attachments/branches'), $image_url);
            }

            $user->save();

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

    public function update_branches(Request $request)
    {
        try {
          
             $validator = Validator::make($request->all(),
                [
                    'image' => 'image|mimes:jpg,jpeg,png,gif',
                ],
                [
                    'image.image' => 'الملف يجب أن يكون صورة',
                    'image.mimes' => 'يجب أن تكون صيغة الصورة jpg أو jpeg أو png أو gif',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages()
                ], 422);
            }

            $branches = Branch::findOrFail($request->id);

            if ($request->hasFile('image')) {
                $oldImagePath = public_path('attachments/branches/' . $branches->image);
                if (file_exists($oldImagePath) && $branches->image) {
                    unlink($oldImagePath);
                }

                $image_url = Str::uuid() . '.' . $request->image->getClientOriginalExtension();
                $base_url = $image_url;
                $branches->image = $base_url;
                $request->image->move(public_path('attachments/branches'), $image_url);
            }

            $branches->save();

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


    public function destroy_branches(Request $request)
    {

        try {

            $branches = Branch::find($request->id);
            $branches->delete();
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
