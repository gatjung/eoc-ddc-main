<?php use App\CmsHelper as CmsHelper; ?>
        <table id="my_files_share" class="table table-striped table-bordered">
                <thead>
                <tr>
                  <th>ชื่อไฟล์</th>
                  <th>รายละเอียด/คำอธิบาย</th>
                  <th>วันที่แชร์</th>
                  <th>เจ้าของไฟล์</th>
                  <th>จัดการไฟล์</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $list_my_files_share_group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $my_files_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td><?php echo e($my_files_group->file_ori_name); ?></td>
                  <td><?php if(isset($my_files_group->files_description)): ?> <?php echo e($my_files_group->files_description); ?> <?php else: ?> - <?php endif; ?></td>
                  <td><?php echo e(CmsHelper::formatDateThai($my_files_group->created_at)); ?></td>
                  <td><?php echo e($my_files_group->name_th); ?> <?php echo e($my_files_group->lname_th); ?></td>
                  <td>
                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="ดาวน์โหลดไฟล์">
                      <a href="<?php echo e(route('ddcdrive.downloadfile', ['file_folder_name' => $my_files_group->file_folder_name , 'file_id' => $my_files_group->file_id ,'st' =>'group' ])); ?>" type="button" class="my_link btn btn-success my-1"><i class="fas fa-download"></i></a>
                    </span>
                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="แชร์ไฟล์ถึงบุคคล">
                      <a href="<?php echo e(route('ddcdrive.form.addprivate.permission', [$my_files_group->file_id, 'status'=>'grouptoprivate'])); ?>" type="button" class="my_link btn btn-primary my-1"><i class="fas fa-user"></i></a>
                    </span>
                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="แชร์ไฟล์ถึงกลุ่มงาน">
                      <a href="<?php echo e(route('ddcdrive.form.addgroup.permission', [$my_files_group->file_id, 'status'=>'grouptogroup'])); ?>" type="button" class="my_link btn btn-info my-1"><i class="fas fa-users"></i></a>
                    </span>
                  </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>ชื่อไฟล์</th>
                  <th>รายละเอียด/คำอธิบาย</th>
                  <th>วันที่แชร์</th>
                  <th>เจ้าของไฟล์</th>
                  <th>จัดการไฟล์</th>
                </tr>
                </tfoot>
          </table>
<?php /**PATH /var/www/Modules/DDCDrive/Resources/views/data-table-layout/my_files_group_share.blade.php ENDPATH**/ ?>