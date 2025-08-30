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
        <li class="breadcrumb-item"><a href="#">كامل التفاصيل </a>
        </li>
    </ol>
</div>

<h1 class="text-center" style="color:black">اسم الباقة : {{ $package->title_ar }}</h1>
{{-- @can('اضافة طالب') --}}
{{-- @endcan --}}
<h2>مميزات الباقة</h2>
<a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">اضافة ميزة للباقة</a>
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <table id="yajra-datatable" class="datatables-basic table table-responsive-md">
                    <thead>
                        <tr>

                            <th>#</th>
                            <th>الميزة بالعربي </th>
                            <th>الميزة بالانجلش </th>
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


<h2> انظمة الباقة</h2>
<a class="btn btn-primary" data-toggle="modal" href="#inlineForm2" style="margin-bottom:1%">اضافة نظام للباقة</a>
<section id="basic-datatable2">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <table id="yajra-datatable2" class="datatables-basic table table-responsive-md yajra-datatable">
                    <thead>
                        <tr>

                            <th>#</th>
                            <th> العنوان بالعربي</th>
                            <th> العنوان بالانجلش</th>
                            <th> المميزات</th>
                            <th> المرفقات</th>
                            <th> الوصف بالعربي</th>
                            <th> الوصف بالانجلش</th>
                            <th> الصورة</th>
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


<h2> خصائص الباقة</h2>
<a class="btn btn-primary" data-toggle="modal" href="#inlineForm3" style="margin-bottom:1%">اضافة خاصية للباقة</a>
<section id="basic-datatable3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <table id="yajra-datatable3" class="datatables-basic table table-responsive-md">
                    <thead>
                        <tr>

                            <th>#</th>
                            <th> العنوان بالعربي</th>
                            <th> العنوان بالانجلش</th>
                            <th> الوصف بالعربي</th>
                            <th> الوصف بالانجلش</th>
                            <th> الصورة</th>
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
                    <h4 class="modal-title" id="myModalLabel33">اضافة </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_user_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">

                            <input type="hidden" name="package_id" value="{{ $id }}">
                            <div class="col-md-12">
                                <label> الميزة بالعربي </label>
                                <div class="form-group">
                                    <input type="text"  name="title_ar" id="title_ar"  class="form-control" />
                                    <span id="title_ar_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label> الميزة بالانجلش </label>
                                <div class="form-group">
                                    <input type="text"  name="title_en" id="title_en"  class="form-control" />
                                    <span id="title_en_error" class="text-danger"></span>
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
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_user_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="id" id="id2">

                            <input type="hidden" name="package_id" id='package_id_edit'>

                            <div class="col-md-12">
                                <label> الميزة بالعربي </label>
                                <div class="form-group">
                                    <input type="text"  name="title_ar" id="title_ar2" class="form-control" />
                                    <span id="title_ar2_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label> الميزة بالانجلش </label>
                                <div class="form-group">
                                    <input type="text"  name="title_en" id="title_en2" class="form-control" />
                                    <span id="title_en2_error" class="text-danger"></span>
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
                    <span aria-hidden="true">&times;</span>
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




{{-- modal add2 --}}
<div class="form-modal-ex" id="modal_add2">
    <div class="modal fade text-left" id="inlineForm2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel332">اضافة نظام</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_user_form2">
                    @csrf
                    <div class="modal-body">


                        <div class="row">
                                <div class="col-md-12">
                                        <div class="form-group">
                                        <input type="hidden" value="{{ $id }}" name="package_id">
                                        <label for="exampleFormControlSelect1">systems </label>
                                        <select class="form-control" name="system_id" id="system_idz" id="exampleFormControlSelect1">
                                            @foreach($systems as $system)
                                                        <option value="{{ $system->id }}">{{ $system->title_ar }}</option>
                                            @endforeach
                                        </select>
                                        <span id="system_idz_error" class="text-danger"></span>
                                    </div>
                                </div>
                        </div>






                    </div>
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="add_userz2" class="btn btn-primary btn-block">تتم الاضافة ...</button>
                        <button type="button" id="add_userz" class="btn btn-primary btn-block">اضافة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- modal edit2 --}}
