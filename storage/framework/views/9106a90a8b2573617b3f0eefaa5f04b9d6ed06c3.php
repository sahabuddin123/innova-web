
<?php $__env->startSection('title'); ?> <?php echo e($pageTitle); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?> 
   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-book"></i> <?php echo e($pageTitle); ?></h1>
    </div>
    <?php echo $__env->make('admin.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title"><?php echo e($subTitle); ?></h3>
                <form action="<?php echo e(route('admin.batchs.store')); ?>" method="POST" role="form" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="tile-body">
                        <div class="form-group"> 
                            <label class="control-label" for="stuff_id">Assign Teacher<span class="m-l-5 text-danger"> *</span></label>
                            <select  class="form-control <?php $__errorArgs = ['stuff_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"name="stuff_id" id="stuff_id">
                                <option value="">Select</option>
                                <?php $__currentLoopData = $stuff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                            </select>
                            <?php $__errorArgs = ['stuff_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group"> 
                            <label class="control-label" for="batchnum">Batch Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control <?php $__errorArgs = ['batchnum'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="batchnum" id="batchnum" value="<?php echo e(old('batchnum')); ?>"/>
                            <?php $__errorArgs = ['batchnum'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="totalseat">Total Seats <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control <?php $__errorArgs = ['totalseat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="number" name="totalseat" id="totalseat" value="<?php echo e(old('totalseat')); ?>"/>
                            <?php $__errorArgs = ['totalseat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="startdate">Batchs Start Date <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control <?php $__errorArgs = ['startdate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="date" name="startdate" id="startdate" value="<?php echo e(old('startdate')); ?>"/>
                            <?php $__errorArgs = ['startdate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="enddate">Batchs End Date </label>
                            <input class="form-control <?php $__errorArgs = ['enddate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="date" name="enddate" id="enddate" value="<?php echo e(old('enddate')); ?>"/>
                            <?php $__errorArgs = ['enddate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="control-label" for="schedule">Batch Schedule <span class="m-l-5 text-danger"> *</span></label>
                                </div>
                                <div class="col-md-9">
                                    <div class="row pb-2">
                                        <div class="col-md-4">
                                            <label for="day1"><i class="fa fa-calendar" aria-hidden="true"></i> Friday</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day1" class="<?php $__errorArgs = ['day1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="day1yes" value="1"> <label for="day1yes">Yes</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day1" class="<?php $__errorArgs = ['day1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="day1no" value="0"> <label for="day1no">No</label>
                                            <?php $__errorArgs = ['day1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> 
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                  <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                                </div>
                                                <input class="form-control <?php $__errorArgs = ['schedule1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="schedule1" id="schedule1" value="<?php echo e(old('schedule1')); ?>" placeholder="09:00 AM - 11:00 AM"/>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row pb-2">
                                        <div class="col-md-4">
                                            <label for="day2"><i class="fa fa-calendar" aria-hidden="true"></i> Satrday</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day2" class="<?php $__errorArgs = ['day2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="day2yes" value="1"> <label for="day2yes">Yes</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day2" class="<?php $__errorArgs = ['day2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="day2no" value="0"> <label for="day2no">No</label>
                                            <?php $__errorArgs = ['day2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> 
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                  <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                                </div>
                                                <input class="form-control <?php $__errorArgs = ['schedule2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="schedule2" id="schedule2" value="<?php echo e(old('schedule2')); ?>" placeholder="09:00 AM - 11:00 AM"/>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row pb-2">
                                        <div class="col-md-4">
                                            <label for="day3"><i class="fa fa-calendar" aria-hidden="true"></i> Sunday</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day3" class="<?php $__errorArgs = ['day3'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="day3yes" value="1"> <label for="day3yes">Yes</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day3" class="<?php $__errorArgs = ['day3'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="day3no" value="0"> <label for="day3no">No</label>
                                            <?php $__errorArgs = ['day3'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> 
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                  <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                                </div>
                                                <input class="form-control <?php $__errorArgs = ['schedule3'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="schedule3" id="schedule3" value="<?php echo e(old('schedule3')); ?>" placeholder="09:00 AM - 11:00 AM"/>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row pb-2">
                                        <div class="col-md-4">
                                            <label for="day4"><i class="fa fa-calendar" aria-hidden="true"></i> Monday</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day4" class="<?php $__errorArgs = ['day4'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="day4yes" value="1"> <label for="day4yes">Yes</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day4" class="<?php $__errorArgs = ['day4'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="day4no" value="0"> <label for="day4no">No</label>
                                            <?php $__errorArgs = ['day4'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> 
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                  <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                                </div>
                                                <input class="form-control <?php $__errorArgs = ['schedule4'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="schedule4" id="schedule4" value="<?php echo e(old('schedule4')); ?>" placeholder="09:00 AM - 11:00 AM"/>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row pb-2">
                                        <div class="col-md-4">
                                            <label for="day5"><i class="fa fa-calendar" aria-hidden="true"></i> Tuesday</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day5" class="<?php $__errorArgs = ['day5'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="day5yes" value="1"> <label for="day5yes">Yes</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day5" class="<?php $__errorArgs = ['day5'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="day5no" value="0"> <label for="day5no">No</label>
                                            <?php $__errorArgs = ['day5'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> 
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                  <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                                </div>
                                                <input class="form-control <?php $__errorArgs = ['schedule5'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="schedule5" id="schedule5" value="<?php echo e(old('schedule5')); ?>" placeholder="09:00 AM - 11:00 AM"/>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row pb-2">
                                        <div class="col-md-4">
                                            <label for="day6"><i class="fa fa-calendar" aria-hidden="true"></i> Wednesday</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day6" class="<?php $__errorArgs = ['day6'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="day6yes" value="1"> <label for="day6yes">Yes</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day6" class="<?php $__errorArgs = ['day6'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="day6no" value="0"> <label for="day6no">No</label>
                                            <?php $__errorArgs = ['day6'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> 
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                  <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                                </div>
                                                <input class="form-control <?php $__errorArgs = ['schedule6'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="schedule6" id="schedule6" value="<?php echo e(old('schedule6')); ?>" placeholder="09:00 AM - 11:00 AM"/>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row pb-2">
                                        <div class="col-md-4">
                                            <label for="day7"><i class="fa fa-calendar" aria-hidden="true"></i> Thursday</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day7" class="<?php $__errorArgs = ['day7'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="day7yes" value="1"> <label for="day7yes">Yes</label> &nbsp;&nbsp;&nbsp;
                                            <input  type="radio" name="day7" class="<?php $__errorArgs = ['day7'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="day7no" value="0"> <label for="day7no">No</label>
                                            <?php $__errorArgs = ['day7'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> 
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                  <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                                </div>
                                                <input class="form-control <?php $__errorArgs = ['schedule7'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="schedule7" id="schedule7" value="<?php echo e(old('schedule7')); ?>" placeholder="09:00 AM - 11:00 AM"/>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="IsActive">Batchs Status </label>
                            <select  class="form-control <?php $__errorArgs = ['IsActive'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"name="IsActive" id="IsActive">
                                <option value="1">Running</option>
                                <option value="2">Upcomming</option>
                                <option value="3">Complete</option>
                                <option value="0">Postponed</option>
                            </select>
                            <?php $__errorArgs = ['IsActive'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Batchs</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="<?php echo e(route('admin.batchs.index')); ?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?> 
<script>
   $('#schedule1').hide(); 
   $('#schedule2').hide(); 
   $('#schedule3').hide(); 
   $('#schedule4').hide(); 
   $('#schedule5').hide(); 
   $('#schedule6').hide(); 
   $('#schedule7').hide();
    $('#day1yes').on('click', function(){
        $('#schedule1').show(); 
    });
    $('#day1no').on('click', function(){
        $('#schedule1').hide(); 
    });
    $('#day2yes').on('click', function(){
        $('#schedule2').show(); 
    });
    $('#day2no').on('click', function(){
        $('#schedule2').hide(); 
    });
    $('#day3yes').on('click', function(){
        $('#schedule3').show(); 
    });
    $('#day3no').on('click', function(){
        $('#schedule3').hide(); 
    });
    $('#day4yes').on('click', function(){
        $('#schedule4').show(); 
    });
    $('#day4no').on('click', function(){
        $('#schedule4').hide(); 
    });
    $('#day5yes').on('click', function(){
        $('#schedule5').show(); 
    });
    $('#day5no').on('click', function(){
        $('#schedule5').hide(); 
    });
    $('#day6yes').on('click', function(){
        $('#schedule6').show(); 
    });
    $('#day6no').on('click', function(){
        $('#schedule6').hide(); 
    });
    $('#day7yes').on('click', function(){
        $('#schedule7').show(); 
    });
    $('#day7no').on('click', function(){
        $('#schedule7').hide(); 
    });
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/batchs/create.blade.php ENDPATH**/ ?>