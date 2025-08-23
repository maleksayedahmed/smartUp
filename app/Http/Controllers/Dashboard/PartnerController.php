<?php

namespace App\Http\Controllers\Dashboard;



use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Support\Facades\Validator;

class PartnerController extends Controller
{
    public function partners()
    {

        return view('dashboard.partners.index');
    }

    public function get_all_partners(Request $request)
    {
        if ($request->ajax()) {
            $data = Partner::orderBy('id', 'desc');

            return Datatables::of($data)

                ->addIndexColumn()

                // ->editColumn('name', function ($data) {
                //     return '<span style="color:black">'.$data->name.'</span>';
                // })

                ->addColumn('image', function ($data) {
                    return  '<img src="' . $data->image . '" alt="" style="width:30%">';
                })

                ->addColumn('action', function ($data) {
                    return view('dashboard.partners.btn.action', compact('data'));
                })

                ->rawColumns(['image'])

                ->make(true);
        }
    }



    public function store_partners(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ], [
                'name.required' => 'الاسم مطلوب',
                'image.required' => 'الصورة مطلوبة',
                'image.image' => 'الملف يجب أن يكون صورة',
                'image.mimes' => 'يجب أن تكون الصورة بصيغة jpeg, png, jpg, gif أو svg',
                'image.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages()
                ], 422);
            }

            $partner = new Partner();
            $partner->name = $request->name;

            if ($request->hasFile('image')) {
                $image_url = Str::uuid() . '.' . $request->image->getClientOriginalExtension();
                $partner->image = $image_url;
                $request->image->move(public_path('attachments/partners'), $image_url);
            }

            $partner->save();

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

    public function update_partners(Request $request)
    {
        try {
            // إذا تريد تحقق من البيانات هنا فقط اسم مثلا
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ], [
                'name.required' => 'الاسم مطلوب',
                'image.image' => 'الملف يجب أن يكون صورة',
                'image.mimes' => 'يجب أن تكون الصورة بصيغة jpeg, png, jpg, gif أو svg',
                'image.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages()
                ], 422);
            }

            $partners = Partner::findOrFail($request->id);
            $partners->name = $request->name;

            if ($request->hasFile('image')) {
                $oldImagePath = public_path('attachments/partners/' . $partners->image);
                if (file_exists($oldImagePath) && $partners->image) {
                    unlink($oldImagePath);
                }

                $image_url = Str::uuid() . '.' . $request->image->getClientOriginalExtension();
                $partners->image = $image_url;
                $request->image->move(public_path('attachments/partners'), $image_url);
            }

            $partners->save();

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


    public function destroy_partners(Request $request)
    {

        try {

            $partners = Partner::find($request->id);
            $partners->delete();
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
