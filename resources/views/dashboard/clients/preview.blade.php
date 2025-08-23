@extends('layouts.main_page')

@section('css')

    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/rowGroup.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/plugins/extensions/ext-component-sweet-alerts.css')}}">



@endsection


@section('content')

{{--
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_add()" id="position-top-start"></button>
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_edit()" id="position-top-start_edit"></button>
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_delete()" id="position-top-start_delete"></button>
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_status()" id="position-top-status"></button> --}}




<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">   لوحة التحكم </a>
        </li>
        <li class="breadcrumb-item"><a href="#">عرض التفاصيل </a>
        </li>
    </ol>
</div>


{{-- @can('اضافة طالب') --}}
{{-- <a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">اضافة</a> --}}
{{-- @endcan --}}

<section>



    <div class="row justify-content-start">

        <div class="col-md-12">

            <div class="card shadow-lg mt-5 border-0">
                <div class=" text-white">
                    <i class="fas fa-user mr-2"></i>
                    <h5 class="mb-0 text-center">معلومات العميل</h5>
                </div>

                <div class="card-body">

                    <div class="row py-2 border-bottom">
                        <div class="col-sm-2 font-weight-bold text-secondary">
                            <i class="fas fa-user-tag mr-1 text-primary"></i> الاسم:
                        </div>
                        <div class="col-sm-8">{{ $preview_client->name }}</div>
                    </div>

                    <div class="row py-2 border-bottom">
                        <div class="col-sm-2 font-weight-bold text-secondary">
                            <i class="fas fa-mobile-alt mr-1 text-primary"></i> رقم الموبايل:
                        </div>
                        <div class="col-sm-8">{{ $preview_client->phone }}</div>
                    </div>

                    <div class="row py-2 border-bottom">
                        <div class="col-sm-2 font-weight-bold text-secondary">
                            <i class="fas fa-envelope mr-1 text-primary"></i> الإيميل:
                        </div>
                        <div class="col-sm-8">{{ $preview_client->email }}</div>
                    </div>

                    <div class="row py-2 border-bottom">
                        <div class="col-sm-2 font-weight-bold text-secondary">
                            <i class="fas fa-heading mr-1 text-primary"></i> الموضوع:
                        </div>
                        <div class="col-sm-8">{{ $preview_client->subject }}</div>
                    </div>

                    <div class="row py-2">
                        <div class="col-sm-2 font-weight-bold text-secondary">
                            <i class="fas fa-comments mr-1 text-primary"></i> الرسالة:
                        </div>
                        <div class="col-sm-8">{{ $preview_client->message }}</div>
                    </div>



                </div>


                <div class="py-2">

                        <div style="margin-x: auto;display: flex; justify-content: center; align-items: center; width: 100%; height: 100%;gap:20px; padding-right: 20%; padding-left: 20%;">



                            <a href="https://api.whatsapp.com/send?phone={{ $preview_client->mobile }}" target="_blank" class="btn btn-success btn-block">
                                <i class="fab fa-whatsapp"></i> إرسال رسالة
                            </a>
                            <a href="tel:{{ $preview_client->mobile }}" target="_blank" class="btn btn-primary btn-block">
                                <i class="fas fa-mobile-alt"></i>  اتصال مباشر
                            </a>



                        </div>


                </div>

                  <div class="card-footer d-flex justify-content-start" >
                    <button onclick="history.back()" class="btn btn-light-primary float-right">
                        <i class="fas fa-arrow-right ml-1"></i> رجوع
                    </button>
                </div>
            </div>

        </div>
    </div>
</section>




 @endsection


@section('js')

    <script src="{{asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>

    <script src="{{asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/extensions/ext-component-sweet-alerts.js')}}"></script>




{{--

    <script>

        function msg_add(){

            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: 'تمت الاضافة بنجاح ',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false

            });

        }

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

        function msg_delete(){

            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: 'تم الحذف بنجاح',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false

            });

          }
        function msg_status(){

            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: 'تم تعديل الحالة بنجاح',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false

            });

          }

    </script>
 --}}
    {{-- defaultContent عشان اذا في بعض الحقول فاضية..ما يرجعلي ايرور من الياجرا داتاتبل وبحطلي بدالها "-" --}}



    {{-- open modal add user --}}
    {{-- <script>
        $('#modal_add').on('show.bs.modal', function(event) {
            $('#city').text('');
            $("#image").attr('src', "{{  env('APP_URL') }}/attachments/downloads/download.png");


        })
    </script> --}}




@endsection
