
<a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_user"

data-id=                "{{ $data->id }}"
data-title_ar=          "{{ $data->getTranslation('title' ,'ar') }}"
data-title_en=          "{{ $data->getTranslation('title' ,'en') }}"
data-desc_ar=           "{{ $data->getTranslation('description' ,'ar') }}"
data-desc_en=           "{{ $data->getTranslation('description' ,'en') }}"



> <i class="fa fa-edit"></i> </a>


{{-- <a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_user"
data-id=             "{{ $data->id }}"
><i class="fa fa-trash"></i></a> --}}

