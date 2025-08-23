<?php

namespace App\Http\Controllers\Dashboard;



use App\Models\SystemAttachmnt;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SystemAttachmentsController extends Controller
{
    public function systems_attachments($id)
    {

        return view('dashboard.systems_attachments.index', compact('id'));
    }

    public function get_all_systems_attachments(Request $request, $id)
    {

        if ($request->ajax()) {
            $data = SystemAttachmnt::where('system_id', $id)->orderBy('id', 'desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('link', function ($data) {
                    if ($data->type == 'video') {
                        return '<a href="' . $data->link_youtube . '" target="_blank" style="color:blue">' . $data->link_youtube . '</a>';
                    } else {
                        return  '<img src="' . $data->link_image . '" alt="" style="width:30%">';
                    }
                })

                ->addColumn('action', function ($data) {
                    return view('dashboard.systems_attachments.btn.action', compact('data'));
                })

                ->rawColumns(['link'])

                ->make(true);
        }
    }

    public function store_systems_attachments(Request $request)
    {
        try {
            if ($request->system_type == 'image') {
                $validator = Validator::make($request->all(), [
                    'system_type' => 'required|in:image,video',
                    'system_id' => 'required|integer|exists:systems,id',  // Assuming systems table exists
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ], [
                    'system_type.required' => 'نوع النظام مطلوب',
                    'system_type.in' => 'نوع النظام يجب أن يكون صورة أو فيديو',
                    'system_id.required' => 'معرف النظام مطلوب',
                    'system_id.exists' => 'النظام غير موجود',
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

                $system_attachment = new SystemAttachmnt();
                $system_attachment->type = $request->system_type;
                $system_attachment->system_id = $request->system_id;

                $image_url = Str::uuid() . '.' . $request->image->getClientOriginalExtension();
                $system_attachment->link_image = $image_url;
                $request->image->move(public_path('attachments/system_attachments'), $image_url);

                $system_attachment->save();

                return response()->json([
                    'status' => true,
                    'msg' => 'تمت الاضافة بنجاح',
                ]);
            } else if ($request->system_type == 'video') {
                $validator = Validator::make($request->all(), [
                    'system_type' => 'required|in:image,video',
                    'system_id' => 'required|integer|exists:systems,id',
                    'link_video' => 'required|url',
                ], [
                    'system_type.required' => 'نوع النظام مطلوب',
                    'system_type.in' => 'نوع النظام يجب أن يكون صورة أو فيديو',
                    'system_id.required' => 'معرف النظام مطلوب',
                    'system_id.exists' => 'النظام غير موجود',
                    'link_video.required' => 'رابط الفيديو مطلوب',
                    'link_video.url' => 'رابط الفيديو غير صالح',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'errors' => $validator->errors()->messages(),
                    ], 422);
                }

                $system_attachment = new SystemAttachmnt();
                $system_attachment->type = $request->system_type;
                $system_attachment->system_id = $request->system_id;
                $system_attachment->link_youtube = $request->link_video;

                $system_attachment->save();

                return response()->json([
                    'status' => true,
                    'msg' => 'تمت الاضافة بنجاح',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => 'نوع النظام غير معروف',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'حدث خطأ أثناء العملية. يرجى المحاولة لاحقًا.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update_systems_attachments(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:system_attachmnts,id',
                'system_type' => 'required|in:image,video',
                'system_id' => 'required|integer|exists:systems,id',
                'link_video' => 'required_if:system_type,video|url',
                'image' => 'required_if:system_type,image|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ], [
                'id.required' => 'معرف المرفق مطلوب',
                'id.exists' => 'المرفق غير موجود',
                'system_type.required' => 'نوع النظام مطلوب',
                'system_type.in' => 'نوع النظام يجب أن يكون صورة أو فيديو',
                'system_id.required' => 'معرف النظام مطلوب',
                'system_id.exists' => 'النظام غير موجود',
                'link_video.required_if' => 'رابط الفيديو مطلوب لنوع الفيديو',
                'link_video.url' => 'رابط الفيديو غير صالح',
                'image.required_if' => 'الصورة مطلوبة لنوع الصورة',
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

            $system_attachment = SystemAttachmnt::findOrFail($request->id);
            $system_attachment->type = $request->system_type;
            $system_attachment->system_id = $request->system_id;

            if ($request->system_type == 'image' && $request->hasFile('image')) {
                // حذف الصورة القديمة
                if ($system_attachment->link_image) {
                    $oldImagePath = public_path('attachments/system_attachments/' . $system_attachment->link_image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $image_url = Str::uuid() . '.' . $request->image->getClientOriginalExtension();
                $system_attachment->link_image = $image_url;
                $request->image->move(public_path('attachments/system_attachments'), $image_url);
            }

            if ($request->system_type == 'video') {
                $system_attachment->link_youtube = $request->link_video;
            }

            $system_attachment->save();

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

    public function destroy_systems_attachments(Request $request)
    {

        try {

            $system_attachments = SystemAttachmnt::find($request->id);
            $system_attachments->delete();
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
