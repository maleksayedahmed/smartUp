{{-- @can('تعديل طالب') --}}
{{-- <a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_user2"

data-id=                "{{ $data->id }}"
data-title_ar=          "{{ $data->title_ar }}"
data-title_en=          "{{ $data->title_en }}"
data-desctiption_ar=          "{{ $data->desctiption_ar }}"
data-desctiption_en=          "{{ $data->desctiption_en }}"
data-package_id=          "{{ $data->package_id }}"
data-image=          "{{ $data->image }}"



> <i class="fa fa-edit"></i> </a> --}}

{{-- @endcan --}}
{{-- @can('حذف طالب') --}}
<a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_userz"
data-id=             "{{ $data->id }}"
><i class="fa fa-trash"></i></a>
{{-- @endcan --}}
