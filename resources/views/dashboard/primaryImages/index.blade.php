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


 <button class="btn btn-outline-primary" style="display: none" onclick="msg_add()" id="position-top-start"></button>
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_edit()" id="position-top-start_edit"></button>
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_delete()" id="position-top-start_delete"></button>
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_status()" id="position-top-status"></button>




<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">   لوحة التحكم </a>
        </li>
        <li class="breadcrumb-item"><a href="#"> معرض الصور (الرئيسية) </a>
        </li>
    </ol>
</div>


{{-- @can('اضافة طالب') --}}
<a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">اضافة</a>
{{-- @endcan --}}

<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <table class="datatables-basic table table-responsive-md yajra-datatable">
                    <thead>
                        <tr>

                            <th>#</th>
                            <th>الصورة</th>
                            <th>اختيار الصورة الرئيسية</th>
                            <th>العنوان بالعربي</th>
                            <th>العنوان بالانجلش</th>
                            <th>الوصف بالعربي</th>
                            <th>الوصف بالانجلش</th>
                            <th>العمليات</th>


                        </tr>
                    </thead>

                    <tbody>

                    </tbody>

                </table>

            </div>
        </div>
    </div>
    <!-- Modal to add new record -->

</section>


{{-- modal add --}}
<div class="form-modal-ex" id="modal_add">
    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">اضافة صورة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <div aria-hidden="true">&times;</div>
                    </button>
                </div>
                <form id="add_user_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-12">
                                <label> العنوان بالعربي </label>
                                <div class="form-group">
                                    <input type="text"  name="title_ar" id="title_ar" class="form-control" />
                                    <span id="title_ar_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label> العنوان بالانجلش </label>
                                <div class="form-group">
                                    <input type="text"  name="title_en" id="title_en" class="form-control" />
                                    <span id="title_en_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label> الوصف بالعربي </label>
                                <div class="form-group">
                                    <input type="text"  name="description_ar" id="description_ar" class="form-control" />
                                    <span id="description_ar_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label> الوصف بالانجلش </label>
                                <div class="form-group">
                                    <input type="text"  name="description_en" id="description_en" class="form-control" />
                                    <span id="description_en_error" class="text-danger"></span>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="media mb-2">
                                    <img src="" alt="users avatar" id="image" class="user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer" height="90" width="90" />
                                    <div class="media-body mt-50">
                                        <div class="col-12 d-flex mt-1 px-0">
                                            <label class="btn btn-primary mr-75 mb-0" for="change-picture">
                                                <div class="d-none d-sm-block">تغيير الصورة</div>
                                                    <input class="form-control" type="file" multiple id="change-picture" name="image" hidden required accept="image/png, image/jpeg, image/jpg" />
                                                    <span class="d-block d-sm-none">
                                                    <i class="mr-0" data-feather="edit"></i>
                                                </span>
                                            </label>
                                            <button class="btn btn-outline-secondary d-block d-sm-none">
                                                <i class="mr-0" data-feather="trash-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <span id="image_error" class="text-danger"></span>
                                </div>
                            </div>


                        </div>





                    </div>
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="add_user2" class="btn btn-primary btn-block">تتم الاضافة ...</button>
                        <button type="button" id="add_user" class="btn btn-primary btn-block">اضافة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- modal edit --}}
