<?php

namespace App\Http\Controllers\Dashboard;



use Illuminate\Support\Str;
use App\Models\GalleryImage;
use App\Models\PrimaryImage;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PrimaryImagesController extends Controller
{
    public function primaryImages()
    {

        return view('dashboard.primaryImages.index');
    }

    public function get_all_primaryImages(Request $request)
    {
        if ($request->ajax()) {
            $data = PrimaryImage::orderBy('id', 'desc');

            return Datatables::of($data)

                ->addIndexColumn()

                // ->editColumn('name', function ($data) {
                //     return '<span style="color:black">'.$data->name.'</span>';
                // })

                ->addColumn('image', function ($data) {
                    return  '<img src="' . $data->image . '" alt="" style="width:30%">';
                })

                ->addColumn('is_view', function ($data) {
                    return view('dashboard.primaryImages.btn.action2', compact('data'));
                })


                ->addColumn('action', function ($data) {
                    return view('dashboard.primaryImages.btn.action', compact('data'));
                })

                ->rawColumns(['image', 'galleryImages'])

                ->make(true);
        }
    }


    public function is_main(Request $request)
    {
        try {
            $primaryImage = PrimaryImage::findOrFail($request->id);

            $primaryImagemain = PrimaryImage::where('is_main', 1)->first();
            if ($primaryImagemain && $primaryImagemain->id != $primaryImage->id) {
                // إذا كان هناك صورة رئيسية أخرى، قم بتعيينها كـ غير رئيسية
                $primaryImagemain->is_main = 0;
                $primaryImagemain->save();
            }


            if ($primaryImage->is_main == 1) {

                $primaryImage->is_main = 0;
            } elseif ($request->is_main == 0) {

                $primaryImage->is_main = 1;
            }

            $primaryImage->save();

            return response()->json([
                'status' => true,
                'msg' => 'تم تحديث الحالة بنجاح',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'حدث خطأ أثناء تحديث الحالة. يرجى المحاولة لاحقًا.',
                'error' => $e->getMessage(), // يمكن إزالتها في بيئات الإنتاج
            ], 500);
        }
    }

    public function store_primaryImages(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'title_ar' => 'nullable|string',
                'title_en' => 'nullable|string',
            ], [
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

            $primaryImage = new PrimaryImage();
            $primaryImage->title_ar = $request->title_ar;
            $primaryImage->title_en = $request->title_en;

            if ($request->hasFile('image')) {
                $image_url = Str::uuid() . '.' . $request->image->getClientOriginalExtension();
                $primaryImage->image = $image_url;
                $request->image->move(public_path('attachments/primaryImages'), $image_url);
            }

            $primaryImage->save();

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

    public function update_primaryImages(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'title_ar' => 'nullable|string',
                'title_en' => 'nullable|string',
                'id' => 'required|exists:primary_images,id',
            ], [
                'image.image' => 'الملف يجب أن يكون صورة',
                'image.mimes' => 'يجب أن تكون الصورة بصيغة jpeg, png, jpg, gif أو svg',
                'image.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت',
                'id.required' => 'معرف الصورة مطلوب',
                'id.exists' => 'الصورة غير موجودة',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages()
                ], 422);
            }

            $primaryImages = PrimaryImage::findOrFail($request->id);

            if ($request->has('title_ar')) {
                $primaryImages->title_ar = $request->title_ar;
            }
            if ($request->has('title_en')) {
                $primaryImages->title_en = $request->title_en;
            }

            if ($request->hasFile('image')) {
                $oldImagePath = public_path('attachments/primaryImages/' . $primaryImages->image);
                if (file_exists($oldImagePath) && $primaryImages->image) {
                    unlink($oldImagePath);
                }

                $image_url = Str::uuid() . '.' . $request->image->getClientOriginalExtension();
                $primaryImages->image = $image_url;
                $request->image->move(public_path('attachments/primaryImages'), $image_url);
            }

            $primaryImages->save();

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


    public function destroy_primaryImages(Request $request)
    {

        try {

            $primaryImages = PrimaryImage::find($request->id);
            $primaryImages->delete();
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
