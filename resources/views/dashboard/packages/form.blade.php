@extends('layouts.main_page')

@section('css')
    <style>
        .system-block {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 15px !important;
            margin-bottom: 20px !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border: 1px solid #e9e9e9 !important;
        }

        .system-block h6 {
            font-weight: bold;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
        }

        .benefit-item,
        .feature-item {
            background-color: #fff;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 10px !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .custom-file-container {
            position: relative;
        }

        .media-preview {
            padding: 10px;
            border: 1px dashed #ddd;
            border-radius: 4px;
            background-color: #fff;
        }

        .video-info {
            background-color: #f5f5f5;
            padding: 8px;
            border-radius: 4px;
        }

        /* Improved buttons */
        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }

        /* Remove button for media items */
        .remove-media {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            width: 20px;
            height: 20px;
            text-align: center;
            line-height: 20px;
            cursor: pointer;
            color: #dc3545;
        }
    </style>
@endsection

@section('content')
    <div class="breadcrumb-wrapper">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">لوحة التحكم</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard.packages') }}">الباقات</a></li>
            <li class="breadcrumb-item active">{{ isset($package) ? 'تعديل' : 'إضافة' }}</li>
        </ol>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                {{ isset($package) ? 'تعديل باقة: ' . $package->getTranslation('title', 'ar') : 'إضافة باقة جديدة' }}</h4>
        </div>
        <div class="card-body">
            <form method="POST"
                action="{{ isset($package) ? route('dashboard.packages.updateFull', $package->id) : route('dashboard.packages.storeFull') }}"
                enctype="multipart/form-data">
                @csrf
                @if (isset($package))
                    @method('PUT')
                @endif

                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">معلومات الباقة الأساسية</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Slug (معرف الباقة)</label>
                                    <input type="text" name="slug" class="form-control"
                                        value="{{ old('slug', $package->slug ?? '') }}"
                                        placeholder="سيتم إنشاء معرف تلقائي إذا تركته فارغًا">
                                    <small class="form-text text-muted">يستخدم في روابط URL (اختياري)</small>
                                </div>
                            </div>
                            <div class="col-md-6"></div>

                            <div class="col-md-6 mt-1">
                                <div class="form-group">
                                    <label>العنوان (ar) <span class="text-danger">*</span></label>
                                    <input type="text" name="title[ar]" class="form-control"
                                        value="{{ old('title.ar', isset($package) ? $package->getTranslation('title', 'ar') : '') }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6 mt-1">
                                <div class="form-group">
                                    <label>Title (en) <span class="text-danger">*</span></label>
                                    <input type="text" name="title[en]" class="form-control"
                                        value="{{ old('title.en', isset($package) ? $package->getTranslation('title', 'en') : '') }}"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-6 mt-1">
                                <div class="form-group">
                                    <label>الوصف (ar) <span class="text-danger">*</span></label>
                                    <textarea name="desc[ar]" class="form-control" rows="3" required>{{ old('desc.ar', isset($package) ? $package->getTranslation('desc', 'ar') : '') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6 mt-1">
                                <div class="form-group">
                                    <label>Description (en) <span class="text-danger">*</span></label>
                                    <textarea name="desc[en]" class="form-control" rows="3" required>{{ old('desc.en', isset($package) ? $package->getTranslation('desc', 'en') : '') }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6 mt-1">
                                <div class="form-group">
                                    <label>ملاحظة (ar)</label>
                                    <input type="text" name="note[ar]" class="form-control"
                                        value="{{ old('note.ar', isset($package) ? $package->getTranslation('note', 'ar') : '') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mt-1">
                                <div class="form-group">
                                    <label>Note (en)</label>
                                    <input type="text" name="note[en]" class="form-control"
                                        value="{{ old('note.en', isset($package) ? $package->getTranslation('note', 'en') : '') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">المنافع والمميزات</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">أضف المنافع والمميزات التي تقدمها هذه الباقة للعملاء</p>
                        <div id="benefits-wrapper">
                            @php $benefitsOld = old('benefits', isset($package) ? $package->benefits->map(fn($b)=>['number'=>$b->number,'label'=>['ar'=>$b->getTranslation('label','ar'),'en'=>$b->getTranslation('label','en')]])->toArray() : [[]]); @endphp
                            @foreach ($benefitsOld as $idx => $b)
                                <div class="row align-items-end benefit-item mb-1">
                                    <div class="col-md-2">
                                        <div class="form-group mb-0">
                                            <label>الرقم/النسبة</label>
                                            <input class="form-control" name="benefits[{{ $idx }}][number]"
                                                value="{{ $b['number'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-0">
                                            <label>النص (ar) <span class="text-danger">*</span></label>
                                            <input class="form-control" name="benefits[{{ $idx }}][label][ar]"
                                                value="{{ $b['label']['ar'] ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-0">
                                            <label>Label (en) <span class="text-danger">*</span></label>
                                            <input class="form-control" name="benefits[{{ $idx }}][label][en]"
                                                value="{{ $b['label']['en'] ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-sm btn-outline-danger mt-4"
                                            onclick="this.closest('.benefit-item').remove()">
                                            <i class="fa fa-trash"></i> حذف
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-primary mt-2" onclick="addBenefit()">
                            <i class="fa fa-plus"></i> إضافة منفعة جديدة
                        </button>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">أنظمة الباقة</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">أضف الأنظمة المتكاملة التي تتضمنها هذه الباقة مع وسائط العرض الخاصة بكل نظام</p>
                        <div id="systems-wrapper">
                            @php
                                $systemsOld = old(
                                    'systems',
                                    isset($package)
                                        ? $package->systems
                                            ->map(function ($s) {
                                                return [
                                                    'slug' => $s->slug,
                                                    'title' => [
                                                        'ar' => $s->getTranslation('title', 'ar'),
                                                        'en' => $s->getTranslation('title', 'en'),
                                                    ],
                                                    'description' => [
                                                        'ar' => $s->getTranslation('description', 'ar'),
                                                        'en' => $s->getTranslation('description', 'en'),
                                                    ],
                                                    'features' => $s->features
                                                        ->map(
                                                            fn($f) => [
                                                                'title' => [
                                                                    'ar' => $f->getTranslation('title', 'ar'),
                                                                    'en' => $f->getTranslation('title', 'en'),
                                                                ],
                                                            ],
                                                        )
                                                        ->toArray(),
                                                ];
                                            })
                                            ->toArray()
                                        : [[]],
                                );
                            @endphp
                            @foreach ($systemsOld as $sIdx => $s)
                                <div class="system-block border p-1 mb-1">
                                    <div class="row">
                                        <div class="col-md-3"><label>Slug</label><input class="form-control"
                                                name="systems[{{ $sIdx }}][slug]"
                                                value="{{ $s['slug'] ?? '' }}"></div>
                                        <div class="col-md-4"><label>العنوان (ar)</label><input class="form-control"
                                                name="systems[{{ $sIdx }}][title][ar]"
                                                value="{{ $s['title']['ar'] ?? '' }}"></div>
                                        <div class="col-md-5"><label>Title (en)</label><input class="form-control"
                                                name="systems[{{ $sIdx }}][title][en]"
                                                value="{{ $s['title']['en'] ?? '' }}"></div>
                                        <div class="col-md-6 mt-1"><label>الوصف (ar)</label>
                                            <textarea class="form-control" name="systems[{{ $sIdx }}][description][ar]">{{ $s['description']['ar'] ?? '' }}</textarea>
                                        </div>
                                        <div class="col-md-6 mt-1"><label>Description (en)</label>
                                            <textarea class="form-control" name="systems[{{ $sIdx }}][description][en]">{{ $s['description']['en'] ?? '' }}</textarea>
                                        </div>
                                        <div class="col-md-6 mt-1">
                                            <label>الأيقونة</label>
                                            <div class="custom-file-container">
                                                <input type="file" class="form-control"
                                                    name="systems[{{ $sIdx }}][icon]" accept="image/*"
                                                    id="icon-{{ $sIdx }}">
                                                @if (isset($package) && $package->systems->get($sIdx) && $package->systems->get($sIdx)->getFirstMedia('icon'))
                                                    <div class="media-preview mt-2">
                                                        <img src="{{ $package->systems->get($sIdx)->getFirstMedia('icon')->getUrl() }}"
                                                            class="img-thumbnail" style="max-height: 100px;">
                                                        <small class="d-block text-muted">الأيقونة الحالية:
                                                            {{ $package->systems->get($sIdx)->getFirstMedia('icon')->name }}</small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-1">
                                            <label>الصورة الأولى</label>
                                            <div class="custom-file-container">
                                                <input type="file" class="form-control"
                                                    name="systems[{{ $sIdx }}][image1]" accept="image/*"
                                                    id="image1-{{ $sIdx }}">
                                                @if (isset($package) && $package->systems->get($sIdx) && $package->systems->get($sIdx)->getFirstMedia('image1'))
                                                    <div class="media-preview mt-2">
                                                        <img src="{{ $package->systems->get($sIdx)->getFirstMedia('image1')->getUrl() }}"
                                                            class="img-thumbnail" style="max-height: 100px;">
                                                        <small class="d-block text-muted">الصورة الحالية:
                                                            {{ $package->systems->get($sIdx)->getFirstMedia('image1')->name }}</small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-1">
                                            <label>الصورة الثانية</label>
                                            <div class="custom-file-container">
                                                <input type="file" class="form-control"
                                                    name="systems[{{ $sIdx }}][image2]" accept="image/*"
                                                    id="image2-{{ $sIdx }}">
                                                @if (isset($package) && $package->systems->get($sIdx) && $package->systems->get($sIdx)->getFirstMedia('image2'))
                                                    <div class="media-preview mt-2">
                                                        <img src="{{ $package->systems->get($sIdx)->getFirstMedia('image2')->getUrl() }}"
                                                            class="img-thumbnail" style="max-height: 100px;">
                                                        <small class="d-block text-muted">الصورة الحالية:
                                                            {{ $package->systems->get($sIdx)->getFirstMedia('image2')->name }}</small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-1">
                                            <label>الفيديو</label>
                                            <div class="custom-file-container">
                                                <input type="file" class="form-control"
                                                    name="systems[{{ $sIdx }}][video]" accept="video/*"
                                                    id="video-{{ $sIdx }}">
                                                @if (isset($package) && $package->systems->get($sIdx) && $package->systems->get($sIdx)->getFirstMedia('video'))
                                                    <div class="media-preview mt-2">
                                                        <div class="video-info d-flex align-items-center">
                                                            <i class="fa fa-film mr-2" style="font-size: 24px;"></i>
                                                            <small class="text-muted">الفيديو الحالي:
                                                                {{ $package->systems->get($sIdx)->getFirstMedia('video')->name }}</small>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-1">
                                        <h6>الخصائص</h6>
                                        <div class="features-wrapper">
                                            @php $features = $s['features'] ?? [[]]; @endphp
                                            @foreach ($features as $fIdx => $f)
                                                <div class="row align-items-end feature-item mb-1">
                                                    <div class="col-md-6"><label>النص (ar)</label><input
                                                            class="form-control"
                                                            name="systems[{{ $sIdx }}][features][{{ $fIdx }}][title][ar]"
                                                            value="{{ $f['title']['ar'] ?? '' }}"></div>
                                                    <div class="col-md-6"><label>Label (en)</label><input
                                                            class="form-control"
                                                            name="systems[{{ $sIdx }}][features][{{ $fIdx }}][title][en]"
                                                            value="{{ $f['title']['en'] ?? '' }}"></div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                            onclick="addFeature(this, {{ $sIdx }})">+ إضافة خاصية</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-secondary" onclick="addSystem()">+ إضافة
                            نظام</button>

                        <div class="mt-4 text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fa fa-save"></i> {{ isset($package) ? 'حفظ التعديلات' : 'إنشاء الباقة' }}
                            </button>
                            <a href="{{ route('dashboard.packages') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fa fa-times"></i> إلغاء
                            </a>
                        </div>
            </form>
        </div>
    </div>

    <script>
        let benefitIndex = document.querySelectorAll('#benefits-wrapper .benefit-item').length;

        function addBenefit() {
            const wrap = document.getElementById('benefits-wrapper');
            const div = document.createElement('div');
            div.className = 'row align-items-end benefit-item mb-1';
            div.innerHTML = `
        <div class="col-md-2">
            <div class="form-group mb-0">
                <label>الرقم/النسبة</label>
                <input class="form-control" name="benefits[${benefitIndex}][number]">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group mb-0">
                <label>النص (ar) <span class="text-danger">*</span></label>
                <input class="form-control" name="benefits[${benefitIndex}][label][ar]" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group mb-0">
                <label>Label (en) <span class="text-danger">*</span></label>
                <input class="form-control" name="benefits[${benefitIndex}][label][en]" required>
            </div>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-sm btn-outline-danger mt-4" onclick="this.closest('.benefit-item').remove()">
                <i class="fa fa-trash"></i> حذف
            </button>
        </div>
    `;
            wrap.appendChild(div);
            benefitIndex++;
        }

        let systemIndex = document.querySelectorAll('#systems-wrapper .system-block').length;

        function addSystem() {
            const wrap = document.getElementById('systems-wrapper');
            const block = document.createElement('div');
            block.className = 'system-block mb-4';
            block.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">نظام جديد</h5>
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.system-block').remove()">
                <i class="fa fa-trash"></i> حذف النظام
            </button>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Slug</label>
                    <input class="form-control" name="systems[${systemIndex}][slug]" placeholder="معرف النظام (اختياري)">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>العنوان (ar) <span class="text-danger">*</span></label>
                    <input class="form-control" name="systems[${systemIndex}][title][ar]" required>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label>Title (en) <span class="text-danger">*</span></label>
                    <input class="form-control" name="systems[${systemIndex}][title][en]" required>
                </div>
            </div>
            <div class="col-md-6 mt-1">
                <div class="form-group">
                    <label>الوصف (ar)</label>
                    <textarea class="form-control" name="systems[${systemIndex}][description][ar]" rows="3"></textarea>
                </div>
            </div>
            <div class="col-md-6 mt-1">
                <div class="form-group">
                    <label>Description (en)</label>
                    <textarea class="form-control" name="systems[${systemIndex}][description][en]" rows="3"></textarea>
                </div>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-12">
                <h6 class="mb-3">وسائط العرض</h6>
            </div>
            <div class="col-md-6 mt-1">
                <div class="form-group">
                    <label>الأيقونة <small class="text-muted">(مطلوبة للعرض في الموقع)</small></label>
                    <div class="custom-file-container">
                        <input type="file" class="form-control" name="systems[${systemIndex}][icon]" accept="image/*" id="icon-${systemIndex}">
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-1">
                <div class="form-group">
                    <label>الصورة الأولى</label>
                    <div class="custom-file-container">
                        <input type="file" class="form-control" name="systems[${systemIndex}][image1]" accept="image/*" id="image1-${systemIndex}">
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-1">
                <div class="form-group">
                    <label>الصورة الثانية</label>
                    <div class="custom-file-container">
                        <input type="file" class="form-control" name="systems[${systemIndex}][image2]" accept="image/*" id="image2-${systemIndex}">
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-1">
                <div class="form-group">
                    <label>الفيديو</label>
                    <div class="custom-file-container">
                        <input type="file" class="form-control" name="systems[${systemIndex}][video]" accept="video/*" id="video-${systemIndex}">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-3">
            <h6 class="mb-2">خصائص النظام</h6>
            <div class="features-wrapper"></div>
            <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addFeature(this, ${systemIndex})">
                <i class="fa fa-plus"></i> إضافة خاصية
            </button>
        </div>`;
            wrap.appendChild(block);
            systemIndex++;
        }

        function addFeature(btn, idx) {
            const wrap = btn.parentElement.querySelector('.features-wrapper');
            const count = wrap.querySelectorAll('.feature-item').length;
            const row = document.createElement('div');
            row.className = 'row align-items-end feature-item mb-1';
            row.innerHTML = `
        <div class="col-md-5">
            <div class="form-group mb-0">
                <label>النص (ar) <span class="text-danger">*</span></label>
                <input class="form-control" name="systems[${idx}][features][${count}][title][ar]" required>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group mb-0">
                <label>Label (en) <span class="text-danger">*</span></label>
                <input class="form-control" name="systems[${idx}][features][${count}][title][en]" required>
            </div>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.feature-item').remove()">
                <i class="fa fa-times"></i> حذف
            </button>
        </div>
    `;
            wrap.appendChild(row);
        }
    </script>
@endsection
