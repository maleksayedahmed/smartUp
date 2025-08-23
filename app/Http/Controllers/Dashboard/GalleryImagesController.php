<?php

namespace App\Http\Controllers\Dashboard;



use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Support\Facades\Validator;

class GalleryImagesController extends Controller
{
    public function galleryImages($id)
    {

        return view('dashboard.galleryImages.index', compact('id'));
    }

    public function get_all_galleryImages(Request $request, $id)
    {
        if ($request->ajax()) {

            $data = GalleryImage::where('primary_image_id', $id)->orderBy('id', 'desc');

            return Datatables::of($data)

                ->addIndexColumn()

                // ->editColumn('name', function ($data) {
                //     return '<span style="color:black">'.$data->name.'</span>';
                // })

                ->addColumn('image', function ($data) {
                    return  '<img src="' . $data->image . '" alt="" style="width:30%">';
                })

                ->addColumn('action', function ($data) {
                    return view('dashboard.galleryImages.btn.action', compact('data'));
                })

                ->rawColumns(['image'])

                ->make(true);
        }
    }

    public function store_galleryImages(Request $request)
    {
        try {
            $request->validate([
                'primary_image_id' => 'nullable|integer|exists:gallery_images,id',
                'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
                'title_ar'=> 'required',
                'title_en'=> 'required',
            ], [
                'image.required' => 'الصورة مطلوبة',
                'image.image' => 'الملف يجب أن يكون صورة',
                'image.mimes' => 'يجب أن تكون الصورة بصيغة jpg أو jpeg أو png أو webp',
                'image.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت',
                'title_ar.required'=>'حقل العنوان بالعربية مطلوب ',
                'title_en.required'=>'حقل العنوان بالانجليزية مطلوب ',
            ]);

             $validator = Validator::make($request->all(),
                [
                    'primary_image_id' => 'nullable|integer|exists:gallery_images,id',
                    'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
                ],
                [
                    'image.required' => 'الصورة مطلوبة',
                    'image.image' => 'الملف يجب أن يكون صورة',
                    'image.mimes' => 'يجب أن تكون الصورة بصيغة jpg أو jpeg أو png أو webp',
                    'image.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages()
                ], 422);
            }

            $galleryImage = new GalleryImage();
            $galleryImage->primary_image_id = $request->primary_image_id;

            if ($request->hasFile('image')) {
                $image_url = Str::uuid() . '.' . $request->image->getClientOriginalExtension();
                $galleryImage->image = $image_url;
                $request->image->move(public_path('attachments/galleryImages'), $image_url);
            }

            $galleryImage->save();

            return response()->json([
                'status' => true,
                'msg' => 'تمت الإضافة بنجاح',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'حدث خطأ أثناء الحفظ. يرجى المحاولة لاحقًا.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update_galleryImages(Request $request)
    {
        try {

             $validator = Validator::make($request->all(),
                [
                    'image' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
                ],
                [
                    'image.image' => 'الملف يجب أن يكون صورة',
                    'image.mimes' => 'يجب أن تكون الصورة بصيغة jpg أو jpeg أو png أو webp',
                    'image.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages()
                ], 422);
            }

            $galleryImages = GalleryImage::findOrFail($request->id);

            if ($request->hasFile('image')) {
                $oldImagePath = public_path('attachments/galleryImages/' . $galleryImages->image);
                if (file_exists($oldImagePath) && $galleryImages->image) {
                    unlink($oldImagePath);
                }

                $image_url = Str::uuid() . '.' . $request->image->getClientOriginalExtension();
                $galleryImages->image = $image_url;
                $request->image->move(public_path('attachments/galleryImages'), $image_url);
            }

            $galleryImages->save();

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


    public function destroy_galleryImages(Request $request)
    {

        try {

            $galleryImages = GalleryImage::find($request->id);
            $galleryImages->delete();
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
