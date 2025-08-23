{{-- @can('تعديل طالب') --}}
<a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_user"

data-id=            "{{ $data->id }}"
data-image=         "{{ $data->image }}"
data-title_ar=          "{{ $data->title_ar }}"
data-title_en=          "{{ $data->title_en }}"



> <i class="fa fa-edit"></i> </a>

{{-- @endcan --}}
{{-- @can('حذف طالب') --}}
<a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_user"
data-id=             "{{ $data->id }}"
><i class="fa fa-trash"></i></a>
{{-- @endcan --}}