<div class="form-modal-ex">
    <div class="modal fade text-left" id="edit_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">تعديل </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <div aria-hidden="true">&times;</div>
                    </button>
                </div>
                <form id="edit_user_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="id" id="id2">


                            <div class="col-md-12">
                                <label> العنوان بالعربي </label>
                                <div class="form-group">
                                    <input type="text" name="title_ar" id="title_ar2" class="form-control" />
                                    <span id="title_ar2_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label> العنوان بالانجلش </label>
                                <div class="form-group">
                                    <input type="text" name="title_en" id="title_en2" class="form-control" />
                                    <span id="title_en2_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label> الوصف بالعربي </label>
                                <div class="form-group">
                                    <textarea type="text" name="description_ar" id="description_ar2" class="form-control" rows="4"></textarea>
                                    <span id="description_ar2_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label> الوصف بالانجلش </label>
                                <div class="form-group">
                                    <textarea type="text" name="description_en" id="description_en2" class="form-control" rows="4"></textarea>
                                    <span id="description_en2_error" class="text-danger"></span>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="media mb-2">
                                    <img src="" alt="users avatar" id="image2" class="user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer" height="90" width="90" />
                                    <div class="media-body mt-50">
                                        <div class="col-12 d-flex mt-1 px-0">
                                            <label class="btn btn-primary mr-75 mb-0" for="change-picture2">
                                                <div class="d-none d-sm-block">Change</div>
                                                    <input class="form-control" type="file" multiple id="change-picture2" name="image" hidden required accept="image/png, image/jpeg, image/jpg" />
                                                    <span class="d-block d-sm-none">
                                                    <i class="mr-0" data-feather="edit"></i>
                                                </span>
                                            </label>
                                            <button class="btn btn-outline-secondary d-block d-sm-none">
                                                <i class="mr-0" data-feather="trash-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <span id="image_error" class="text-danger"></span>
                                </div>
                            </div>



                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="editing2" class="btn btn-primary btn-block"> يتم التعديل ...</button>
                        <button type="button" id="editing" onclick="do_update()" class="btn btn-primary btn-block">حفظ التعديلات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- delete user --}}
<div class="modal fade modal-danger text-left" id="delete_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel120">حذف </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <div aria-hidden="true">&times;</div>
                </button>
            </div>
            <div class="modal-body">
                <form id="delete_user_form">
                    @csrf
                    <input type="hidden" name="id" id="id3">
                     هل انت متأكد من عملية الحذف ؟
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="delete_user2" style="display: none" data-dismiss="modal">...يتم الحذف</button>
                        <button type="button" class="btn btn-danger" onclick="do_delete()" id="delete_user_button" data-dismiss="modal">تأكيد</button>
                    </div>
                </form>
        </div>
    </div>
</div>


 @endsection


