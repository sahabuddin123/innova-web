
 
<?php $__env->startSection('title'); ?> <?php echo e($pageTitle); ?> <?php $__env->stopSection(); ?>
 
<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('backend/css/lightbox-popup.css')); ?>">
     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-users"></i> <?php echo e($pageTitle); ?></h1>
        </div>
        <div>
        <a href="<?php echo e(route('admin.shareholder.create')); ?>" class="btn btn-primary pull-right">Add New</a>
        </div>
    </div>
    <div id="flash_message"></div>
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
                                <th> Name </th>
                                <th> Designation </th>
                                <th> Investor Type </th>
                                <th> Status </th>
                                <th> Last Update </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $shareHolder; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->index+1); ?></td>
                                        <td>
                                            <?php if($course->image != ""): ?>
                                            <div class="popup-gallery">
                                                <a href="<?php echo asset('public/storage/'.$course->image); ?>" title="<?php echo e($course->name); ?>">
                                                    <img src="<?php echo asset('public/storage/'.$course->image); ?>" alt="!"  height="70">
                                                </a>
                                            </div>
                                            <?php else: ?>
                                                no image
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($course->name); ?> </td>
                                        <td><?php echo e($course->designation); ?> </td>
                                        <td>
                                            <?php if($course->shareType == 1): ?>
                                            <span class='text-success'>Shareholder</span>
                                            <?php elseif($course->shareType == 2): ?>
                                            <span class='text-success'>Investor</span>
                                            <?php elseif($course->shareType == 3): ?>
                                            <span class='text-success'>Owner</span>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <td>
                                            <?php
                                            if($course->isActive == 1){
                                                $status = "<span class='text-success'>Active</span>";
                                            }
                                            elseif($course->isActive == 2){
                                                $status = "<span class='text-info'>Pending</span>";
                                            }
                                            elseif($course->isActive == 3){
                                                $status = "<span class='text-primary'>Postponded</span>";
                                            }
                                            elseif($course->isActive == 0){
                                                $status = "<span class='text-danger'>Dactive</span>";
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
                                                <!-- Withdraw buttons: Investment & Dividend -->
                                                <a href="<?php echo e(route('admin.investment.withdraw.create', $course->id)); ?>" class="btn btn-sm btn-outline-success" title="Investment Withdraw"><i class="fa fa-money-bill"></i></a>
                                                <a href="<?php echo e(route('admin.dividend.withdraw.create', $course->id)); ?>" class="btn btn-sm btn-outline-info btn-open-withdraw" data-type="dividend" data-id="<?php echo e($course->id); ?>" title="Dividend Withdraw"><i class="fa fa-coins"></i></a>
                                                
                                                <a href="<?php echo e(route('admin.investment.create', $course->id)); ?>" class="btn btn-sm btn-warning" title="Make Investments"><i class="fas fa-money-bill"></i></a>
                                                <a href="<?php echo e(route('admin.investment.view', $course->id)); ?>" class="btn btn-sm btn-secondary" title="View Investments"><i class="fa fa-desktop"></i></a>
                                                <a href="<?php echo e(route('admin.investment.statement', $course->id)); ?>" class="btn btn-sm btn-success" title="Investment and withdrowal Statement"><i class="fa fa-file-alt"></i></a>
                                                <a href="<?php echo e(route('admin.shareholder.view', $course->id)); ?>" class="btn btn-sm btn-info" title="View"><i class="fa fa-eye"></i></a>
                                                <a href="<?php echo e(route('admin.shareholder.edit', $course->id)); ?>" class="btn btn-sm btn-primary" title="Edit Information"><i class="fa fa-edit"></i></a>
                                                <a href="<?php echo e(route('admin.shareholder.delete', $course->id)); ?>" class="btn btn-sm btn-danger" title="Delete Information"><i class="fa fa-trash"></i></a>
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
    <script type="text/javascript" src="<?php echo e(asset('backend/js/custom.js')); ?>"></script> 
    <script type="text/javascript" src="<?php echo e(asset('backend/vendor/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')); ?>"></script>
   <script type="text/javascript">$('#sampleTable').DataTable({order: [[0, 'asc']],});</script>
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
<!-- Modal to create withdraw -->
<div class="modal fade" id="createWithdrawModal" tabindex="-1" role="dialog" aria-labelledby="createWithdrawModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createWithdrawModalLabel">Create Withdraw</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="createWithdrawModalBody">
                <div class="text-center">Loading...</div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    $(function(){
        $(document).on('click', '.btn-open-withdraw', function(e){
            e.preventDefault();
            var type = $(this).data('type');
            var id = $(this).data('id');
            var url = '/admin/' + (type == 'investment' ? 'investment-withdraw' : 'dividend-withdraw') + '/' + id + '/create?modal=1';
            $('#createWithdrawModalLabel').text((type=='investment' ? 'Investment' : 'Dividend') + ' Withdraw');
            $('#createWithdrawModalBody').html('<div class="text-center">Loading...</div>');
            $('#createWithdrawModal').modal('show');
            $.get(url, function(html){
                $('#createWithdrawModalBody').html(html);
                // hijack the form submit to use AJAX
                $('#createWithdrawModalBody').find('form').on('submit', function(ev){
                    ev.preventDefault();
                    var $f = $(this);
                    var formData = new FormData(this);
                    $.ajax({
                        url: $f.attr('action'),
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(resp){
                            if (resp.status === 'success') {
                                $('#createWithdrawModal').modal('hide');
                                // show success toast
                                alert('Withdraw created (ID: ' + resp.id + ')');
                            } else {
                                alert('Error creating withdraw');
                            }
                        },
                        error: function(){ alert('Error creating withdraw'); }
                    });
                });
            }).fail(function(){
                $('#createWithdrawModalBody').html('<div class="text-danger">Failed to load form.</div>');
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/shareHolder/index.blade.php ENDPATH**/ ?>