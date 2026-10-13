
<?php $__env->startSection('title'); ?>
    <?php echo e($pageTitle); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-registered"></i> <?php echo e($pageTitle); ?></h1>
    </div>
    <?php echo $__env->make('admin.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="tile">
                <h3 class="tile-title"><?php echo $subTitle; ?></h3>
                <form action="<?php echo e(route('admin.certificate.store')); ?>" method="POST" role="form"
                    enctype="multipart/form-data">
                    <div class="tile-body">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <input type="hidden" name="student_id" value="<?php echo e($students->id); ?>">
                                <div class="form-group">
                                    <label class="control-label" for="session_id">Compter Trade Session <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <select class="form-control <?php $__errorArgs = ['session_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="session_id"
                                        id="session_id">
                                        <option value="">Select One</option>
                                        <?php $__currentLoopData = $session; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($course->id); ?>"
                                                <?php if(old('session_id') == $course->id): ?> <?php echo e('selected'); ?> <?php endif; ?>>
                                                <?php echo e($course->sessionName); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['session_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <?php echo e($message); ?>

                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="regNo">BTEB Registration Number <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control <?php $__errorArgs = ['regNo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="number"
                                        name="regNo" id="regNo" value="<?php echo e(old('regNo')); ?>" />
                                    <?php $__errorArgs = ['regNo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <?php echo e($message); ?>

                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="cno">Certificate Number <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control <?php $__errorArgs = ['cno'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="number"
                                        name="cno" id="cno" value="<?php echo e(old('cno')); ?>" />
                                    <?php $__errorArgs = ['cno'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <?php echo e($message); ?>

                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="recevier">Certificate Receiver Name <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control <?php $__errorArgs = ['recevier'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text"
                                        name="recevier" id="recevier" value="<?php echo e(old('recevier')); ?>" />
                                    <?php $__errorArgs = ['recevier'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <?php echo e($message); ?>

                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="pDate">Certificate Print Date <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control <?php $__errorArgs = ['pDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="date"
                                        name="pDate" id="pDate" value="<?php echo e(old('pDate')); ?>" />
                                    <?php $__errorArgs = ['pDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <?php echo e($message); ?>

                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="cimage">Certificate Image<span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control <?php $__errorArgs = ['cimage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="file"
                                        name="cimage" id="cimage" value="<?php echo e(old('cimage')); ?>" />
                                    <?php $__errorArgs = ['cimage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <?php echo e($message); ?>

                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="dimage">Certificate Delivery Image<span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control <?php $__errorArgs = ['dimage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="file"
                                        name="dimage" id="dimage" value="<?php echo e(old('dimage')); ?>" />
                                    <?php $__errorArgs = ['dimage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <?php echo e($message); ?>

                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label" for="Result">Result Grate Letter <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control <?php $__errorArgs = ['Result'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text"
                                        name="Result" id="Result" value="<?php echo e(old('Result')); ?>" />
                                    <?php $__errorArgs = ['Result'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <?php echo e($message); ?>

                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="dDate">Delivery Date <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control <?php $__errorArgs = ['dDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="date"
                                        name="dDate" id="dDate" value="<?php echo e(old('dDate')); ?>" />
                                    <?php $__errorArgs = ['dDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <?php echo e($message); ?>

                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="IsActive">Registration Status <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <select class="form-control <?php $__errorArgs = ['IsActive'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"name="IsActive"
                                        id="IsActive">
                                        <option value="">Select one</option>
                                        <option value="1"
                                            <?php if(old('IsActive') == 1): ?> <?php echo e('selected'); ?> <?php endif; ?>>Deliverd</option>
                                        <option value="2"
                                            <?php if(old('IsActive') == 2): ?> <?php echo e('selected'); ?> <?php endif; ?>>Waiting For
                                            Delivery</option>
                                        <option value="3"
                                            <?php if(old('IsActive') == 3): ?> <?php echo e('selected'); ?> <?php endif; ?>>Printing Queie
                                        </option>
                                        <option value="4"
                                            <?php if(old('IsActive') == 4): ?> <?php echo e('selected'); ?> <?php endif; ?>>Cancle</option>
                                    </select>
                                    <?php $__errorArgs = ['IsActive'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <?php echo e($message); ?>

                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                            </div>
                            <div class="tile-footer">
                                <button class="btn btn-primary" type="submit" id="submitform"><i
                                        class="fa fa-fw fa-lg fa-check-circle"></i>Create Certificate</button>
                                &nbsp;&nbsp;&nbsp;
                                <a class="btn btn-secondary" href="<?php echo e(route('admin.certificate.index')); ?>"><i
                                        class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                        </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/certificate/create.blade.php ENDPATH**/ ?>