
 
<?php $__env->startSection('title'); ?> <?php echo e($pageTitle); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('backend/css/lightbox-popup.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('backend/css/mignify.css')); ?>" >
     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="far fa-credit-card"></i> <?php echo e($pageTitle); ?></h1>
        </div>
        <div>
        <a href="<?php echo e(route('admin.expance.create')); ?>" class="btn btn-primary pull-right">Add Expanse</a>
        <a href="<?php echo e(route('admin.expance.index')); ?>" class="btn btn-danger pull-right">All Expanse</a>
        </div>
    </div>
    <?php echo $__env->make('admin.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-md-4">
            <div class="tile">
                <div class="tile-body">
                    <?php if(isset($targetData->image)): ?>
                    <a data-magnify="gallery" data-src="" data-caption="<?php echo e($targetData->title); ?>" data-group="a"
                    href="<?php echo e(asset('public/storage/'.$targetData->image)); ?>">
    <img src="<?php echo e(asset('public/storage/'.$targetData->image)); ?>" class="rounded  img-thumbnail" alt="..." width="100%">
  </a>
  <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-8">
            <div class="tile">
                <div class="tile-body">
                    <div class="card-body">  
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Expanse Categoris : </p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><?php echo e($targetData->exCategoris->category); ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Invoice No : </p>
                            </div>
                            <div class="col-sm-3">
                                <p class="text-muted mb-0"><?php echo e($targetData->invoiceID); ?></p>
                            </div>
                            <div class="col-sm-3">
                                <p class="mb-0">Invoice Date : </p>
                            </div>
                            <div class="col-sm-3">
                                <p class="text-muted mb-0">
                                    <?php
                                        $buyDate = strtotime($targetData->invoiceDate);
                                        $buyDate = date('d-M-y', $buyDate);
                                    ?>    
                                    <?php echo e($buyDate); ?> 
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3 col-md-3">
                            <p class="mb-0">Buyer / Recever Name : </p>
                            </div>
                            <div class="col-sm-9 col-md-9">
                                <p class="text-muted mb-0">
                                   <?php echo e($targetData->recever); ?> 
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3 col-md-3">
                            <p class="mb-0">Seller / Shop Name : </p>
                            </div>
                            <div class="col-sm-9 col-md-9">
                                <p class="text-muted mb-0">
                                   <?php echo e($targetData->seller); ?> 
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3 col-md-3">
                            <p class="mb-0">Invoice Title : </p>
                            </div>
                            <div class="col-sm-9 col-md-9">
                                <p class="text-muted mb-0">
                                   <?php echo e($targetData->title); ?> 
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                            <p class="mb-0">Description : </p>
                            </div>
                            
                            <div class="col-sm-12 col-md-10 offset-md-2">
                                <p class="text-muted mb-0">
                                   <?php echo $targetData->description; ?> 
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Create Date: </p>
                            </div>
                            <div class="col-sm-3">
                                <p class="text-muted mb-0">
                                    <?php
                                        $createDate = strtotime($targetData->createDate);
                                        $createDate = date('d-M-y', $createDate);
                                    ?>    
                                    <?php echo e($createDate); ?> 
                                   
                                </p>
                            </div>
                            <div class="col-sm-3">
                                <p class="mb-0">Status : </p>
                            </div>
                            <div class="col-sm-3">
                                <p class="text-muted mb-0">
                                    <?php
                                    if($targetData->IsActive == 1){
                                        $status = "<span class='text-warning'>Pending</span>";
                                    }
                                    elseif($targetData->IsActive == 2){
                                        $status = "<span class='text-success'>Accept</span>";
                                    }
                                    elseif($targetData->IsActive == 3){
                                        $status = "<span class='text-danger'>Restricted</span>";
                                    }
                                    ?>
                                    <b><?php echo $status; ?>

                                </p>
                                
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="visible-print text-center">
                
                
                
              
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript" src="<?php echo e(asset('backend/vendor/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')); ?>"></script>
   <script type="text/javascript">$('#sampleTable').DataTable({order: [[1, 'desc']],});</script>
   <script type="text/javascript" src="<?php echo e(asset('backend/js/lightbox-popup.min.js')); ?>"></script>
   <script type="text/javascript" src="<?php echo e(asset('backend/js/mignify.js')); ?>"></script>
   <!-- jQuery JS CDN -->
   <script>
    $(document).ready(function() {
        $('.popup-gallery').magnificPopup({
            delegate: 'a',
            type: 'image',
            tLoading: 'Loading image #%curr%...',
            mainClass: 'mfp-img-mobile',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0,1] // Will preload 0 - before current, and 1 after the current image
            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                titleSrc: function(item) {
                    return item.el.attr('title');
                }
            }
        });
    });
   </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/expance/show.blade.php ENDPATH**/ ?>