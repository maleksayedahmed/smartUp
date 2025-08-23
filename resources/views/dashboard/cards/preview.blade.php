@extends('layouts.main_page')

@section('content')
    <div class="breadcrumb-wrapper">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">لوحة التحكم</a></li>
            <li class="breadcrumb-item"><a href="#">عرض التفاصيل</a></li>
        </ol>
    </div>

    <section class="my-4">
        <div class="row justify-content-start">
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <!-- زر الرجوع في أعلى البطاقة -->
                        <div class="d-flex justify-content-start mb-3">
                            <button onclick="history.back()" class="btn btn-light mr-2">
                                <i class="fas fa-arrow-right ml-1"></i> رجوع
                            </button>

                            <!-- زر التعديل -->
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                data-target="#editPreviewCardModal">
                                <i class="fas fa-edit"></i> تعديل
                            </button>

                        </div>

                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h4 class="mb-0 text-primary">{{ $preview_card->title_ar }}</h4>
                                <h4 class="mb-0 text-muted">{{ $preview_card->title_en }}</h4>
                            </div>
                        </div>

                        <div class="border-top pt-3">
                            <p class="mb-2 text-justify">
                                <span class="badge badge-light-primary">الوصف بالعربي</span>
                                {{ $preview_card->desctiption_ar }}
                            </p>
                            <p class="mb-0 text-justify">
                                <span class="badge badge-light-secondary">Description (EN)</span>
                                {{ $preview_card->desctiption_en }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- مودال التعديل -->
    <div class="modal fade" id="editPreviewCardModal" tabindex="-1" role="dialog"
        aria-labelledby="editPreviewCardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPreviewCardModalLabel">تعديل البطاقة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editPreviewCardForm" method="POST"
                    action="{{ route('dashboard.preview-cards.update', $preview_card->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_title_ar">العنوان (عربي)</label>
                                    <input type="text" class="form-control" id="edit_title_ar" name="title_ar"
                                        value="{{ $preview_card->title_ar }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_title_en">العنوان (إنجليزي)</label>
                                    <input type="text" class="form-control" id="edit_title_en" name="title_en"
                                        value="{{ $preview_card->title_en }}" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="edit_desctiption_ar">الوصف (عربي)</label>
                                    <textarea class="form-control" id="edit_desctiption_ar" name="desctiption_ar" rows="3" required>{{ $preview_card->desctiption_ar }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="edit_desctiption_en">الوصف (إنجليزي)</label>
                                    <textarea class="form-control" id="edit_desctiption_en" name="desctiption_en" rows="3" required>{{ $preview_card->desctiption_en }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#editPreviewCardForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var submitBtn = form.find('button[type="submit"]');
                var originalBtnText = submitBtn.html();

                submitBtn.prop('disabled', true);
                submitBtn.html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> يتم الحفظ...'
                    );

                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'تم!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                $('#editPreviewCardModal').modal('hide');
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        var response = xhr.responseJSON;
                        var errorMsg = 'حدث خطأ أثناء الحفظ';

                        if (xhr.status === 422) {
                            errorMsg = 'خطأ في التحقق من البيانات';
                            $('.is-invalid').removeClass('is-invalid');
                            $('.invalid-feedback').remove();

                            $.each(response.errors, function(key, value) {
                                $('[name="' + key + '"]').addClass('is-invalid')
                                    .after('<div class="invalid-feedback">' + value[0] +
                                        '</div>');
                            });
                        } else if (response && response.message) {
                            errorMsg = response.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: errorMsg
                        });
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false);
                        submitBtn.html(originalBtnText);
                    }
                });
            });
        });
    </script>
@endsection