<div class="form-modal-ex">
    <div class="modal fade text-left" id="edit_user2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel332">تعديل </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_user_form2">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                           <input type="hidden" name="id" id="id2z">
                           <input type="hidden" name="package_id" id="package_id_editz">

                            <div class="col-md-12">
                                <label> العنوان بالعربي </label>
                                <div class="form-group">
                                    <input type="text" placeholder="الاسم" name="title_ar" id="title_arz2" class="form-control" />
                                    <span id="title_arz2_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label> العنوان بالانجلش </label>
                                <div class="form-group">
                                    <input type="text" placeholder="الاسم" name="title_en" id="title_enz2" class="form-control" />
                                    <span id="title_enz2_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label> الوصف بالعربي </label>
                                <div class="form-group">
                                    <input type="text" placeholder="الاسم" name="desc_ar" id="desc_arz2" class="form-control" />
                                    <span id="desc_arz2_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label> الوصف بالانجلش </label>
                                <div class="form-group">
                                    <input type="text" placeholder="الاسم" name="desc_en" id="desc_enz2" class="form-control" />
                                    <span id="desc_enz2_error" class="text-danger"></span>
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
                        <button type="button" style="display: none" id="editingz2" class="btn btn-primary btn-block"> يتم التعديل ...</button>
                        <button type="button" id="editing" onclick="do_updatez()" class="btn btn-primary btn-block">حفظ التعديلات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- delete user2 --}}
<div class="modal fade modal-danger text-left" id="delete_userz" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel1202">حذف </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="delete_user_form2">
                    @csrf
                    <input type="hidden" value="{{ $id }}" name="package_id">
                    <input type="hidden" name="id" id="idz3">
                     هل انت متأكد من عملية الحذف ؟
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="delete_userz2" style="display: none" data-dismiss="modal">...يتم الحذف</button>
                        <button type="button" class="btn btn-danger" onclick="do_deletez()" id="delete_user_buttonz" data-dismiss="modal">تأكيد</button>
                    </div>
                </form>
        </div>
    </div>
</div>




{{-- modal add 3--}}
<div class="form-modal-ex" id="modal_add3">
    <div class="modal fade text-left" id="inlineForm3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel333">اضافة خاصية </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_user_form3">
                    @csrf
                    <div class="modal-body">


                        <div class="row">

                            <input type="hidden" name="package_id" value="{{ $id }}">
                            <div class="col-md-12">
                                <label> العنوان بالعربي </label>
                                <div class="form-group">
                                    <input type="text" placeholder="الاسم" name="title_ar" id="title_arx"  class="form-control" />
                                    <span id="title_arx_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label> العنوان بالانجلش </label>
                                <div class="form-group">
                                    <input type="text" placeholder="الاسم" name="title_en" id="title_enx"  class="form-control" />
                                    <span id="title_enx_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label> الوصف بالعربي </label>
                                <div class="form-group">
                                    <input type="text" placeholder="الاسم" name="desc_ar" id="desc_arx"  class="form-control" />
                                    <span id="desc_arx_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label> الوصف بالانجلش </label>
                                <div class="form-group">
                                    <input type="text" placeholder="الاسم" name="desc_en" id="desc_enx"  class="form-control" />
                                    <span id="desc_enx_error" class="text-danger"></span>
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
                        <button type="button" style="display: none" id="add_userx2" class="btn btn-primary btn-block">تتم الاضافة ...</button>
                        <button type="button" id="add_userx" class="btn btn-primary btn-block">اضافة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



