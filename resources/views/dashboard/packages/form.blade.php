@extends('layouts.main_page')

@section('content')
    <div class="breadcrumb-wrapper">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">لوحة التحكم</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard.packages') }}">الباقات</a></li>
            <li class="breadcrumb-item active">{{ isset($package) ? 'تعديل' : 'إضافة' }}</li>
        </ol>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST"
                action="{{ isset($package) ? route('dashboard.packages.updateFull', $package->id) : route('dashboard.packages.storeFull') }}"
                enctype="multipart/form-data">
                @csrf
                @if (isset($package))
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <label>Slug</label>
                        <input type="text" name="slug" class="form-control"
                            value="{{ old('slug', $package->slug ?? '') }}">
                    </div>
                    <div class="col-md-6"></div>

                    <div class="col-md-6 mt-1">
                        <label>العنوان (ar)</label>
                        <input type="text" name="title[ar]" class="form-control"
                            value="{{ old('title.ar', isset($package) ? $package->getTranslation('title', 'ar') : '') }}">
                    </div>
                    <div class="col-md-6 mt-1">
                        <label>Title (en)</label>
                        <input type="text" name="title[en]" class="form-control"
                            value="{{ old('title.en', isset($package) ? $package->getTranslation('title', 'en') : '') }}">
                    </div>

                    <div class="col-md-6 mt-1">
                        <label>الوصف (ar)</label>
                        <textarea name="desc[ar]" class="form-control">{{ old('desc.ar', isset($package) ? $package->getTranslation('desc', 'ar') : '') }}</textarea>
                    </div>
                    <div class="col-md-6 mt-1">
                        <label>Description (en)</label>
                        <textarea name="desc[en]" class="form-control">{{ old('desc.en', isset($package) ? $package->getTranslation('desc', 'en') : '') }}</textarea>
                    </div>

                    <div class="col-md-6 mt-1">
                        <label>ملاحظة (ar)</label>
                        <input type="text" name="note[ar]" class="form-control"
                            value="{{ old('note.ar', isset($package) ? $package->getTranslation('note', 'ar') : '') }}">
                    </div>
                    <div class="col-md-6 mt-1">
                        <label>Note (en)</label>
                        <input type="text" name="note[en]" class="form-control"
                            value="{{ old('note.en', isset($package) ? $package->getTranslation('note', 'en') : '') }}">
                    </div>
                </div>

                <hr>
                <h4>المنافع</h4>
                <div id="benefits-wrapper">
                    @php $benefitsOld = old('benefits', isset($package) ? $package->benefits->map(fn($b)=>['number'=>$b->number,'label'=>['ar'=>$b->getTranslation('label','ar'),'en'=>$b->getTranslation('label','en')]])->toArray() : [[]]); @endphp
                    @foreach ($benefitsOld as $idx => $b)
                        <div class="row align-items-end benefit-item mb-1">
                            <div class="col-md-2"><label>الرقم/النسبة</label><input class="form-control"
                                    name="benefits[{{ $idx }}][number]" value="{{ $b['number'] ?? '' }}"></div>
                            <div class="col-md-5"><label>النص (ar)</label><input class="form-control"
                                    name="benefits[{{ $idx }}][label][ar]" value="{{ $b['label']['ar'] ?? '' }}">
                            </div>
                            <div class="col-md-5"><label>Label (en)</label><input class="form-control"
                                    name="benefits[{{ $idx }}][label][en]" value="{{ $b['label']['en'] ?? '' }}">
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-sm btn-secondary" onclick="addBenefit()">+ إضافة منفعة</button>

                <hr>
                <h4>أنظمة الباقة</h4>
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
                                        name="systems[{{ $sIdx }}][slug]" value="{{ $s['slug'] ?? '' }}"></div>
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
                                <div class="col-md-12 mt-1"><label>الصور</label><input type="file" class="form-control"
                                        name="systems[{{ $sIdx }}][images][]" multiple></div>
                            </div>

                            <div class="mt-1">
                                <h6>الخصائص</h6>
                                <div class="features-wrapper">
                                    @php $features = $s['features'] ?? [[]]; @endphp
                                    @foreach ($features as $fIdx => $f)
                                        <div class="row align-items-end feature-item mb-1">
                                            <div class="col-md-6"><label>النص (ar)</label><input class="form-control"
                                                    name="systems[{{ $sIdx }}][features][{{ $fIdx }}][title][ar]"
                                                    value="{{ $f['title']['ar'] ?? '' }}"></div>
                                            <div class="col-md-6"><label>Label (en)</label><input class="form-control"
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
                <button type="button" class="btn btn-sm btn-secondary" onclick="addSystem()">+ إضافة نظام</button>

                <div class="mt-2">
                    <button type="submit" class="btn btn-primary">حفظ</button>
                    <a href="{{ route('dashboard.packages') }}" class="btn btn-outline-secondary">إلغاء</a>
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
        <div class="col-md-2"><label>الرقم/النسبة</label><input class="form-control" name="benefits[${benefitIndex}][number]"></div>
        <div class="col-md-5"><label>النص (ar)</label><input class="form-control" name="benefits[${benefitIndex}][label][ar]"></div>
        <div class="col-md-5"><label>Label (en)</label><input class="form-control" name="benefits[${benefitIndex}][label][en]"></div>
    `;
            wrap.appendChild(div);
            benefitIndex++;
        }

        let systemIndex = document.querySelectorAll('#systems-wrapper .system-block').length;

        function addSystem() {
            const wrap = document.getElementById('systems-wrapper');
            const block = document.createElement('div');
            block.className = 'system-block border p-1 mb-1';
            block.innerHTML = `
        <div class="row">
            <div class="col-md-3"><label>Slug</label><input class="form-control" name="systems[${systemIndex}][slug]"></div>
            <div class="col-md-4"><label>العنوان (ar)</label><input class="form-control" name="systems[${systemIndex}][title][ar]"></div>
            <div class="col-md-5"><label>Title (en)</label><input class="form-control" name="systems[${systemIndex}][title][en]"></div>
            <div class="col-md-6 mt-1"><label>الوصف (ar)</label><textarea class="form-control" name="systems[${systemIndex}][description][ar]"></textarea></div>
            <div class="col-md-6 mt-1"><label>Description (en)</label><textarea class="form-control" name="systems[${systemIndex}][description][en]"></textarea></div>
            <div class="col-md-12 mt-1"><label>الصور</label><input type="file" class="form-control" name="systems[${systemIndex}][images][]" multiple></div>
        </div>
        <div class="mt-1">
            <h6>الخصائص</h6>
            <div class="features-wrapper"></div>
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addFeature(this, ${systemIndex})">+ إضافة خاصية</button>
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
        <div class="col-md-6"><label>النص (ar)</label><input class="form-control" name="systems[${idx}][features][${count}][title][ar]"></div>
        <div class="col-md-6"><label>Label (en)</label><input class="form-control" name="systems[${idx}][features][${count}][title][en]"></div>
    `;
            wrap.appendChild(row);
        }
    </script>
@endsection
