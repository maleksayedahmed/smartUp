
<a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_user"

data-id=                "{{ $data->id }}"
data-title_ar=          "{{ $data->title_ar }}"
data-title_en=          "{{ $data->title_en }}"
data-desc_ar=           "{{ $data->desc_ar }}"
data-desc_en=           "{{ $data->desc_en }}"
data-note_ar=           "{{ $data->note_ar }}"
data-note_en=           "{{ $data->note_en }}"



> <i class="fa fa-edit"></i> </a>

<a class="btn btn-sm btn-primary"  href="{{ route('dashboard.preview_packages', $data->id) }}"


> <i class="fa fa-eye"></i> </a>


<a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_user"
data-id=             "{{ $data->id }}"
><i class="fa fa-trash"></i></a>

