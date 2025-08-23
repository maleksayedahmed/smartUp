{{-- @can('تعديل طالب') --}}
<a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_user"

data-id=                "{{ $data->id }}"
data-name_ar=          "{{ $data->name_ar }}"
data-name_en=          "{{ $data->name_en }}"
data-description_ar=          "{{ $data->description_ar }}"
data-description_en=          "{{ $data->description_en }}"
data-image=          "{{ $data->image }}"



> <i class="fa fa-edit"></i> </a>

{{-- @endcan --}}
{{-- @can('حذف طالب') --}}
<a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_user"
data-id=             "{{ $data->id }}"
><i class="fa fa-trash"></i></a>
{{-- @endcan --}}
