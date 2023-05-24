@extends('ddcdrive::layouts.master')
@section('custom-css-script')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/toastr/toastr.min.css') }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@stop
@section('custom-css')
@stop
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>DDC-Drive (ระบบแชร์ไฟล์ภายในกรม)</h1>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">ไฟล์ที่ต้องการแก้ไข</h3>
              </div>
              <div class="card-body">
                <p class="text-success">ชื่อไฟล์ : @if($file_datas->file_ori_name){{ $file_datas->file_ori_name }} @endif</p>
              </div>
            </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-sm-12">
        <div class="card">
          <div class="card-body">
            <form class="form-group" action="{{ route('ddcdrive.act_upload_file') }}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="form-group row">
                @if($file_datas->file_ori_name)
                <label for="inputEmail3" class="col-sm-3 col-form-label">ไฟล์</label>
                <div class="col-sm-9">
                  <a class="delete-confirm"  data-namereplace="{{ $file_datas->file_name }}" data-foldername="{{ $file_datas->file_folder_name }}" data-name="{{ $file_datas->file_ori_name }}" data-fileid="{{ $file_datas->file_id }}">{{ $file_datas->file_ori_name }} <i class="fas fa-trash-alt" data-toggle="tooltip" title="ลบไฟล์"></i></a>
                </div>
                @else
                <label for="inputEmail3" class="col-sm-3 col-form-label">กรุณาเลือกไฟล์</label>
                <div class="col-sm-9">
                  <input type="file" id="customFile" name="customFile" class="mr-2" required>
                </div>

                @endif
              </div>
              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-3 col-form-label">รายละเอียด/คำอธิบายของไฟล์</label>
                <div class="col-sm-9">
                  <input type="text" autocomplete="off" value="@if($file_datas->files_description){{ $file_datas->files_description }} @else - @endif" class="form-control" name="files_description" placeholder="รายละเอียดหรือคำอธิบายของไฟล์" />
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-12">
                  <button type="submit" class="btn btn-success"><i class="fas fa-cloud-upload-alt"></i> อัพโหลดไฟล์</button>
                </div>
              </div>
            </form>
          </div>
        </div>
     </div>
    </div>
  </div>
</section>
@endsection
@section('custom-js-script')
<!-- DataTables -->
<script src="{{ asset('bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.js') }}"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Toastr -->
<script src="{{ asset('bower_components/admin-lte/plugins/toastr/toastr.min.js') }}"></script>
<!-- Cilpboard -->
<script src="//cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.4.0/clipboard.min.js"></script>
@stop
@section('custom-js-code')
<!-- page script -->
<script>
  $(function () {

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });


    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    };

    @if ($message = Session::get('success'))
    toastr.success('{!! $message !!}')
    @endif
    @if ($message = Session::get('warning'))
    toastr.warning('{!! $message !!}')
    @endif
    @if ($message = Session::get('error'))
    toastr.error('{!! $message !!}')
    @endif

    $('[data-toggle="tooltip"]').tooltip()

    $('.delete-confirm').click(function(event) {
      var form =  $(this).closest("form");
      var file_id = $(this).data("fileid");
      var file_name = $(this).data("name");
      var folder_name = $(this).data("foldername");
      var file_name_replace = $(this).data("namereplace");

      Swal.fire({
          title: 'ยืนยันการลบไฟล์'+'\n'+file_name+' ?',
          text: "เมื่อลบแล้วข้อมูลจะหายไปไม่สามารถกู้คืนได้",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'ยกเลิก',
          confirmButtonText: 'ใช่, ต้องการลบ'
      })
      .then((result) => {
                if (result) {
                    $.ajax({
                        url : "{{ route('ddcdrive.deletefile') }}",
                        type : "POST",
                        data : {'file_id' : file_id,'file_name' : file_name,'folder_name' :folder_name,'file_name_replace':file_name_replace},
                        success: function(data){
                            if(data.status == 'ok'){
                              toastr.success('ลบไฟล์ '+file_name+' สำเร็จ')
                                window.setTimeout(function(){
                                    location.reload();
                                } ,1000);
                            }else{
                              toastr.error('ลบสิทธิ์ '+file_name+' ไม่สำเร็จ error=>'+data.status)

                            }
                        },
                        error : function(data){
                            toastr.error('error msg: '+data.status);
                        }
                    })
                } else {
                  toastr.error('ยกเลิกการทำรายการ');
                }
      });
    });

  });
</script>
@stop
