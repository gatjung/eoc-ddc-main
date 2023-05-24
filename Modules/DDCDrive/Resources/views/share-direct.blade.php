<?php use App\CmsHelper as CmsHelper; ?>
@extends('ddcdrive::layouts.master')
@section('custom-css-script')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.css') }}">
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
        <h4>DDC-Drive (การแชร์ไฟล์ไปยังผู้อื่น)</h4>
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
                <h3 class="card-title">ไฟล์ที่ต้องการแชร์</h3>
              </div>
              <div class="card-body">
                <p class="text-success">ชื่อไฟล์ : @if($filename_to_share->file_ori_name){{ $filename_to_share->file_ori_name }} @endif</p>
                <p class="text-success">คำอธิบาย/รายละเอียด : @if($filename_to_share->files_description){{ $filename_to_share->files_description }} @else - @endif</p>
              </div>
            </div>
      </div>
    </div>
    <form action="{{ route('ddcdrive.save_private_permission') }}" method="post" >
      @csrf
      <div class="row">
        <div class="col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">ต้องการแชร์ไปยัง</h3>
                </div>
                <div class="card-body">
                  <div class="form-group">
                    <div class="select2-danger">
                      <select id="share_user_spacific" name="share_user[]" class="select2 select2-danger form-control" data-dropdown-css-class="select2-danger" multiple="multiple">
                      </select>
                    </div>
                  </div>
                  <!-- /.form-group -->
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn bg-gradient-success float-right"><i class="fas fa-share-alt"></i> แชร์ไฟล์</button>
                    {{-- {{ $status }} --}}
                    @if ($status == "privatetoprivate")
                        <a href="{{ route('ddcdrive.files-shareprivate') }}" type="button" class="btn bg-gradient-primary"><i class="fas fa-arrow-circle-left"></i> ย้อนกลับ</a>
                    @elseif ($status == "grouptoprivate")
                        <a href="{{ route('ddcdrive.files-sharegroup') }}" type="button" class="btn bg-gradient-primary"><i class="fas fa-arrow-circle-left"></i> ย้อนกลับ</a>
                    @else
                        <a href="{{ route('ddcdrive.myfiles') }}" type="button" class="btn bg-gradient-primary"><i class="fas fa-arrow-circle-left"></i> ย้อนกลับ</a>
                    @endif
                </div>
              </div>
        </div>
      </div>
      <input type="hidden" value="{{ $status }}" name="status">
      <input type="hidden" name="file_id" value="{{ $filename_to_share->file_id }}"  />
    </form>
    @if($list_permission_private)
    <div class="row">
      <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">รายชื่อผู้ได้รับการแชร์ไฟล์ : @if($filename_to_share->file_ori_name){{ $filename_to_share->file_ori_name }} @endif</h3>
              </div>
              <div class="card-body">
                <table id="files_share" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                          <th>ชื่อ-นามสกุล</th>
                          <th>สถานะการอ่านไฟล์</th>
                          <th>จัดการสิทธิ์</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i=1; @endphp
                        @foreach($list_permission_private as $my_permission_private)
                        <tr id="rowId{{ $i }}">
                          <td>{{ $my_permission_private['fullname'] }}</td>
                          <td>@if($my_permission_private['read_at']) <p class="text-success">อ่านไฟล์แล้ว เมื่อ {{ CmsHelper::formatDateThai($my_permission_private['read_at']) }}</p> @else <p class="text-danger">ยังไม่ได้อ่านไฟล์</p> @endif</td>
                          <td>
                             <button class="btn btn-danger btn-sm delete-confirm" data-tbdel="rowId{{ $i }}" data-shareid="{{ $my_permission_private['share_id'] }}" data-name="{{ $my_permission_private['fullname'] }}" data-fileid="{{ $filename_to_share->file_id }}" type="button"><i class="fas fa-handshake-slash"></i> ลบสิทธิ์การเข้าถึงไฟล์</button>
                          </td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                          <th>ชื่อ-นามสกุล</th>
                          <th>สถานะการอ่านไฟล์</th>
                          <th>จัดการสิทธิ์</th>
                        </tr>
                        </tfoot>
                  </table>
              </div>
              <div class="card-footer">
                @if ($status == "privatetoprivate")
                  <a href="{{ route('ddcdrive.files-shareprivate') }}" type="button" class="btn bg-gradient-primary"><i class="fas fa-arrow-circle-left"></i> ย้อนกลับ</a>
                @elseif ($status == "grouptoprivate")
                  <a href="{{ route('ddcdrive.files-sharegroup') }}" type="button" class="btn bg-gradient-primary"><i class="fas fa-arrow-circle-left"></i> ย้อนกลับ</a>
                @else
                  <a href="{{ route('ddcdrive.myfiles') }}" type="button" class="btn bg-gradient-primary"><i class="fas fa-arrow-circle-left"></i> ย้อนกลับ</a>
                @endif
              </div>
            </div>
      </div>
    </div>
    @endif
  </div>