@section('js')
    <script src="{{asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.buttons.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>

    <script src="{{asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/extensions/ext-component-sweet-alerts.js')}}"></script>






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

     {{-- show information in yajradatatable --}}
     <script type="text/javascript">

        $(function () {
        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('dashboard.get_all_primaryImages') }}",
            columns: [
                {data: 'DT_RowIndex'   ,name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'image'         ,name: 'image'},
                {data: 'is_view'       ,name: 'is_view'},
                {data: 'title_ar'      ,name: 'title_ar'},
                {data: 'title_en'      ,name: 'title_en'},
                {data: 'description_ar'      ,name: 'description_ar'},
                {data: 'description_en'      ,name: 'description_en'},
                {data: 'action'        ,name: 'action'},
            ],
            "lengthMenu": [[5,25,50,-1],[5,25,50,'All']],     // page length options
        });
        });
    </script>
    {{-- defaultContent عشان اذا في بعض الحقول فاضية..ما يرجعلي ايرور من الياجرا داتاتبل وبحطلي بدالها "-" --}}



    {{-- open modal add user --}}
    <script>
        $('#modal_add').on('show.bs.modal', function(event) {

            $("#image").attr('src', "{{  env('APP_URL') }}/attachments/downloads/download.png");


        })
    </script>

    <script>
        $(function () {
            'use strict';
            var changePicture = $('#change-picture'),
                userAvatar = $('#image');
            // Change user profile picture
            if (changePicture.length) {
                $(changePicture).on('change', function (e) {
                    var reader = new FileReader(),
                        files = e.target.files;
                    reader.onload = function () {
                        if (userAvatar.length) {
                            userAvatar.attr('src', reader.result);
                        }
                    };
                    reader.readAsDataURL(files[0]);
                });
            }
        });
    </script>

    <script>
        $(function () {
            'use strict';
            var changePicture = $('#change-picture2'),
                userAvatar = $('#image2');
            // Change user profile picture
            if (changePicture.length) {
                $(changePicture).on('change', function (e) {
                    var reader = new FileReader(),
                        files = e.target.files;
                    reader.onload = function () {
                        if (userAvatar.length) {
                            userAvatar.attr('src', reader.result);
                        }
                    };
                    reader.readAsDataURL(files[0]);
                });
            }
        });
    </script>


    {{-- change status --}}
    <script>

        $(document).on('change','#cousome_switch', function (e) {


                let id = $(this).data('id');


                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: '{{ route('dashboard.is_main') }}',

                    data: {
                            '_token':'{{ csrf_token() }}',
                            'id':id,

                        },
                    success: function (data) {

                        // $('#position-top-status').click();
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);
                    }
                });
        });

    </script>


    {{-- add user --}}
    <script>
        $(document).on('click', '#add_user', function (e) {

            $('span').text('');


            $("#add_user2").css("display", "block");
            $("#add_user").css("display", "none");
            var formData = new FormData($('#add_user_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('dashboard.store_primaryImages')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {

                            $('.yajra-datatable').DataTable().ajax.reload(null, false);
                            $("#add_user2").css("display", "none");
                            $("#add_user").css("display", "block");
                            $('.close').click();
                            $('#add_user_form')[0].reset();
                            $("#image").attr('src', "{{  env('APP_URL') }}/attachments/downloads/download.png");
                            $('#change-picture').val('');
                            $('#position-top-start').click();

                    },
                    error: function (reject) {
                        $("#add_user2").css("display", "none");
                        $("#add_user").css("display", "block");
                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function (key, val) {
                            $("#" + key + "_error").text(val[0]);
                        });
                    }
                });
            });
    </script>


    {{-- edit user --}}
    <script>
        $('#edit_user').on('show.bs.modal', function(event) {

            var button = $(event.relatedTarget)
            var id =                  button.data('id')
            var image =               button.data('image')
            var title_ar =               button.data('title_ar')
            var title_en =               button.data('title_en')
            var description_ar =               button.data('description_ar')
            var description_en =               button.data('description_en')



            var modal = $(this)
            modal.find('.modal-body #id2').val(id);
            modal.find('.modal-body #title_ar2').val(title_ar);
            modal.find('.modal-body #title_en2').val(title_en);
            modal.find('.modal-body #description_ar2').val(description_ar);
            modal.find('.modal-body #description_en2').val(description_en);
            $(".modal-body #image2").attr('src', image);

        })
    </script>


   {{-- update user --}}
   <script>
        function do_update(){


            $('span').text('');



            $("#editing").css("display", "none");
            $("#editing2").css("display", "block");

            var formData = new FormData($('#edit_user_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('dashboard.update_primaryImages')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        $("#editing").css("display", "block");
                        $("#editing2").css("display", "none");

                        $('.close').click();
                        $('#change-picture2').val('');
                        $('#position-top-start_edit').click();
                        $("#image").attr('src', "{{  env('APP_URL') }}/attachments/downloads/download.png");
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);

                    }, error: function (reject) {
                            $("#editing").css("display", "block");
                            $("#editing2").css("display", "none");
                            var response = $.parseJSON(reject.responseText);
                            $.each(response.errors, function (key, val) {
                                $("#" + key + "2_error").text(val[0]);
                            });
                    }
                });
        }
   </script>

    {{-- fill delete modal user --}}
    <script>
        $('#delete_user').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id     =  button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id3').val(id);
        })
    </script>


   {{-- delete user--}}
   <script>
        function do_delete(){

            $("#delete_user_button").css("display", "none");
            $("#delete_user2").css("display", "block");
            var formData = new FormData($('#delete_user_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{route('dashboard.destroy_primaryImages')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $("#delete_user2").css("display", "none");
                    $("#delete_user_button").css("display", "block");
                    $('.close').click();
                    $('#position-top-start_delete').click();
                    $('.yajra-datatable').DataTable().ajax.reload(null, false);

                }, error: function (reject) {
                }
            });
     }
   </script>

<style>

    .levels-link.btn-link {
    display: inline-block;
    color: #fff;
    background-color: #8B78E8;
    padding: 6px 12px;
    border-radius: 4px;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

    .levels-link.btn-link:hover {
    background-color: #8B78E8; /* Slightly darker purple on hover */
}

   </style>




@endsection
