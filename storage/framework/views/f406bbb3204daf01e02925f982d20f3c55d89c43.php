<?php use App\CmsHelper as CmsHelper; ?>
        <table id="my_files_upload" class="table table-striped table-bordered">
                <thead>
                <tr>
                  <th>ชื่อไฟล์</th>
                  <th>รายละเอียด/คำอธิบาย</th>
                  <th>วันที่อัพโหลด</th>
                  <th>จัดการไฟล์</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1; ?>
                <?php $__currentLoopData = $list_my_files_upload; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $my_files_upload): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr id="rowId<?php echo e($i); ?>">
                  <td>
                    <?php echo e($my_files_upload->file_ori_name); ?>

                    <a class="btn bg-gradient-info" id="share-button" data-toggle="tooltip" title="Copy ลิงก์ที่อยู่ แชร์เป็นแบบสาธารณะ" data-clipboard-text="<?php echo e(route('ddcdrive.mydownloadfile',['file_folder_name' => $my_files_upload->file_folder_name , 'file_id' => $my_files_upload->file_id ])); ?>">
                        <i class="fas fa-share-alt"></i>
                    </a>
                  </td>
                  <td><?php if(isset($my_files_upload->files_description)): ?> <?php echo e($my_files_upload->files_description); ?> <?php else: ?> - <?php endif; ?></td>
                  <td><?php echo e(CmsHelper::formatDateThai($my_files_upload->created_at)); ?></td>
                  <td>
                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="ดาวน์โหลดไฟล์">
                      <a href="<?php echo e(route('ddcdrive.mydownloadfile',['file_folder_name' => $my_files_upload->file_folder_name , 'file_id' => $my_files_upload->file_id ])); ?>" type="button" class="my_link btn btn-success my-1"><i class="fas fa-download"></i></a>
                    </span>

                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="แชร์ไฟล์ถึงบุคคล">
                      <a href="<?php echo e(route('ddcdrive.form.addprivate.permission', [$my_files_upload->file_id, 'status'=>'shareprivate'])); ?>" type="button" class="my_link btn btn-primary my-1"><i class="fas fa-user"></i></a>
                    </span>

                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="แชร์ไฟล์ถึงกลุ่มงาน">
                      <a href="<?php echo e(route('ddcdrive.form.addgroup.permission', [$my_files_upload->file_id, 'status'=>'sharegroup'])); ?>" type="button" class="my_link btn btn-info my-1"><i class="fas fa-users"></i></a>
                    </span>

                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="ลบไฟล์">
                      <button class="delete-confirm my_link btn btn-danger my-1" data-tbdel="rowId<?php echo e($i); ?>" data-fileid="<?php echo e($my_files_upload->file_id); ?>" data-filename="<?php echo e($my_files_upload->file_ori_name); ?>" data-foldername="<?php echo e($my_files_upload->file_folder_name); ?>" type="button"><i class="fas fa-trash-alt"></i></a>
                    </span>
                  </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>ชื่อไฟล์</th>
                  <th>รายละเอียด/คำอธิบาย</th>
                  <th>วันที่อัพโหลด</th>
                  <th>จัดการไฟล์</th>
                </tr>
                </tfoot>
          </table>
<?php /**PATH /var/www/Modules/DDCDrive/Resources/views/data-table-layout/my_files_upload.blade.php ENDPATH**/ ?>