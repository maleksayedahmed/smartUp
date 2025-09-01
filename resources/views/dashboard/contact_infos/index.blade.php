@extends('layouts.main_page')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/rowGroup.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/plugins/extensions/ext-component-sweet-alerts.css')}}">
    <script src="{{asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8 col-md-10 col-sm-12 mx-auto">
        <div class="card">
            <div class="card-header text-white">
                <h4 class="mb-0" style="color:black">معلومات التواصل</h4>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex align-items-center">
                        <i data-feather="phone" class="mr-1 text-primary"></i>
                        <strong class="mr-2">الموبايل:</strong> {{ $contact_infos->mobile }}
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <i data-feather="mail" class="mr-1 text-primary"></i>
                        <strong class="mr-2">الإيميل:</strong> {{ $contact_infos->email }}
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <i data-feather="facebook" class="mr-1 text-primary"></i>
                        <strong class="mr-2">فيس بوك:</strong> {{ $contact_infos->facebook }}
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <i data-feather="instagram" class="mr-1 text-primary"></i>
                        <strong class="mr-2">انستجرام:</strong> {{ $contact_infos->instagram }}
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <i data-feather="film" class="mr-1 text-primary"></i>
                        <strong class="mr-2">تيك توك:</strong> {{ $contact_infos->tiktok }}
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <i data-feather="youtube" class="mr-1 text-primary"></i>
                        <strong class="mr-2">يوتيوب:</strong> {{ $contact_infos->youtube }}
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <i data-feather="message-circle" class="mr-1 text-primary"></i>
                        <strong class="mr-2">واتساب:</strong> {{ $contact_infos->whatsapp }}
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <i data-feather="linkedin" class="mr-1 text-primary"></i>
                        <strong class="mr-2">لينكد إن:</strong> {{ $contact_infos->linkedin }}
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <i data-feather="twitter" class="mr-1 text-primary"></i>
                        <strong class="mr-2">X:</strong> {{ $contact_infos->X }}
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <i data-feather="map-pin" class="mr-1 text-primary"></i>
                        <strong class="mr-2">العنوان:</strong> {{ $contact_infos->address }}
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <i data-feather="image" class="mr-1 text-primary"></i>
                        <strong class="mr-2">الشعار:</strong>
                        <img src="{{ asset($contact_infos->logo) }}" alt="Logo" height="40">
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <i data-feather="globe" class="mr-1 text-primary"></i>
                        <strong class="mr-2">اسم الموقع:</strong> {{ $contact_infos->site_name }}
                    </li>
                        <li class="list-group-item d-flex align-items-center">
                        <i data-feather="snapchat" class="mr-1 text-primary"></i>
                        <strong class="mr-2">سناب شات:</strong> {{ $contact_infos->snapchat }}
                    </li>
                </ul>

                <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#edit_user">
                    <i data-feather="edit"></i> تعديل
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="form-modal-ex">
    <div class="modal fade text-left" id="edit_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">تعديل معلومات التواصل</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <div aria-hidden="true">&times;</div>
                    </button>
                </div>
                <form id="edit_user_form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $contact_infos->id }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label>موبايل</label>
                                <div class="form-group">
                                    <input type="text" name="mobile" value="{{ $contact_infos->mobile }}" class="form-control" />
                                    <span id="mobile_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>ايميل</label>
                                <div class="form-group">
                                    <input type="text" name="email" value="{{ $contact_infos->email }}" class="form-control" />
                                    <span id="email_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>فيس بوك</label>
                                <div class="form-group">
                                    <input type="text" name="facebook" value="{{ $contact_infos->facebook }}" class="form-control" />
                                    <span id="facebook_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>انستجرام</label>
                                <div class="form-group">
                                    <input type="text" name="instagram" value="{{ $contact_infos->instagram }}" class="form-control" />
                                    <span id="instagram_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>تيك توك</label>
                                <div class="form-group">
                                    <input type="text" name="tiktok" value="{{ $contact_infos->tiktok }}" class="form-control" />
                                    <span id="tiktok_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>يوتيوب</label>
                                <div class="form-group">
                                    <input type="text" name="youtube" value="{{ $contact_infos->youtube }}" class="form-control" />
                                    <span id="youtube_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>واتساب</label>
                                <div class="form-group">
                                    <input type="text" name="whatsapp" value="{{ $contact_infos->whatsapp }}" class="form-control" />
                                    <span id="whatsapp_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>سناب شات</label>
                                <div class="form-group">
                                    <input type="text" name="snapchat" value="{{ $contact_infos->snapchat }}" class="form-control" />
                                    <span id="snapchat_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>لينكيد ان</label>
                                <div class="form-group">
                                    <input type="text" name="linkedin" value="{{ $contact_infos->linkedin }}" class="form-control" />
                                    <span id="linkedin_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>X</label>
                                <div class="form-group">
                                    <input type="text" name="X" value="{{ $contact_infos->X }}" class="form-control" />
                                    <span id="X_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>العنوان</label>
                                <div class="form-group">
                                    <input type="text" name="address" value="{{ $contact_infos->address }}" class="form-control" />
                                    <span id="address_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>الشعار</label>
                                <div class="form-group">
                                    <input type="file" name="logo" id="change-picture" class="form-control" />
                                    <span id="logo_error" class="text-danger"></span>
                                    <img src="{{ asset($contact_infos->logo) }}" id="image" style="width: 100px; height: 100px; margin-top: 10px;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>اسم الموقع</label>
                                <div class="form-group">
                                    <input type="text" name="site_name" value="{{ $contact_infos->site_name }}" class="form-control" />
                                    <span id="site_name_error" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="editing_loader" class="btn btn-primary btn-block"> يتم التعديل ...</button>
                        <button type="button" id="editing_btn" onclick="do_update()" class="btn btn-primary btn-block">حفظ التعديلات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="{{asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/extensions/ext-component-sweet-alerts.js')}}"></script>

    <script>
        // Preview image before upload
        $(function () {
            $('#change-picture').on('change', function (e) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#image').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        });

        function msg_edit(){
            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: 'تم التعديل بنجاح',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            });
        }

function do_update() {
    // Reset error messages
    $('.text-danger').text('');

    // Show loader and hide button
    $("#editing_btn").hide();
    $("#editing_loader").show();

    var formData = new FormData($('#edit_user_form')[0]);

    $.ajax({
        type: 'POST',
        enctype: 'multipart/form-data',
        url: "{{ route('dashboard.update_contact_infos') }}",
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        success: function (response) {
            if(response.status) {
                // إغلاق المودال
                $('#edit_user').modal('hide');

                // عرض رسالة نجاح
                Swal.fire({
                    position: 'top-start',
                    icon: 'success',
                    title: response.msg,
                    showConfirmButton: false,
                    timer: 1500
                });

                // تحديث الصفحة بعد 1.5 ثانية
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else {
                // عرض رسالة خطأ إذا فشل التعديل
                Swal.fire({
                    position: 'top-start',
                    icon: 'error',
                    title: response.msg,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        },
        error: function (reject) {
            $("#editing_btn").show();
            $("#editing_loader").hide();

            var response = $.parseJSON(reject.responseText);
            $.each(response.errors, function (key, val) {
                $("#" + key + "_error").text(val[0]);
            });
        }
    });
}
    </script>
@endsection