{{-- modal edit 3 --}}
<div class="form-modal-ex">
    <div class="modal fade text-left" id="edit_user3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel334">تعديل </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_user_form3">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                           <input type="hidden" name="id" id="id23">
                           <input type="hidden" name="package_id" id="package_id_edit3">

                            <div class="col-md-12">
                                <label> العنوان بالعربي </label>
                                <div class="form-group">
                                    <input type="text" placeholder="الاسم" name="title_ar" id="title_ar32" class="form-control" />
                                    <span id="title_ar32_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label> العنوان بالانجلش </label>
                                <div class="form-group">
                                    <input type="text" placeholder="الاسم" name="title_en" id="title_en32" class="form-control" />
                                    <span id="title_en32_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label> الوصف بالعربي </label>
                                <div class="form-group">
                                    <input type="text" placeholder="الاسم" name="desc_ar" id="desc_ar32" class="form-control" />
                                    <span id="desc_ar32_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label> الوصف بالانجلش </label>
                                <div class="form-group">
                                    <input type="text" placeholder="الاسم" name="desc_en" id="desc_en32" class="form-control" />
                                    <span id="desc_en32_error" class="text-danger"></span>
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
                        <button type="button" style="display: none" id="editing23" class="btn btn-primary btn-block"> يتم التعديل ...</button>
                        <button type="button" id="editing3" onclick="do_update3()" class="btn btn-primary btn-block">حفظ التعديلات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- delete user 3 --}}
