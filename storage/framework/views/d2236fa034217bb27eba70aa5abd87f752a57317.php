<?php $__env->startSection('custom-css-script'); ?>
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo e(asset('bower_components/select2/dist/css/select2.min.css')); ?>">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="<?php echo e(asset('bower_components/admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')); ?>">
<!-- Toastr -->
<link rel="stylesheet" href="<?php echo e(asset('bower_components/admin-lte/plugins/toastr/toastr.min.css')); ?>">
<!-- DataTables -->
<link rel="stylesheet" href="<?php echo e(asset('bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')); ?>">

<?php use App\CmsHelper as CmsHelper; ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('custom-css'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
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
      <div class="col-12 col-sm-12">
        <div class="card">
          <div class="card-body">
            <form class="form-group" action="<?php echo e(route('ddcdrive.act_upload_file')); ?>" method="post" enctype="multipart/form-data">
              <?php echo csrf_field(); ?>
              <div class="form-group row">
                <label for="inputEmail3" class="col-sm-3 col-form-label">กรุณาเลือกไฟล์</label>
                <div class="col-sm-9">
                  <input type="file" id="customFile" name="customFile" class="mr-2" required>
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-3 col-form-label">รายละเอียด/คำอธิบายของไฟล์</label>
                <div class="col-sm-9">
                  <input type="text" autocomplete="off" maxlength="150" class="form-control" name="files_description" placeholder="รายละเอียดหรือคำอธิบายของไฟล์" />
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-12">
                  <p class="text-info">รองรับไฟล์ : jpg,png,gif,pdf,doc,docx,xls,xlsx,csv,txt,ppt,pptx ขนาดไม่เกิน 20MB</p>
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

    <div class="row">
      <div class="col-12 col-sm-12">
            <div class="card card-primary card-outline card-outline-tabs">
              <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                  <li class="nav-item">
                    <a onClick="window.location.href='<?php echo e(route('ddcdrive.myfiles')); ?>';" class="nav-link <?php echo e(active_route('ddcdrive.myfiles')); ?>" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true"><i class="fas fa-folder-open"></i> ไฟล์ของฉัน</a>
                  </li>
                  <li class="nav-item">
                    <a onClick="window.location.href='<?php echo e(route('ddcdrive.files-shareprivate')); ?>';" class="nav-link <?php echo e(active_route('ddcdrive.files-shareprivate')); ?>" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false"><i class="fas fa-share-alt"></i> ไฟล์แชร์ถึงฉัน</a>
                  </li>
                  <li class="nav-item">
                    <a onClick="window.location.href='<?php echo e(route('ddcdrive.files-sharegroup')); ?>';" class="nav-link <?php echo e(active_route('ddcdrive.files-sharegroup')); ?>" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false"><i class="fas fa-users"></i> ไฟล์แชร์กลุ่มงานของฉัน</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                  <div class="tab-pane fade <?php if(Active::checkBoolean('ddcdrive/Myfiles') ): ?> active show <?php endif; ?>" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                    <?php echo $__env->make('ddcdrive::data-table-layout.my_files_upload', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  </div>
                  <div class="tab-pane fade <?php if(Active::checkBoolean('ddcdrive/Files-SharePrivate') ): ?> active show <?php endif; ?>" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                    <?php echo $__env->make('ddcdrive::data-table-layout.my_files_private_share', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  </div>
                  <div class="tab-pane fade <?php if(Active::checkBoolean('ddcdrive/Files-ShareGroup') ): ?> active show <?php endif; ?>" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                    <?php echo $__env->make('ddcdrive::data-table-layout.my_files_group_share', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('custom-js-script'); ?>
<!-- DataTables -->
<script src="<?php echo e(asset('bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('bower_components/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(asset('bower_components/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(asset('bower_components/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(asset('bower_components/select2/dist/js/select2.full.js')); ?>"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Toastr -->
<script src="<?php echo e(asset('bower_components/admin-lte/plugins/toastr/toastr.min.js')); ?>"></script>
<!-- Cilpboard -->
<script src="//cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.4.0/clipboard.min.js"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('custom-js-code'); ?>
<!-- page script -->
<script>
  $(function () {

    new Clipboard('#share-button');


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

    <?php if($message = Session::get('success')): ?>
    toastr.success('<?php echo $message; ?>')
    <?php endif; ?>
    <?php if($message = Session::get('warning')): ?>
    toastr.warning('<?php echo $message; ?>')
    <?php endif; ?>
    <?php if($message = Session::get('error')): ?>
    toastr.error('<?php echo $message; ?>')
    <?php endif; ?>

    $('[data-toggle="tooltip"]').tooltip()
    $('#my_files_upload').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
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
     },
    "columnDefs": [
      { "width": "320px", "targets": 0 },
      { "width": "170px", "targets": 1 },
    ]
    });
    $('#my_files_private').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
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
    $('#my_files_share').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
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

    $('.delete-confirm').click(function(event) {
      var form =  $(this).closest("form");
      var file_id = $(this).data("fileid");
      var filename = $(this).data("filename");
      var foldername = $(this).data("foldername");
      var rowId = $(this).data("tbdel");

      Swal.fire({
          title: 'ยืนยันการลบไฟล์'+'\n'+filename+' ?',
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
                        url : "<?php echo e(route('ddcdrive.deletefile')); ?>",
                        type : "POST",
                        data : {'file_id' : file_id,'foldername' : foldername,"_token": "<?php echo e(csrf_token()); ?>",},
                        success: function(data){
                            if(data.status == 'ok'){
                              toastr.success('ลบไฟล์ '+filename+' สำเร็จ')
                              $('#' + rowId).remove();
                                // window.setTimeout(function(){
                                //     location.reload();
                                // } ,2000);
                            }else{
                              toastr.error('ลบไฟล์ '+filename+' ไม่สำเร็จ error=>'+data.status)
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('ddcdrive::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Modules/DDCDrive/Resources/views/index.blade.php ENDPATH**/ ?>