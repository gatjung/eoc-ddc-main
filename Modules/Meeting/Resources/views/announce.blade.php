@extends('feedback::layouts.master')
@section('custom-css-script')
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/toastr/toastr.min.css') }}">
@endsection
@section('content')

    <!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1>ประกาศ</h1>
      </div>

    </div>
  </div><!-- /.container-fluid -->
</section>
    <!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
            <form method="post" action="{{ route('announce.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>หัวเรื่อง:</label><i style="color: red"><b > *</b>จำเป็นต้องกรอก</i>
                                <input type="text" name="topic" class="form-control" required>
                            </div>
                            <div class="form-group" id="AnnounceNo">
                                <label>ข้อความที่ต้องการประกาศ ข้อที่ 1 :</label><i style="color: red"><b > *</b>จำเป็นต้องกรอก</i>
                                <input type="text" class="form-control" name="announce[]" autocomplete="off" required>
                                <input type="button" id="add_Announce()_1" class="btn btn-success" style="margin-top: 10px;" onclick="addAnnounce()" value="เพิ่มข้อความประกาศ ข้อที่ 2" /><hr/>
                            </div>
                            {{-- <div class="form-group">
                                <label for="InputFile">อัพโหลดไฟล์แนบ:</label>
                                <div class="input-group">
                                  <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="InputFile" name="file_name">
                                    <label class="custom-file-label" for="InputFile">แนบไฟล์</label>
                                  </div>
                                </div>
                            </div> --}}


                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">ส่ง</button>
                </div>
            </form>
        </div>
    </div>


</section>
    <!-- /.content -->
@endsection
@section('custom-js-script')
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Toastr -->
    <script src="{{ asset('bower_components/admin-lte/plugins/toastr/toastr.min.js') }}"></script>

    <script src="{{ asset('js/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function () {
              bsCustomFileInput.init();
            });
            var i = 1;

            function addAnnounce() {
                // alert("ok");
                i++;
                var div = document.createElement('div');

                div.innerHTML =
                                '<label style="padding-top: 10px;">ข้อความที่ต้องการประกาศ ข้อที่ '+ i +' :</label><i style="color: red"><b > *</b>จำเป็นต้องกรอก</i><input type="text" class="form-control" name="announce[]" autocomplete="off" required>'+
                                '<input type="button" id="add_Announce()_1" class="btn btn-success" style="margin-top: 10px;" onclick="addAnnounce()" value="เพิ่มข้อความประกาศ ข้อที่ '+ (i+1) +'" />' + '&nbsp;&nbsp;&nbsp;&nbsp;' +
                                '<input type="button" id="rem_kid()_' + i + '" style="margin-top: 10px;" class="btn btn-danger" onclick="remaddCaddAnnounce(this)" value="ลบข้อความประกาศ ข้อที่ '+ (i+1) +'" /><hr/>'
                                ;

                // div.innerHTML =
                //                 '<label for="comm_num">เลขคำสั่งแต่งตั้งที่ '+ i +' </label>'+
                //                 '<input type="text" class="form-control" name="comm_num[]" autocomplete="off">'+

                //                 '<label for="comm_date" style="padding-top: 10px;">วันที่เริ่มปฏิบัติงานตามคำสั่งที่ '+ i +' </label>'+
                //                 '<div class="input-group date" id="datepicker2">'+
                //                     '<input class=" form-control input-medium" name="comm_date[]" type="text" data-provide="datepicker" data-date-language="th" data-date-format="yyyy-mm-dd" placeholder="ปี/เดือน/วัน" autocomplete="off" >'+
                //                     '<div class="input-group-append">'+
                //                         '<div class="input-group-text">'+
                //                             '<i class="fa fa-calendar"></i>'+
                //                         '</div>'+
                //                     '</div>'+
                //                 '</div>'+

                //                 '<input type="button" id="add_comm_num()_' + i + '" style="margin-top: 10px;" class="btn btn-success" onclick="addComm_num()" value="เพิ่มเลขคำสั่ง" />' + '&nbsp;&nbsp;&nbsp;&nbsp;' +
                //                 '<input type="button" id="rem_kid()_' + i + '" style="margin-top: 10px;" class="btn btn-danger" onclick="remaddComm_num(this)" value="ลบเลขคำสั่ง" /><hr/>';

                console.log(document.getElementById('AnnounceNo').appendChild(div));
            }

            function remaddCaddAnnounce(div) {
                // console.log(div);
                // var list=document.getElementById("div2");
                // list.parentNode.removeChild(list);
                console.log(document.getElementById('AnnounceNo').removeChild(div.parentNode));
                i--;
            }

        </script>
@endsection
@section('custom-js-code')
    <script>
        $(function (){
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
        });
    </script>
@endsection