<div class="modal fade modal-danger text-left" id="delete_user3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel1203">حذف </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="delete_user_form3">
                    @csrf
                    <input type="hidden" name="id" id="id33">
                     هل انت متأكد من عملية الحذف ؟
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="delete_user23" style="display: none" data-dismiss="modal">...يتم الحذف</button>
                        <button type="button" class="btn btn-danger" onclick="do_delete3()" id="delete_user_button3" data-dismiss="modal">تأكيد</button>
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
        var table = $('#yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('dashboard.get_all_packages_features',$id) }}",
            columns: [
                {data: 'DT_RowIndex'   ,name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'title_ar'          ,name: 'title_ar'},
                {data: 'title_en'          ,name: 'title_en'},
                {data: 'action'        ,name: 'action'},
            ],
            "lengthMenu": [[5,25,50,-1],[5,25,50,'All']],     // page length options
        });
        });
    </script>
    {{-- defaultContent عشان اذا في بعض الحقول فاضية..ما يرجعلي ايرور من الياجرا داتاتبل وبحطلي بدالها "-" --}}


    <script type="text/javascript">

        $(function () {
        var table = $('#yajra-datatable2').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('dashboard.get_all_systems2',$id) }}",
            columns: [
                {data: 'DT_RowIndex'     ,name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'title_ar'        ,name: 'title_ar'},
                {data: 'title_en'        ,name: 'title_en'},
                {data: 'features'        ,name: 'features'},
                {data: 'systems_attachments'        ,name: 'systems_attachments'},
                {data: 'description_ar'  ,name: 'desc_ar', searchable: false},
                {data: 'description_en'  ,name: 'desc_en', searchable: false},
                {data: 'image'            ,name: 'image', searchable: false},
                {data: 'action'          ,name: 'action'},
            ],
            "lengthMenu": [[5,25,50,-1],[5,25,50,'All']],     // page length options
        });
        });
    </script>


  <script type="text/javascript">

        $(function () {
        var table = $('#yajra-datatable3').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('dashboard.get_all_package_spec',$id) }}",
            columns: [
                {data: 'DT_RowIndex'     ,name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'title_ar'        ,name: 'title_ar'},
                {data: 'title_en'        ,name: 'title_en'},
                {data: 'description_ar'  ,name: 'desc_ar', searchable: false},
                {data: 'description_en'  ,name: 'desc_en', searchable: false},
                {data: 'image'            ,name: 'image', searchable: false},
                {data: 'action'          ,name: 'action'},
            ],
            "lengthMenu": [[5,25,50,-1],[5,25,50,'All']],     // page length options
        });
        });
    </script>




    {{-- open modal add user --}}
    <script>
        $('#modal_add').on('show.bs.modal', function(event) {
            $('#city').text('');
            $("#image").attr('src', "{{  env('APP_URL') }}/attachments/downloads/download.png");


        })
    </script>

    <script>
        $('#modal_add2').on('show.bs.modal', function(event) {
            $('#city').text('');
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
                    url: "{{route('dashboard.store_packages_features')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {

                            $('#yajra-datatable').DataTable().ajax.reload(null, false);
                            $("#add_user2").css("display", "none");
                            $("#add_user").css("display", "block");
                            $('.close').click();
                            $('#name').val('');
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


       {{-- add user2 --}}
    <script>
        $(document).on('click', '#add_userz', function (e) {
            $('span').text('');



            $("#add_userz2").css("display", "block");
            $("#add_userz").css("display", "none");
            var formData = new FormData($('#add_user_form2')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('dashboard.store_systems')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {

                            $('#yajra-datatable2').DataTable().ajax.reload(null, false);
                            $("#add_userz2").css("display", "none");
                            $("#add_userz").css("display", "block");
                            $('.close').click();
                            $("#image").attr('src', "{{  env('APP_URL') }}/attachments/downloads/download.png");
                            $('#change-picture').val('');
                            $('#position-top-start').click();

                    },
                    error: function (reject) {
                        $("#add_user2").css("display", "none");
                        $("#add_user").css("display", "block");
                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function (key, val) {
                            $("#" + key + "z_error").text(val[0]);
                        });
                    }
                });
            });
    </script>


    {{-- add user 3 --}}
    <script>
        $(document).on('click', '#add_userx', function (e) {
            $('span').text('');



            $("#add_userx2").css("display", "block");
            $("#add_userx").css("display", "none");
            var formData = new FormData($('#add_user_form3')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('dashboard.store_package_spec')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {

                            $('#yajra-datatable3').DataTable().ajax.reload(null, false);
                            $("#add_userx2").css("display", "none");
                            $("#add_userx").css("display", "block");
                            $('.close').click();
                            $('#name').val('');
                            $("#image").attr('src', "{{  env('APP_URL') }}/attachments/downloads/download.png");
                            $('#change-picture').val('');
                            $('#position-top-start').click();

                    },
                    error: function (reject) {
                        $("#add_userx2").css("display", "none");
                        $("#add_userx").css("display", "block");
                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function (key, val) {
                            $("#" + key + "x_error").text(val[0]);
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
            var title_ar =            button.data('title_ar')
            var title_en =            button.data('title_en')
            var package_id =            button.data('package_id')


            var modal = $(this)
            modal.find('.modal-body #id2').val(id);
            modal.find('.modal-body #title_ar2').val(title_ar);
            modal.find('.modal-body #title_en2').val(title_en);
            modal.find('.modal-body #package_id_edit').val(package_id);

        })
    </script>

    {{-- edit user 2 --}}
    <script>
        $('#edit_user2').on('show.bs.modal', function(event) {

            var button = $(event.relatedTarget)
            var id =                  button.data('id')
            var title_ar =                button.data('title_ar')
            var title_en =                button.data('title_en')
            var description_ar =                button.data('description_ar')
            var description_en =                button.data('description_en')
            var image =                button.data('image')
            var package_id =                button.data('package_id')



            var modal = $(this)
            modal.find('.modal-body #id2z').val(id);
            modal.find('.modal-body #title_arz2').val(title_ar);
            modal.find('.modal-body #title_enz2').val(title_en);
            modal.find('.modal-body #desc_arz2').val(description_ar);
            modal.find('.modal-body #desc_enz2').val(description_en);
            modal.find('.modal-body #package_id_editz').val(package_id);
            $(".modal-body #image2").attr('src',image);

        })
    </script>


  {{-- edit user  3--}}
    <script>
        $('#edit_user3').on('show.bs.modal', function(event) {

            var button = $(event.relatedTarget)
            var id =                  button.data('id')
            var title_ar =                button.data('title_ar')
            var title_en =                button.data('title_en')
            var description_ar =                button.data('description_ar')
            var description_en =                button.data('description_en')
            var image =                button.data('image')
            var package_id =                button.data('package_id')



            var modal = $(this)
            modal.find('.modal-body #id23').val(id);
            modal.find('.modal-body #title_ar32').val(title_ar);
            modal.find('.modal-body #title_en32').val(title_en);
            modal.find('.modal-body #desc_ar32').val(description_ar);
            modal.find('.modal-body #desc_en32').val(description_en);
            modal.find('.modal-body #package_id_edit3').val(package_id);
            $(".modal-body #image2").attr('src',image);

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
                    url: "{{route('dashboard.update_packages_features')}}",
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
                        $('#yajra-datatable').DataTable().ajax.reload(null, false);

                    }, error: function (reject) {
                            $("#editing").css("display", "block");
                            $("#editing2").css("display", "none");
                            var response = $.parseJSON(reject.responseText);
                            $.each(response.errors, function (key, val) {
                                $("#" + key + "z2_error").text(val[0]);
                            });
                    }
                });
        }
   </script>


   {{-- update user 2--}}
   <script>
        function do_updatez(){

            $('span').text('');



            $("#editingz").css("display", "none");
            $("#editingz2").css("display", "block");

            var formData = new FormData($('#edit_user_form2')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('dashboard.update_systems')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        $("#editingz").css("display", "block");
                        $("#editingz2").css("display", "none");

                        $('.close').click();
                        $('#change-picture2').val('');
                        $('#position-top-start_edit').click();
                        $("#image").attr('src', "{{  env('APP_URL') }}/attachments/downloads/download.png");
                        $('#yajra-datatable2').DataTable().ajax.reload(null, false);

                    }, error: function (reject) {
                            $("#editingz").css("display", "block");
                            $("#editingz2").css("display", "none");
                            var response = $.parseJSON(reject.responseText);
                            $.each(response.errors, function (key, val) {
                                $("#" + key + "z2_error").text(val[0]);
                            });
                    }
                });
        }
   </script>


   {{-- update user 3--}}
   <script>
        function do_update3(){

            $('span').text('');



            $("#editing3").css("display", "none");
            $("#editing23").css("display", "block");

            var formData = new FormData($('#edit_user_form3')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('dashboard.update_package_spec')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        $("#editing3").css("display", "block");
                        $("#editing23").css("display", "none");

                        $('.close').click();
                        $('#change-picture2').val('');
                        $('#position-top-start_edit').click();
                        $("#image").attr('src', "{{  env('APP_URL') }}/attachments/downloads/download.png");
                        $('#yajra-datatable3').DataTable().ajax.reload(null, false);

                    }, error: function (reject) {
                            $("#editing3").css("display", "block");
                            $("#editing23").css("display", "none");
                            var response = $.parseJSON(reject.responseText);
                            $.each(response.errors, function (key, val) {
                                $("#" + key + "32_error").text(val[0]);
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


    {{-- fill delete modal user2 --}}
    <script>
        $('#delete_userz').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id     =  button.data('id')
            var modal = $(this)
            modal.find('.modal-body #idz3').val(id);
        })
    </script>


    {{-- fill delete modal user3 --}}
    <script>
        $('#delete_user3').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id     =  button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id33').val(id);
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
                url: "{{route('dashboard.destroy_packages_features')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $("#delete_user2").css("display", "none");
                    $("#delete_user_button").css("display", "block");
                    $('.close').click();
                    $('#position-top-start_delete').click();
                    $('#yajra-datatable').DataTable().ajax.reload(null, false);

                }, error: function (reject) {
                }
            });
     }
   </script>


   {{-- delete user2--}}
   <script>
        function do_deletez(){

            $("#delete_user_buttonz").css("display", "none");
            $("#delete_userz2").css("display", "block");
            var formData = new FormData($('#delete_user_form2')[0]);
            $.ajax({
                type: 'post',
                url: "{{route('dashboard.destroy_systems_for_package')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $("#delete_userz2").css("display", "none");
                    $("#delete_user_buttonz").css("display", "block");
                    $('.close').click();
                    $('#position-top-start_delete').click();
                    $('#yajra-datatable2').DataTable().ajax.reload(null, false);

                }, error: function (reject) {
                }
            });
     }
   </script>



   {{-- delete user--}}
   <script>
        function do_delete3(){

            $("#delete_user_button3").css("display", "none");
            $("#delete_user23").css("display", "block");
            var formData = new FormData($('#delete_user_form3')[0]);
            $.ajax({
                type: 'post',
                url: "{{route('dashboard.destroy_package_spec')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $("#delete_user23").css("display", "none");
                    $("#delete_user_button3").css("display", "block");
                    $('.close').click();
                    $('#position-top-start_delete').click();
                    $('#yajra-datatable3').DataTable().ajax.reload(null, false);

                }, error: function (reject) {
                }
            });
     }
   </script>


@endsection
