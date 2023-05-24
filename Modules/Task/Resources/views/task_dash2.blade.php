<div class="container-fluid">
  <div class="col-12">
    <div class="row">

      <div class="col-sm-3 ">
        <a href="{{ route('task_eoc') }}">
          <div class="info-box btn-outline-primary shadow">
            <span class="info-box-icon bg-gradient-primary  border"><i class="fas fa-tasks"></i></span>
            <div class="info-box-content">
              <span class="info-box-text text-bold pt-2">งานทั้งหมด</span>
              <span class="info-box-number h1">{{ empty($Count1)?'0': $Count1 }}</span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
      </div><!-- /.col -->

      <div class="col-sm-3">
        <a href="{{ route('task_eoc_pending') }}">
          <div class="info-box btn-outline-warning shadow">
            <span class="info-box-icon bg-gradient-warning  border"><i class="fas fa-battery-half"></i></span>
            <div class="info-box-content">
              <span class="info-box-text text-bold pt-2">อยู่ในระหว่างดำเนินงาน</span>
              <span class="info-box-number h1">{{ empty($Count2)?'0': $Count2 }}</span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
      </div><!-- /.col -->

      <div class="col-sm-3">
      <a href="{{ route('task_eoc_success') }}">
        <div class="info-box btn-outline-success shadow">
          <span class="info-box-icon bg-gradient-success  border"><i class="fas fa-battery-full"></i></span>
          <div class="info-box-content">
            <span class="info-box-text text-bold pt-2">ดำเนินงานเสร็จสิ้น</span>
            <span class="info-box-number h1">{{ empty($Count3)?'0': $Count3 }}</span>
          </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
      </a>
      </div><!-- /.col -->

      <div class="col-sm-3">
      <a href="{{ route('task_eoc_overdue') }}">
        <div class="info-box btn-outline-danger shadow">
          <span class="info-box-icon bg-gradient-danger  border"><i class="fas fa-fire"></i></span>
          <div class="info-box-content">
            <span class="info-box-text text-bold pt-2">งานที่เกินกำหนด</span>
            <span class="info-box-number h1">{{ empty($Count4)?'0': $Count4 }}</span>
          </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
      </a>
      </div><!-- /.col -->

    </div>
  </div>
</div>