<?php
    use App\CmsHelper as CmsHelper;

    $position_th_arr = CmsHelper::Get_Position_TH();
    $organization_th_arr = CmsHelper::Get_Organization_TH();
    $roles_th_arr = CmsHelper::Get_Roles_EN();
    $roles_name_th = CmsHelper::Get_Roles_TH2();
?>

@extends('hr::layouts.master')
@section('custom-css-script')
@stop
@section('custom-css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/toastr/toastr.min.css') }}">
@stop
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>จัดการผู้ใช้งาน</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><a class="btn btn-success" href="{{ route('register') }}">เพิ่มผู้ใช้งาน</a></h3>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{ route('users.index') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>ค้นหาชื่อ</strong>
                                    <input type="text" name="name_th" class="form-control" value="{{ $name_th }}">
                                </div>
                                <div class="col-md-3">
                                    <strong>ค้นหานามสกุล</strong>
                                    <input type="text" name="lname_th" class="form-control" value="{{ $lname_th }}">
                                </div>
                                <div class="col-md-3">
                                    <strong>ค้นหาหน่วยงาน</strong>
                                    <select class="form-control" name="organization">
                                        <option value="">-- กรุณาเลือก --</option>
                                        @foreach($organization as $value_organization)
                                            <option value="{{ $value_organization->organization }}" {{ $organization_select == $value_organization->organization ? 'selected' : '' }}>
                                                {{ $organization_th_arr[$value_organization->organization] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <strong>ค้นหากลุ่มงาน</strong>
                                    <select class="form-control" name="roles">
                                        <option value="">-- กรุณาเลือก --</option>
                                        @foreach($roles as $value_roles)
                                            <option value="{{ $value_roles->id }}" {{ $role_select == $value_roles->id ? 'selected' : '' }}>
                                                {{ $value_roles->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <strong>ค้นหาตำแหน่ง</strong>
                                    <select class="form-control" name="position">
                                        <option value="">-- กรุณาเลือก --</option>
                                        @foreach($position as $value_position)
                                            <option value="{{ $value_position->position }}" {{ $position_select == $value_position->position ? 'selected' : '' }}>
                                                {{ $position_th_arr[$value_position->position] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <strong>โทรศัพท์</strong>
                                    <input type="text" name="phone" class="form-control" value="{{ $phone }}">
                                </div>

                                <div class="col-md-3">
                                    <strong>ค้นหาสถานะการสมัครสมาชิก</strong>
                                    <select class="form-control" name="confirm">
                                        <option>-- กรุณาเลือก --</option>
                                        <option value="0" {{ $confirm_select == "0" ? 'selected' : '' }}>รอการยืนยันสมัครสมาชิก</option>
                                        <option value="1" {{ $confirm_select == "1" ? 'selected' : '' }}>สมัครสมาชิกแล้ว</option>
                                        <option value="2" {{ $confirm_select == "2" ? 'selected' : '' }}>ไม่มีชื่อในกลุ่มภารกิจ</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row" style="padding-top: 10px;">
                                <div class="col-md-12">
                                    <button  class="btn btn-primary float-right" id="submit" type="submit">
                                        ค้นหา
                                    </button>
                                </div>
                            </div>
                        </form>
                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                {{-- <a href="{{ route('users.export') }}" class="btn btn-info float-right">Export Excel</a> --}}
                                <div class="table-responsive">
                                    <table id="manageusers" class="table table-bordered table-sm table-hover table-striped ">
                                        <thead class="text-nowrap bg-gradient-blue">
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>ชื่อ - นามสกุล</th>
                                                <th>หน่วยงาน</th>
                                                <th>กลุ่มงาน</th>
                                                <th>ตำแหน่ง</th>
                                                <th>อีเมล</th>
                                                <th>โทรศัพท์</th>
                                                <th>ไลน์</th>
                                                <th>สถานะการสมัคร</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody class="text-nowrap">
                                            @php
                                                $i=1;
                                            @endphp
                                            @foreach ($data as $key)
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td class="text-nowrap">
                                                        {{ $key->name_th }} {{ $key->lname_th }}
                                                    </td>
            										<td>
                                                        {{ $organization_th_arr[$key->organization] }}
                                                    </td>
                                                    <td>{{ $roles_name_th[$key->roleID] }}</td>
                                                    <td>{{ $position_th_arr[$key->position] }}</td>
                                                    <td>{{ $key->email }}</td>
                                                    <td>{{ $key->phone }}</td>
                                                    <td>{{ $key->lineid }}</td>
                                                    <td>
                                                        @if($key->confirm == 1)
                                                            <strong style="color: green;">ยืนยันแล้ว</strong>
                                                            <button class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top"  title="ยกเลิกการสมัครสมาชิก">
                                                                <a href="{{ route('users.approve', [0, $key->id, $key->email]) }}">
                                                                    <i class="fas fa-cancel" style="color: white;"></i>
                                                                    <strong style="color: white;">ยกเลิกสมาชิก</strong>
                                                                </a>
                                                            </button>
                                                        @elseif($key->confirm == 0 || $key->confirm == 2)
                                                            @if ($key->confirm == 0)
                                                                <strong style="color: orange;">รอการยืนยัน</strong>
                                                            @elseif ($key->confirm == 2)
                                                                <strong style="color: red;">ไม่มีชื่อในกลุ่มภาระกิจ</strong>
                                                            @endif
                                                            <button class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top"  title="ยืนยันสมัครสมาชิก">
                                                                <a href="{{ route('users.approve', [1, $key->id, $key->email]) }}">
                                                                    <i class="fas fa-cancel" style="color: white;"></i>
                                                                    <strong style="color: white;">ยืนยันสมาชิก</strong>
                                                                </a>
                                                            </button>
                                                        @endif
                                                    </td>
                                                    <td class="text-nowrap" style="text-align: center">
                                                      {{-- <form method="post" action="{{ route('users.show') }}" style="display:inline">
                                                       @csrf
                                                          <button type="submit" class="btn btn-info btn-sm rounded-circle" data-toggle="tooltip" data-placement="top"  title="แสดงข้อมูล"><i class="fas fa-eye"></i></button>
                                                        <input type="hidden" name="id" value="{{ $key->id }}">
                                                      </form> --}}


                                                        <button class="btn btn-primary btn-sm rounded-circle" data-toggle="tooltip" data-placement="top"  title="แก้ไข">
                                                            <a href="{{ route('users.edit', [$key->id]) }}"><i class="fas fa-edit" style="color: white;"></i></a>
                                                        </button>



                                                      {{-- <form method="POST" action="{{ route('users.destroy') }}" style="display:inline">
                                                            @csrf
                                                            <input name="_method" type="hidden" value="DELETE">
                                                            <input name="id" type="hidden" value="{{ $key->id }}">
                                                            <button type="submit" class="btn btn-danger btn-sm rounded-circle"
                                                                data-toggle="tooltip" data-placement="top" title="ลบ"
                                                                onclick="return confirm('ต้องการลบ {{ $key->name_th }} {{ $key->lname_th }} ใช่หรือไม่ ?');"><i
                                                                    class="far fa-trash-alt"></i></button>
                                                      </form> --}}
                                                    </td>
                                                </tr>
                                                @php
                                                    $i++;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('custom-js-script')

    <script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
    </script>

    <!-- DataTables -->
    <script src="{{ asset('bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Toastr -->
    <script src="{{ asset('bower_components/admin-lte/plugins/toastr/toastr.min.js') }}"></script>

@stop
@section('custom-js-code')

<script>
    $('#manageusers').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": false,
      "ordering": false,
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

    // SweetAlert2, Toastr
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

@stop
