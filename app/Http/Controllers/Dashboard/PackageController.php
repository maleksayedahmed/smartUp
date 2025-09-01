<?php

namespace App\Http\Controllers\Dashboard;



use App\Models\System;
use App\Models\Package;
use App\Models\PackageSpec;
use Illuminate\Http\Request;
use App\Models\PackageSystem;
use App\Models\PackageBenefit;
use App\Models\PackageSystemFeature;
use App\Models\PackageFeature;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function packages()
    {
        return view('dashboard.packages.index');
    }

    public function create()
    {
        return view('dashboard.packages.form');
    }

    public function edit($id)
    {
        $package = Package::with(['systems.features', 'benefits', 'features'])->findOrFail($id);
        return view('dashboard.packages.form', compact('package'));
    }

    public function storeFull(Request $request)
    {
        $data = $this->validateFull($request);
        DB::transaction(function () use ($data, $request) {
            $package = new Package();
            $package->setTranslations('title', $data['title']);
            $package->setTranslations('desc',  $data['desc']);
            $package->setTranslations('note',  $data['note']);
            $package->slug = $data['slug'] ?? Str::uuid();
            $package->save();

            // Benefits
            foreach ($data['benefits'] ?? [] as $b) {
                $benefit = new PackageBenefit();
                $benefit->package_id = $package->id;
                $benefit->number = $b['number'] ?? null;
                $benefit->setTranslations('label', $b['label']);
                $benefit->save();
            }

            // Systems
            foreach ($data['systems'] ?? [] as $sysIndex => $sys) {
                $pkgSys = new PackageSystem();
                $pkgSys->package_id = $package->id;
                $pkgSys->slug = $sys['slug'] ?? null;
                $pkgSys->setTranslations('title', $sys['title']);
                $pkgSys->setTranslations('description', $sys['description'] ?? []);
                $pkgSys->save();

                // Handle media uploads
                if ($request->hasFile("systems.{$sysIndex}.icon")) {
                    $pkgSys->addMediaFromRequest("systems.{$sysIndex}.icon")
                           ->toMediaCollection('icon');
                }
                if ($request->hasFile("systems.{$sysIndex}.image1")) {
                    $pkgSys->addMediaFromRequest("systems.{$sysIndex}.image1")
                           ->toMediaCollection('image1');
                }
                if ($request->hasFile("systems.{$sysIndex}.image2")) {
                    $pkgSys->addMediaFromRequest("systems.{$sysIndex}.image2")
                           ->toMediaCollection('image2');
                }
                if ($request->hasFile("systems.{$sysIndex}.video")) {
                    $pkgSys->addMediaFromRequest("systems.{$sysIndex}.video")
                           ->toMediaCollection('video');
                }

                // features
                foreach ($sys['features'] ?? [] as $f) {
                    $feat = new PackageSystemFeature();
                    $feat->package_system_id = $pkgSys->id;
                    $feat->setTranslations('title', $f['title']);
                    $feat->save();
                }
            }
        });

        return redirect()->route('dashboard.packages')->with('success', 'تم الحفظ بنجاح');
    }

    public function updateFull(Request $request, $id)
    {
        $data = $this->validateFull($request);
        DB::transaction(function () use ($data, $id, $request) {
            $package = Package::with(['systems.features', 'benefits'])->findOrFail($id);
            $package->setTranslations('title', $data['title']);
            $package->setTranslations('desc',  $data['desc']);
            $package->setTranslations('note',  $data['note']);
            if (!empty($data['slug'])) $package->slug = $data['slug'];
            $package->save();

            // sync benefits
            $package->benefits()->delete();
            foreach ($data['benefits'] ?? [] as $b) {
                $benefit = new PackageBenefit();
                $benefit->package_id = $package->id;
                $benefit->number = $b['number'] ?? null;
                $benefit->setTranslations('label', $b['label']);
                $benefit->save();
            }

            // sync systems without losing existing media unless new files are uploaded
            $existingSystems = $package->systems()->with('features')->get()->values();
            $keptSystemIds = [];

            foreach ($data['systems'] ?? [] as $sysIndex => $sys) {
                $pkgSys = $existingSystems->get($sysIndex) ?? new PackageSystem();

                if (!$pkgSys->exists) {
                    $pkgSys->package_id = $package->id;
                }

                $pkgSys->slug = $sys['slug'] ?? null;
                $pkgSys->setTranslations('title', $sys['title']);
                $pkgSys->setTranslations('description', $sys['description'] ?? []);
                $pkgSys->save();

                $keptSystemIds[] = $pkgSys->id;

                // Replace media ONLY when a new file is uploaded; otherwise keep existing
                if ($request->hasFile("systems.{$sysIndex}.icon")) {
                    $pkgSys->clearMediaCollection('icon');
                    $pkgSys->addMediaFromRequest("systems.{$sysIndex}.icon")
                           ->toMediaCollection('icon');
                }
                if ($request->hasFile("systems.{$sysIndex}.image1")) {
                    $pkgSys->clearMediaCollection('image1');
                    $pkgSys->addMediaFromRequest("systems.{$sysIndex}.image1")
                           ->toMediaCollection('image1');
                }
                if ($request->hasFile("systems.{$sysIndex}.image2")) {
                    $pkgSys->clearMediaCollection('image2');
                    $pkgSys->addMediaFromRequest("systems.{$sysIndex}.image2")
                           ->toMediaCollection('image2');
                }
                if ($request->hasFile("systems.{$sysIndex}.video")) {
                    $pkgSys->clearMediaCollection('video');
                    $pkgSys->addMediaFromRequest("systems.{$sysIndex}.video")
                           ->toMediaCollection('video');
                }

                // features: recreate per submitted payload
                $pkgSys->features()->delete();
                foreach ($sys['features'] ?? [] as $f) {
                    $feat = new PackageSystemFeature();
                    $feat->package_system_id = $pkgSys->id;
                    $feat->setTranslations('title', $f['title']);
                    $feat->save();
                }
            }

            // Remove systems that were not sent in the request
            if (!empty($keptSystemIds)) {
                $package->systems()->whereNotIn('id', $keptSystemIds)->get()->each(function ($sys) {
                    $sys->features()->delete();
                    $sys->clearMediaCollection('icon');
                    $sys->clearMediaCollection('image1');
                    $sys->clearMediaCollection('image2');
                    $sys->clearMediaCollection('video');
                    $sys->delete();
                });
            } else {
                // If no systems provided, remove all existing
                $package->systems()->get()->each(function ($sys) {
                    $sys->features()->delete();
                    $sys->clearMediaCollection('icon');
                    $sys->clearMediaCollection('image1');
                    $sys->clearMediaCollection('image2');
                    $sys->clearMediaCollection('video');
                    $sys->delete();
                });
            }
        });

        return redirect()->route('dashboard.packages')->with('success', 'تم التعديل بنجاح');
    }

    private function validateFull(Request $request): array
    {
        return $request->validate([
            'slug' => ['nullable', 'string', 'max:255'],
            'title.ar' => ['required', 'string', 'max:255'],
            'title.en' => ['required', 'string', 'max:255'],
            'desc.ar'  => ['required', 'string'],
            'desc.en'  => ['required', 'string'],
            'note.ar'  => ['nullable', 'string'],
            'note.en'  => ['nullable', 'string'],

            'benefits' => ['array'],
            'benefits.*.number' => ['nullable', 'string', 'max:50'],
            'benefits.*.label.ar' => ['required', 'string', 'max:255'],
            'benefits.*.label.en' => ['required', 'string', 'max:255'],

            'systems' => ['array'],
            'systems.*.slug' => ['nullable', 'string', 'max:255'],
            'systems.*.title.ar' => ['required', 'string', 'max:255'],
            'systems.*.title.en' => ['required', 'string', 'max:255'],
            'systems.*.description.ar' => ['nullable', 'string'],
            'systems.*.description.en' => ['nullable', 'string'],
            'systems.*.icon' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'systems.*.image1' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:4096'],
            'systems.*.image2' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:4096'],
            'systems.*.video' => ['nullable', 'file', 'mimes:mp4,avi,mov,wmv,flv,webm', 'max:20480'], // 20MB max for video
            'systems.*.features' => ['array'],
            'systems.*.features.*.title.ar' => ['required', 'string', 'max:255'],
            'systems.*.features.*.title.en' => ['required', 'string', 'max:255'],
        ]);
    }

    public function preview_packages($id)
    {
        $systems = System::all();
        $package = Package::find($id);

        return view('dashboard.packages.preview', compact('id', 'systems', 'package'));
    }

    public function get_all_packages(Request $request)
    {
        if ($request->ajax()) {
            $data = Package::orderBy('id', 'desc');
            return Datatables::of($data)

                ->addIndexColumn()

                // ->editColumn('name', function ($data) {
                //     return '<span style="color:black">'.$data->name.'</span>';
                // })


                ->addColumn('features', function ($data) {
                    $package_features = PackageFeature::where('package_id', $data->id)->count();

                    return '<a href="' . route('dashboard.packages_features', $data->id) . '" class="levels-link btn-link">' . $package_features . '</a>';
                })

                ->addColumn('systems', function ($data) {
                    $systems_count = PackageSystem::where('package_id', $data->id)->count();

                    return '<a href="' . route('dashboard.systems', $data->id) . '" class="levels-link btn-link">' . $systems_count . '</a>';
                })

                ->addColumn('package_spec', function ($data) {
                    $package_spec = PackageSpec::where('package_id', $data->id)->count();

                    return '<a href="' . route('dashboard.package_spec', $data->id) . '" class="levels-link btn-link">' . $package_spec . '</a>';
                })

                ->addColumn('action', function ($data) {
                    return view('dashboard.packages.btn.action', compact('data'))->render();
                })

                ->rawColumns(['features', 'systems', 'package_spec', 'action'])

                ->make(true);
        }
    }



    public function store_packages(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'title_ar' => 'required|string|max:255',
                    'title_en' => 'required|string|max:255',
                    'desc_ar'  => 'required|string',
                    'desc_en'  => 'required|string',
                    'note_ar'  => 'required|string',
                    'note_en'  => 'required|string',
                ],
                [
                    'title_ar.required' => 'العنوان بالعربية مطلوب',
                    'title_en.required' => 'العنوان بالإنجليزية مطلوب',
                    'desc_ar.required'  => 'الوصف بالعربية مطلوب',
                    'desc_en.required'  => 'الوصف بالإنجليزية مطلوب',
                    'note_ar.required'  => 'الملاحظة بالعربية مطلوبة',
                    'note_en.required'  => 'الملاحظة بالإنجليزية مطلوبة',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages()
                ], 422);
            }

            $package = new Package();
            // Preserve legacy columns while also setting translatable fields if present
            $package->title_ar = $request->title_ar;
            $package->title_en = $request->title_en;
            $package->desc_ar  = $request->desc_ar;
            $package->desc_en  = $request->desc_en;
            $package->note_ar  = $request->note_ar;
            $package->note_en  = $request->note_en;

            if (method_exists($package, 'setTranslations')) {
                $package->setTranslations('title', ['ar' => $request->title_ar, 'en' => $request->title_en]);
                $package->setTranslations('desc',  ['ar' => $request->desc_ar,  'en' => $request->desc_en]);
                $package->setTranslations('note',  ['ar' => $request->note_ar,  'en' => $request->note_en]);
            }

            $package->save();

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

    public function update_packages(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'title_ar' => 'required|string|max:255',
                    'title_en' => 'required|string|max:255',
                    'desc_ar'  => 'required|string',
                    'desc_en'  => 'required|string',
                    'note_ar'  => 'required|string',
                    'note_en'  => 'required|string',
                ],
                [
                    'title_ar.required' => 'العنوان بالعربية مطلوب',
                    'title_en.required' => 'العنوان بالإنجليزية مطلوب',
                    'desc_ar.required'  => 'الوصف بالعربية مطلوب',
                    'desc_en.required'  => 'الوصف بالإنجليزية مطلوب',
                    'note_ar.required'  => 'الملاحظة بالعربية مطلوبة',
                    'note_en.required'  => 'الملاحظة بالإنجليزية مطلوبة',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages()
                ], 422);
            }

            $package = Package::findOrFail($request->id);

            $package->title_ar = $request->title_ar;
            $package->title_en = $request->title_en;
            $package->desc_ar  = $request->desc_ar;
            $package->desc_en  = $request->desc_en;
            $package->note_ar  = $request->note_ar;
            $package->note_en  = $request->note_en;

            if (method_exists($package, 'setTranslations')) {
                $package->setTranslations('title', ['ar' => $request->title_ar, 'en' => $request->title_en]);
                $package->setTranslations('desc',  ['ar' => $request->desc_ar,  'en' => $request->desc_en]);
                $package->setTranslations('note',  ['ar' => $request->note_ar,  'en' => $request->note_en]);
            }

            $package->save();

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


    public function destroy_packages(Request $request)
    {

        try {

            $package = Package::find($request->id);
            $package->delete();
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
    public function destroy_systems_for_package(Request $request)
    {

        try {

            $package = PackageSystem::where('package_id', $request->package_id)->where('system_id', $request->id)->first();
            $package->delete();
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