</section>
@endsection
@section('custom-js-script')
<!-- DataTables -->
<script src="{{ asset('bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('bower_components/select2/dist/js/select2.full.js') }}"></script>
<script src="{{ asset('bower_components/select2/dist/js/i18n/th.js') }}"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Toastr -->
<script src="{{ asset('bower_components/admin-lte/plugins/toastr/toastr.min.js') }}"></script>
@stop
@section('custom-js-code')
<!-- page script -->
<script>
  $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
  });
  $(document).ready(function () {
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

    //Initialize Select2 Elements
    $("#share_user_spacific").select2({
      language: "th",
      placeholder: "กรุณาพิมพ์ชื่อผู้ใช้งานที่ต้องการแชร์ไฟล์",
      minimumResultsForSearch: 5,
      ajax: {
       url: "{{ route('ddcdrive.ajax.get.user.all') }}?file_id={!! $filename_to_share->file_id !!}",
       type: "GET",
       dataType: 'json',
       delay: 250,
       data: function (params) {
        return {
          searchTerm: params.term // search term
        };
       },
       processResults: function (response) {
           console.log(response);
         return {
            results: response
         };
       },
       cache: true
      }
    });
    $('#files_share').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "language": {
              "sProcessing": "กำลังดำเนินการ...",
              "sLengthMenu": "แสดง_MENU_ แถว",
              "sZeroRecords": "ไม่พบข้อมูล",
              "sInfo": "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว",
              "sInfoEmpty": "แสดง 0 ถึง 0 จาก 0 แถว",
              "sInfoFiltered": "(กรองข้อมูล _MAX_ ทุกแถว)",
              "sInfoPostFix": "",
              "sSearch": "ค้นหา:",
              "sUrl": "",
              "oPaginate": {
                            "sFirst": "เิริ่มต้น",
                            "sPrevious": "ก่อนหน้า",
                            "sNext": "ถัดไป",
                            "sLast": "สุดท้าย"
              }
     }
    });
    $('.delete-confirm').click(function(event) {
      var form =  $(this).closest("form");
      var share_id = $(this).data("shareid");
      var file_id = $(this).data("fileid");
      var name = $(this).data("name");
      var rowId = $(this).data("tbdel");

      Swal.fire({
          title: 'ยืนยันการลบสิทธิ์การเข้าถึงไฟล์'+'\n'+'คุณ '+name+' ?',
          text: "เมื่อลบแล้วข้อมูลจะหายไปไม่สามารถกู้คืนได้",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'ยกเลิก',
          confirmButtonText: 'ใช่, ต้องการลบ'
      })
      .then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url : "{{ route('ddcdrive.del_private_permission') }}",
                        type : "POST",
                        data : {'share_id' : share_id,'file_id' : file_id},
                        success: function(data){
                            if(data.status == 'ok'){
                              toastr.success('ลบสิทธิ์ '+name+' สำเร็จ')
                              $('#' + rowId).remove();
                                // window.setTimeout(function(){
                                //     location.reload();
                                // } ,2000);
                            }else{
                              toastr.error('ลบสิทธิ์ '+name+' ไม่สำเร็จ error=>'+data.status)
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
