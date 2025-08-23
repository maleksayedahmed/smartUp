<?php

namespace App\Http\Controllers\Dashboard;



use App\Models\Support;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SupportFeature;
use App\Models\SupportAttachmnt;
use Yajra\DataTables\DataTables;
use Illuminate\supports\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SupportController extends Controller
{
    public function supports($id = null)
    {

        $supports = Support::all();

        return view('dashboard.supports.index', compact('id', 'supports'));
    }

    public function get_all_supports(Request $request, $id = null)
    {
        if ($request->ajax()) {

            $data = Support::orderBy('id', 'desc');

            return Datatables::of($data)

                ->addIndexColumn()

                // ->editColumn('name', function ($data) {
                //     return '<span style="color:black">'.$data->name.'</span>';
                // })

                ->addColumn('image', function ($data) {
                    return  '<img src="' . $data->image . '" alt="" style="width:30%">';
                })




                ->addColumn('action', function ($data) {
                    return view('dashboard.supports.btn.action', compact('data'));
                })

                ->rawColumns(['image', 'features', 'supports_attachments'])

                ->make(true);
        }
    }



    public function store_supports(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ], [
                'title.required' => 'العنوان مطلوب',
                'image.required' => 'الصورة مطلوبة',
                'image.image' => 'الملف يجب أن يكون صورة',
                'image.mimes' => 'يجب أن تكون الصورة بصيغة jpeg, png, jpg, gif أو svg',
                'image.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages(),
                ], 422);
            }

            $support = new Support();
            $support->title = $request->title;

            if ($request->hasFile('image')) {
                // حذف صورة قديمة لو موجودة (بالرغم أنه جديد، بس لحماية الكود)
                if ($support->image) {
                    $oldImagePath = public_path('attachments/supports/' . $support->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $image_url = Str::uuid() . '.' . $request->image->getClientOriginalExtension();
                $support->image = $image_url;
                $request->image->move(public_path('attachments/supports'), $image_url);
            }

            $support->save();

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

    public function update_supports(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:supports,id',
                'title' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ], [
                'id.required' => 'معرف الدعم مطلوب',
                'id.exists' => 'الدعم غير موجود',
                'title.required' => 'العنوان مطلوب',
                'image.image' => 'الملف يجب أن يكون صورة',
                'image.mimes' => 'يجب أن تكون الصورة بصيغة jpeg, png, jpg, gif أو svg',
                'image.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages(),
                ], 422);
            }

            $support = Support::findOrFail($request->id);
            $support->title = $request->title;

            if ($request->hasFile('image')) {
                $oldImagePath = public_path('attachments/supports/' . $support->image);
                if (file_exists($oldImagePath) && $support->image) {
                    unlink($oldImagePath);
                }

                $image_url = Str::uuid() . '.' . $request->image->getClientOriginalExtension();
                $support->image = $image_url;
                $request->image->move(public_path('attachments/supports'), $image_url);
            }

            $support->save();

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

    public function destroy_supports(Request $request)
    {

        try {

            $system = Support::find($request->id);
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
