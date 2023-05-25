<div class="sidebar">


  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
      <li class="nav-item">
        <a href="<?php echo e(route('commandIC.index')); ?>" class="nav-link <?php echo e(active_route('commandIC.index')); ?>">
          <i class="nav-icon fas fa-exclamation"></i>
          <p>คำสั่งการ</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo e(route('work_io')); ?>" class="nav-link <?php echo e(active_route('work_io')); ?>">
          <i class="nav-icon fas fa-business-time"></i>
          <p>ลงเวลาเข้า-ออก</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo e(route('ddcdrive.myfiles')); ?>" class="nav-link <?php echo e(active_route('ddcdrive.*')); ?> ">
          <i class="nav-icon fas fa-hdd"></i>
          <p>DDCDrive-ระบบแชร์ไฟล์</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo e(route('announce.index')); ?>" class="nav-link <?php echo e(active_route('announce.*')); ?> ">
          <i class="nav-icon fas fa-bullhorn"></i>
          <p>Assistance-แจ้งนัดประชุม</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo e(route('feedback.index')); ?>" class="nav-link <?php echo e(active_route('feedback.*')); ?> ">
          <i class="nav-icon far fa-comment-alt"></i>
          <p>ข้อเสนอแนะ</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo e(route('chatgrouproom_all')); ?>" target="_blank" class="nav-link <?php echo e(active_route('chatgrouproom_all')); ?> ">
          <i class="nav-icon far fa-comment-dots"></i>
          <p>Chatroom</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="https://www.youtube.com/channel/UCXgD1bkMgygi226vaE8cNbg/" target="_blank" class="nav-link">
          <i class="nav-icon fas fa-book"></i>
          <p>คู่มือการใช้งานออนไลน์</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo e(route('morchana')); ?>" class="nav-link <?php echo e(active_route('morchana')); ?>">
          <i class="nav-icon fas fa-book"></i>
          <p>การขอใช้ข้อมูลหมอชนะ</p>
        </a>
      </li>
      <?php if(auth()->check() && auth()->user()->hasRole('ส่วนกลาง-กลุ่มภารกิจเทคโนโลยีดิจิทัล|ส่วนกลาง-กลุ่มภารกิจกำลังคน')): ?>
      <li class="nav-header">Human Resource</li>


      <li class="nav-item <?php if(Active::checkBoolean('hr/*',true) ): ?> menu-open <?php endif; ?>">
        <a href="#" class="nav-link <?php echo e(active_check('hr/*',true)); ?>">
          <i class="nav-icon fas fa-users"></i>
          <p>
            ข้อมูลบุคลากร
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-circle text-info"></i>
              <p>แดชบอร์ดบุคลากร</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo e(route('users.index')); ?>" class="nav-link <?php echo e(active_route('users.index')); ?>">
              <i class="nav-icon far fa-circle text-info"></i>
              <p>รายชื่อบุคลากร</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo e(route('roles.index')); ?>" class="nav-link <?php echo e(active_route('roles.index')); ?>">
              <i class="nav-icon far fa-circle text-info"></i>
              <p>จัดการกลุ่ม</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo e(route('permission.index')); ?>" class="nav-link <?php echo e(active_route('permission.index')); ?>">
              <i class="nav-icon far fa-circle text-info"></i>
              <p>จัดการสิทธิ์</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo e(route('prefix.index')); ?>" class="nav-link <?php echo e(active_route('prefix.index')); ?>">
              <i class="nav-icon far fa-circle text-info"></i>
              <p>จัดการคำนำหน้าชื่อ</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo e(route('register')); ?>" class="nav-link">
              <i class="nav-icon far fa-circle text-info"></i>
              <p>เพิ่มสมาชิก</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo e(route('course.index')); ?>" class="nav-link <?php echo e(active_route('course.index')); ?>">
              <i class="nav-icon far fa-circle text-info"></i>
              <p>จัดการหลักสูตร</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo e(route('joblevel.index')); ?>" class="nav-link <?php echo e(active_route('joblevel.index')); ?>">
              <i class="nav-icon far fa-circle text-info"></i>
              <p>จัดการระดับ</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo e(route('commandlist.index')); ?>" class="nav-link <?php echo e(active_route('commandlist.index')); ?>">
              <i class="nav-icon far fa-circle text-info"></i>
              <p>จัดการเลขคำสั่ง</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo e(route('position.index')); ?>" class="nav-link <?php echo e(active_route('position.index')); ?>">
              <i class="nav-icon far fa-circle text-info"></i>
              <p>จัดการตำแหน่ง</p>
            </a>
          </li>
        </ul>
      </li>
      <?php endif; ?>
      <?php if(auth()->check() && auth()->user()->hasRole('ส่วนกลาง-กลุ่มภารกิจการจัดการศูนย์ปฏิบัติการภาวะฉุกเฉิน|ส่วนกลาง-กลุ่มภารกิจเทคโนโลยีดิจิทัล')): ?>
      <li class="nav-header">Meeting</li>
      <li class="nav-item <?php if(Active::checkBoolean('meeting/*',true) ): ?> menu-open <?php endif; ?>">
        <a href="#" class="nav-link <?php echo e(active_check('meeting/*',true)); ?>">
          <i class="nav-icon fas fa-handshake"></i>
          <p>
            การประชุม
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <!-- <li class="nav-item">
            <a href="<?php echo e(route('meeting.home')); ?>" class="nav-link">
              <i class="nav-icon far fa-circle text-success"></i>
              <p>ปฎิทิน</p>
            </a>
          </li> -->
          <li class="nav-item">
            <a href="<?php echo e(route('meeting.order')); ?>" class="nav-link <?php echo e(active_route('meeting.order')); ?>">
              <i class="nav-icon far fa-circle text-success"></i>
              <p>เพิ่มคำสั่งการ</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo e(route('meeting.list')); ?>" class="nav-link <?php echo e(active_route('meeting.list')); ?>">
              <i class="nav-icon far fa-circle text-success"></i>
              <p>รายการคำสั่งการ</p>
            </a>
          </li>
          <!-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-circle text-success"></i>
              <p>เอกสารการประชุม</p>
            </a>
          </li> -->
        </ul>
      </li>
  <?php endif; ?>
  <li class="nav-header">Assign & Task Tracking</li>
      <!-- สิทธิ์การมองเห็นหัวหน้ากล่อง -->
    <?php if(Auth::user()->emp_level != '2'): ?>
      <li class="nav-item <?php if(Active::checkBoolean('assign',true) ): ?> menu-open <?php endif; ?>">
        <a href="#" class="nav-link <?php echo e(active_check('assign',true)); ?>">
          <i class="nav-icon fas fa-user-check"></i>
          <p>
            การมอบหมายงาน
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>

        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?php echo e(route('page.assign')); ?>" class="nav-link <?php echo e(active_route('page.assign')); ?>">
              <i class="far fa-circle nav-icon text-warning"></i>
              <p> รอพิจารณา </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo e(route('page.completed')); ?>" class="nav-link <?php echo e(active_route('page.completed')); ?>">
              <i class="far fa-circle nav-icon text-warning"></i>
              <p> มอบหมายไปแล้ว </p>
            </a>
          </li>
        </ul>
      </li>
      <?php endif; ?>

      <li class="nav-item <?php if(Active::checkBoolean('task',true) ): ?> menu-open <?php endif; ?>">
        <a href="#" class="nav-link <?php echo e(active_check('task',true)); ?>">
          <i class="nav-icon fas fa-tasks"></i>
          <p>
            การติดตามงาน
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">


           <!-- ดูได้ทั้งหมด eoc + ic  -->
           <?php if(auth()->check() && auth()->user()->hasRole('ส่วนกลาง-กลุ่มภารกิจการจัดการศูนย์ปฏิบัติการภาวะฉุกเฉิน')): ?>
          <li class="nav-item">
          <a href="<?php echo e(route('task_eoc')); ?>" class="nav-link <?php echo e(active_route('task_eoc')); ?>">
              <i class="far fa-circle nav-icon text-danger"></i>
              <p>ติดตามงาน (EOC)</p>
            </a>
          </li>
          <?php endif; ?>

          <!-- หัวหน้ากล่อง ผอ.-->
          <?php if(Auth::user()->emp_level == '3'): ?>
          <li class="nav-item">
          <a href="<?php echo e(route('task_index')); ?>" class="nav-link <?php echo e(active_route('task_index')); ?>">
              <i class="far fa-circle nav-icon text-danger"></i>
              <p>ติดตามงาน (MGR)</p>
            </a>
          </li>
          <?php endif; ?>

        <!-- หัวหน้างาน ex.พี่วิทย์ พี่เหน่ง -->
          <?php if(Auth::user()->emp_level == '3'): ?>
          <li class="nav-item">
          <a href="<?php echo e(route('task_approved')); ?>" class="nav-link <?php echo e(active_check('task/supervisor/approved*',true)); ?>">
              <i class="far fa-circle nav-icon text-danger"></i>
              <p>การตรวจสอบ (MGR)</p>
            </a>
          </li>
          <?php endif; ?>

        <!-- ผู้ปฏิบัติงาน -->
          <?php if(Auth::user()->emp_level == '2' || '1'): ?>
          <li class="nav-item">
            <a href="<?php echo e(route('task_action')); ?>" class="nav-link <?php echo e(active_route('task_action')); ?>">
              <i class="far fa-circle nav-icon text-danger"></i>
              <p>ปฏิบัติงาน (User)</p>
            </a>
          </li>
          <?php endif; ?>

        </ul>
      </li>

      <li class="nav-header">Dashboard</li>
      <li class="nav-item <?php if(Active::checkBoolean('dataprocessing/*',true) ): ?> menu-open <?php endif; ?>">
        <a href="#" class="nav-link <?php echo e(active_check('dataprocessing/*',true)); ?>">
          <i class="nav-icon fas fa-tasks"></i>
          <p>
            รายงานผลแดชบอร์ด
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?php echo e(route('dashboard.task')); ?>" class="nav-link <?php echo e(active_route('dashboard.task')); ?>">
              <i class="far fa-circle nav-icon text-danger"></i>
              <p>แดชบอร์ด Task</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?php echo e(route('dashboard.hr')); ?>" class="nav-link <?php echo e(active_route('dashboard.hr')); ?>">
              <i class="far fa-circle nav-icon text-danger"></i>
              <p>แดชบอร์ด HR</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?php echo e(route('dashboardsat.thai')); ?>" class="nav-link <?php echo e(active_route('dashboardsat.thai')); ?>">
              <i class="far fa-circle nav-icon text-danger"></i>
              <p>สถานการณ์โรคโควิดไทย</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo e(route('dashboardsat.global')); ?>" class="nav-link <?php echo e(active_route('dashboardsat.global')); ?>">
              <i class="far fa-circle nav-icon text-danger"></i>
              <p>สถานการณ์โรคโควิดทั่วโลก</p>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-header">Team</li>
      <li class="nav-item">
        <a href="<?php echo e(route('teams_dev')); ?>" class="nav-link">
          <i class="nav-icon fas fa-laptop-code"></i>
          <p>ทีมพัฒนาระบบ</p>
        </a>
      </li>
      <?php if(auth()->check() && auth()->user()->hasRole('ส่วนกลาง-กลุ่มภารกิจเทคโนโลยีดิจิทัล')): ?>
      <li class="nav-header">Administrator</li>
      <li class="nav-item">
        <a href="<?php echo e(route('admin.logs')); ?>" target="_blank" class="nav-link">
          <i class="nav-icon fas fa-exclamation-circle"></i>
          <p>System-Error-Log</p>
        </a>
      </li>
      <?php endif; ?>
    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
<?php /**PATH /var/www/resources/views/main-ui/sidebar.blade.php ENDPATH**/ ?>