
 
<?php $__env->startSection('title'); ?> <?php echo e($pageTitle); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('backend/css/lightbox-popup.css')); ?>">
     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-users"></i> <?php echo e($pageTitle); ?></h1>
        </div>
        <div>
        <a href="<?php echo e(route('admin.stuff.create')); ?>" class="btn btn-primary pull-right">Add Stuff</a>
        </div>
    </div>
    <?php echo $__env->make('admin.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body overflow-auto">
                    <table class="table table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Image </th>
                                <th> Employee Name </th>
                                <th> Designation </th>
                                <th> Subjects</th>
                                
                                <th> Contract Type</th>
                                <th> Phone Number </th>
                                <th> Status</th>
                                <th> Last Update </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $stuff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           
                                    <tr>
                                        <td><?php echo e($loop->index+1); ?></td>
                                        <td>
                                            <div class="popup-gallery">
                                                <a href="<?php echo asset('public/storage/'.$course->image); ?>" title="<?php echo e($course->name); ?>">
                                                    <img src="<?php echo asset('public/storage/'.$course->image); ?>" alt="!"  height="70">
                                                </a>
                                            </div>
                                            
                                        </td>
                                        <td><?php echo e($course->name); ?> </td>
                                        <td>
                                            <?php echo e($course->designation); ?>

                                        </td>
                                        <td>
                                            <?php echo e($course->subject); ?>

                                        </td>
                                        
                                        <td>
                                            <?php if($course->contactType == 1): ?>
                                                Permanent
                                            <?php elseif($course->contactType == 2): ?>
                                                Intern
                                            
                                            <?php elseif($course->contactType == 3): ?>
                                                Contractual
                                            
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php echo e($course->phone); ?>

                                        </td>
                                        <td>
                                            <?php
                                            if($course->IsActive == 1){
                                                $status = "<span class='text-success'>Active</span>";
                                            }
                                            elseif($course->IsActive == 2){
                                                $status = "<span class='text-info'>Postponded</span>";
                                            }
                                            elseif($course->IsActive == 3){
                                                $status = "<span class='text-danger'>Restricted</span>";
                                            }
                                            ?>
                                            <b><?php echo $status; ?></b>
                                    </td>
                                        <td>
                                        <?php
                                            $date = strtotime($course->updated_at);
                                            $updateDate = date('d-M-y', $date);
                                        ?>    
                                        <?php echo e($updateDate); ?>

                                    </td>
                                       
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                
                                                <a href="<?php echo e(route('admin.stuff.view', $course->id)); ?>" class="btn btn-sm btn-info" title="View Student"><i class="fa fa-eye"></i></a>
                                                <?php if($course->IsRegister == 1): ?>
                                                
                                                <?php endif; ?>
                                                <a href="<?php echo e(route('admin.stuff.edit', $course->id)); ?>" class="btn btn-sm btn-primary" title="Edit Student Information"><i class="fa fa-edit"></i></a>
                                               
                                                <a href="<?php echo e(route('admin.stuff.delete', $course->id)); ?>" class="btn btn-sm btn-danger" title="Delete Student Information"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript" src="<?php echo e(asset('backend/vendor/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')); ?>"></script>
   <script type="text/javascript">$('#sampleTable').DataTable({order: [[1, 'desc']],});</script>
   <script type="text/javascript" src="<?php echo e(asset('backend/js/lightbox-popup.min.js')); ?>"></script>
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
<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/stuff/index.blade.php ENDPATH**/ ?>