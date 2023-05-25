<?php $__env->startSection('custom-css-script'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('custom-css'); ?>
<!-- Ekko Lightbox -->
<link rel="stylesheet" href="../plugins/ekko-lightbox/ekko-lightbox.css">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>ทีมผู้พัฒนาระบบ DDC-ECOSYSTEM</h1>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card card-secondary">
            <div class="card-header">
              <h4 class="card-title">รายชื่อทีมผู้พัฒนาฯ</h4>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <div>
                    <div class="btn-group w-100 mb-2">
                      <a class="btn btn-primary active text-nowrap" href="javascript:void(0)" data-filter="all"> ทั้งหมด </a>
                      <a class="btn btn-warning text-nowrap" href="javascript:void(0)" data-filter="1"> Project Manager </a>
                      <a class="btn btn-danger text-nowrap" href="javascript:void(0)" data-filter="2"> Data Visualization </a>
                      <a class="btn btn-success text-nowrap" href="javascript:void(0)" data-filter="3"> Programer </a>
                      <a class="btn btn-info text-nowrap" href="javascript:void(0)" data-filter="4"> System Admin </a>
                  </div>
                </div>
              </table>
                <!-- <div class="mb-2">
                  <a class="btn btn-secondary" href="javascript:void(0)" data-shuffle> Shuffle items </a>
                  <div class="float-right">
                    <select class="custom-select" style="width: auto;" data-sortOrder>
                      <option value="index"> Sort by Position </option>
                      <option value="sortData"> Sort by Custom Data </option>
                    </select>
                    <div class="btn-group">
                      <a class="btn btn-default" href="javascript:void(0)" data-sortAsc> Ascending </a>
                      <a class="btn btn-default" href="javascript:void(0)" data-sortDesc> Descending </a>
                    </div>
                  </div>
                </div> -->
              </div>

              <!-- <div> 155 -->

                <div class="filter-container p-0 row">
                  <div class="filtr-item col-sm-4" data-category="1" data-sort="white sample">
                    <a href="<?php echo e(asset('teams/phat.jpg')); ?>" data-toggle="lightbox" data-title="Project Manager">
                      <img src="<?php echo e(asset('teams/phat.jpg')); ?>" class="img-thumbnail" alt="Cinque Terre">
                    </a>
                  </div>
                  <div class="filtr-item col-sm-4" data-category="1" data-sort="black sample">
                    <a href="<?php echo e(asset('teams/vit.jpg')); ?>" data-toggle="lightbox" data-title="Co Project Manager">
                      <img src="<?php echo e(asset('teams/vit.jpg')); ?>" class="img-thumbnail" alt="Cinque Terre">
                    </a>
                  </div>
                  <div class="filtr-item col-sm-4" data-category="2" data-sort="red sample">
                    <a href="<?php echo e(asset('teams/por.jpg')); ?>" data-toggle="lightbox" data-title="Data Visualization">
                      <img src="<?php echo e(asset('teams/por.jpg')); ?>" class="img-thumbnail" alt="Cinque Terre">
                    </a>
                  </div>
                  <div class="filtr-item col-sm-4" data-category="2" data-sort="red sample">
                    <a href="<?php echo e(asset('teams/ae.jpg')); ?>" data-toggle="lightbox" data-title="Data Visualization">
                      <img src="<?php echo e(asset('teams/ae.jpg')); ?>" class="img-thumbnail" alt="Cinque Terre">
                    </a>
                  </div>
                  <div class="filtr-item col-sm-4" data-category="2" data-sort="black sample">
                    <a href="<?php echo e(asset('teams/new.jpg')); ?>" data-toggle="lightbox" data-title="Data Visualization">
                      <img src="<?php echo e(asset('teams/new.jpg')); ?>" class="img-thumbnail" alt="Cinque Terre">
                    </a>
                  </div>
                  <div class="filtr-item col-sm-4" data-category="2" data-sort="white sample">
                    <a href="<?php echo e(asset('teams/kwang.jpg')); ?>" data-toggle="lightbox" data-title="Data Visualization">
                      <img src="<?php echo e(asset('teams/kwang.jpg')); ?>" class="img-thumbnail" alt="Cinque Terre">
                    </a>
                  </div>
                  <div class="filtr-item col-sm-4" data-category="2" data-sort="white sample">
                    <a href="<?php echo e(asset('teams/jo.jpg')); ?>" data-toggle="lightbox" data-title="Data Visualization">
                      <img src="<?php echo e(asset('teams/jo.jpg')); ?>" class="img-thumbnail" alt="Cinque Terre">
                    </a>
                  </div>
                  <div class="filtr-item col-sm-4" data-category="3" data-sort="black sample">
                    <a href="<?php echo e(asset('teams/lay.jpg')); ?>" data-toggle="lightbox" data-title="Programer">
                      <img src="<?php echo e(asset('teams/lay.jpg')); ?>" class="img-thumbnail" alt="Cinque Terre">
                    </a>
                  </div>
                  <div class="filtr-item col-sm-4" data-category="3" data-sort="red sample">
                    <a href="<?php echo e(asset('teams/mod.jpg')); ?>" data-toggle="lightbox" data-title="Programer">
                      <img src="<?php echo e(asset('teams/mod.jpg')); ?>" class="img-thumbnail" alt="Cinque Terre">
                    </a>
                  </div>
                  <div class="filtr-item col-sm-4" data-category="3" data-sort="white sample">
                    <a href="<?php echo e(asset('teams/nack.jpg')); ?>" data-toggle="lightbox" data-title="Programer">
                      <img src="<?php echo e(asset('teams/nack.jpg')); ?>" class="img-thumbnail" alt="Cinque Terre">
                    </a>
                  </div>
                  <div class="filtr-item col-sm-4" data-category="3" data-sort="white sample">
                    <a href="<?php echo e(asset('teams/naung.jpg')); ?>" data-toggle="lightbox" data-title="Programer">
                      <img src="<?php echo e(asset('teams/naung.jpg')); ?>" class="img-thumbnail" alt="Cinque Terre">
                    </a>
                  </div>
                  <div class="filtr-item col-sm-4" data-category="3" data-sort="black sample">
                    <a href="<?php echo e(asset('teams/arm.jpg')); ?>" data-toggle="lightbox" data-title="Programer">
                      <img src="<?php echo e(asset('teams/arm.jpg')); ?>" class="img-thumbnail" alt="Cinque Terre">
                    </a>
                  </div>
                  <div class="filtr-item col-sm-4" data-category="3" data-sort="black sample">
                    <a href="<?php echo e(asset('teams/sab.jpg')); ?>" data-toggle="lightbox" data-title="Programer">
                      <img src="<?php echo e(asset('teams/sab.jpg')); ?>" class="img-thumbnail" alt="Cinque Terre">
                    </a>
                  </div>
                  <div class="filtr-item col-sm-4" data-category="3" data-sort="white sample">
                    <a href="<?php echo e(asset('teams/care.jpg')); ?>" data-toggle="lightbox" data-title="Programer">
                      <img src="<?php echo e(asset('teams/care.jpg')); ?>" class="img-thumbnail" alt="Cinque Terre">
                    </a>
                  </div>
                  <div class="filtr-item col-sm-4" data-category="3" data-sort="red sample">
                    <a href="<?php echo e(asset('teams/aun.jpg')); ?>" data-toggle="lightbox" data-title="Programer">
                      <img src="<?php echo e(asset('teams/aun.jpg')); ?>" class="img-thumbnail" alt="Cinque Terre">
                    </a>
                  </div>
                  <div class="filtr-item col-sm-4" data-category="3" data-sort="black sample">
                    <a href="<?php echo e(asset('teams/golf.jpg')); ?>" data-toggle="lightbox" data-title="Programer">
                      <img src="<?php echo e(asset('teams/golf.jpg')); ?>" class="img-thumbnail" alt="Cinque Terre">
                    </a>
                  </div>
                  <div class="filtr-item col-sm-4" data-category="3" data-sort="white sample">
                    <a href="<?php echo e(asset('teams/aum.jpg')); ?>" data-toggle="lightbox" data-title="Programer">
                      <img src="<?php echo e(asset('teams/aum.jpg')); ?>" class="img-thumbnail" alt="Cinque Terre">
                    </a>
                  </div>
                  <div class="filtr-item col-sm-4" data-category="3" data-sort="red sample">
                    <a href="<?php echo e(asset('teams/keng.jpg')); ?>" data-toggle="lightbox" data-title="Programer">
                      <img src="<?php echo e(asset('teams/keng.jpg')); ?>" class="img-thumbnail" alt="Cinque Terre">
                    </a>
                  </div>
                  <div class="filtr-item col-sm-4" data-category="4" data-sort="red sample">
                    <a href="<?php echo e(asset('teams/plam.jpg')); ?>" data-toggle="lightbox" data-title="System Admin">
                      <img src="<?php echo e(asset('teams/plam.jpg')); ?>" class="img-thumbnail" alt="Cinque Terre">
                    </a>
                  </div>

                </div>

              <!-- </div> 54 -->

            </div>
          </div>
        </div>

      </div>
    </div><!-- /.container-fluid -->
  </section>

<!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('custom-js-script'); ?>
<!-- Ekko Lightbox -->
<script src="../plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<!-- Filterizr-->
<script src="../plugins/filterizr/jquery.filterizr.min.js"></script>
<script>
  $(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });

    $('.filter-container').filterizr({gutterPixels: 3});
    $('.btn[data-filter]').on('click', function() {
      $('.btn[data-filter]').removeClass('active');
      $(this).addClass('active');
    });
  })
</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('custom-js-code'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('member::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Modules/Member/Resources/views/frontend/teams.blade.php ENDPATH**/ ?>