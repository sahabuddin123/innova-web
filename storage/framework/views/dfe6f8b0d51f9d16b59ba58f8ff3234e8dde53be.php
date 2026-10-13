
<?php $__env->startSection('title'); ?> <?php echo e($pageTitle); ?> <?php $__env->stopSection(); ?>
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
                <form action="<?php echo e(route('admin.registration.update')); ?>" method="POST" role="form" enctype="multipart/form-data">
                <div class="tile-body">
                <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <input type="hidden" name="id" value="<?php echo e($targetRegistration->id); ?>">
                            <input type="hidden" name="student_id" value="<?php echo e($targetRegistration->student_id); ?>">
                            <div class="form-group">
                                <label class="control-label" for="session_id">Compter Trade Session <span class="m-l-5 text-danger"> *</span></label>
                                <select  class="form-control <?php $__errorArgs = ['session_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="session_id" id="session_id">
                                <option value="">Select One</option>
                                <?php $__currentLoopData = $session; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($course->id); ?>" <?php if(old('session_id', $targetRegistration->session_id) == $course->id): ?> <?php echo e("selected"); ?> <?php endif; ?>><?php echo e($course->sessionName); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['session_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="ExamName">Exam Name <span class="m-l-5 text-danger"> *</span></label>
                                <select  class="form-control <?php $__errorArgs = ['ExamName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="ExamName" id="ExamName">
                                <option value="">Select One</option>
                                    <option value="1" <?php if(old('ExamName', $targetRegistration->ExamName) == 1): ?> <?php echo e("selected"); ?> <?php endif; ?>>JSC</option>
                                    <option value="2" <?php if(old('ExamName', $targetRegistration->ExamName) == 2): ?> <?php echo e("selected"); ?> <?php endif; ?>>JDC</option>
                                    <option value="3" <?php if(old('ExamName', $targetRegistration->ExamName) == 3): ?> <?php echo e("selected"); ?> <?php endif; ?>>SSC</option>
                                    <option value="4" <?php if(old('ExamName', $targetRegistration->ExamName) == 4): ?> <?php echo e("selected"); ?> <?php endif; ?>>Dakhil</option>
                                </select>
                                <?php $__errorArgs = ['ExamName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="ExamBoard">Exam Board <span class="m-l-5 text-danger"> *</span></label>
                                <select  class="form-control <?php $__errorArgs = ['ExamBoard'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="ExamBoard" id="ExamBoard">
                                    <option value="" selected="">Select One</option>
                                    <option value="1" <?php if(old('ExamBoard', $targetRegistration->ExamBoard) == 1): ?> <?php echo e("selected"); ?> <?php endif; ?>>Barisal</option>
                                    <option value="2" <?php if(old('ExamBoard', $targetRegistration->ExamBoard) == 2): ?> <?php echo e("selected"); ?> <?php endif; ?>>Chittagong</option>
                                    <option value="3" <?php if(old('ExamBoard', $targetRegistration->ExamBoard) == 3): ?> <?php echo e("selected"); ?> <?php endif; ?>>Comilla</option>
                                    <option value="4" <?php if(old('ExamBoard', $targetRegistration->ExamBoard) == 4): ?> <?php echo e("selected"); ?> <?php endif; ?>>Dhaka</option>
                                    <option value="5" <?php if(old('ExamBoard', $targetRegistration->ExamBoard) == 5): ?> <?php echo e("selected"); ?> <?php endif; ?>>Dinajpur</option>
                                    <option value="6" <?php if(old('ExamBoard', $targetRegistration->ExamBoard) == 6): ?> <?php echo e("selected"); ?> <?php endif; ?>>Jessore</option>
                                    <option value="7" <?php if(old('ExamBoard', $targetRegistration->ExamBoard) == 7): ?> <?php echo e("selected"); ?> <?php endif; ?>>Mymensingh</option>
                                    <option value="8" <?php if(old('ExamBoard', $targetRegistration->ExamBoard) == 8): ?> <?php echo e("selected"); ?> <?php endif; ?>>Rajshahi</option>
                                    <option value="9" <?php if(old('ExamBoard', $targetRegistration->ExamBoard) == 9): ?> <?php echo e("selected"); ?> <?php endif; ?>>Sylhet</option>
                                    <option value="10" <?php if(old('ExamBoard', $targetRegistration->ExamBoard) == 10): ?> <?php echo e("selected"); ?> <?php endif; ?>>Madrasah</option>
                                    <option value="11" <?php if(old('ExamBoard', $targetRegistration->ExamBoard) == 11): ?> <?php echo e("selected"); ?> <?php endif; ?>>Technical</option>
                                    <option value="12" <?php if(old('ExamBoard', $targetRegistration->ExamBoard) == 12): ?> <?php echo e("selected"); ?> <?php endif; ?>>DIBS(Dhaka)</option>
                                </select>
                                <?php $__errorArgs = ['ExamBoard'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="ExamSession">Board Exam Session <span class="m-l-5 text-danger"> *</span></label>
                                <input class="form-control <?php $__errorArgs = ['ExamSession'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="ExamSession" id="ExamSession" value="<?php echo e(old('ExamSession', $targetRegistration->ExamSession)); ?>"/>
                                <?php $__errorArgs = ['ExamSession'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="ExamRoll">Board Exam Roll Number <span class="m-l-5 text-danger"> *</span></label>
                                <input class="form-control <?php $__errorArgs = ['ExamRoll'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="number" name="ExamRoll" id="ExamRoll" value="<?php echo e(old('ExamRoll', $targetRegistration->ExamRoll)); ?>"/>
                                <?php $__errorArgs = ['ExamRoll'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="ExamReg">Board Exam Registration Number <span class="m-l-5 text-danger"> *</span></label>
                                <input class="form-control <?php $__errorArgs = ['ExamReg'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="number" name="ExamReg" id="ExamReg" value="<?php echo e(old('ExamReg', $targetRegistration->ExamReg)); ?>"/>
                                <?php $__errorArgs = ['ExamReg'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="PassYear">Board Exam Passing Year <span class="m-l-5 text-danger"> *</span></label>
                                <input class="form-control <?php $__errorArgs = ['PassYear'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="PassYear" id="PassYear" value="<?php echo e(old('PassYear', $targetRegistration->PassYear)); ?>"/>
                                <?php $__errorArgs = ['PassYear'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="Result">Board Exam Result ( GPA ) <span class="m-l-5 text-danger"> *</span></label>
                                <input class="form-control <?php $__errorArgs = ['Result'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="Result" id="Result" value="<?php echo e(old('Result', $targetRegistration->Result)); ?>"/>
                                <?php $__errorArgs = ['Result'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="balance">Registration Fee <span class="m-l-5 text-danger"> *</span></label>
                                <input class="form-control <?php $__errorArgs = ['balance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="balance" id="balance" value="<?php echo e(old('balance', $targetRegistration->balance)); ?>"/>
                                <?php $__errorArgs = ['balance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="IsActive">Registration Status <span class="m-l-5 text-danger"> *</span></label>
                                <select  class="form-control <?php $__errorArgs = ['IsActive'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"name="IsActive" id="IsActive">
                                    <option value="">Select one</option>
                                    <option value="1" <?php if(old('IsActive', $targetRegistration->IsActive) == 1): ?> <?php echo e("selected"); ?> <?php endif; ?>>Complete</option>
                                    <option value="2" <?php if(old('IsActive', $targetRegistration->IsActive) == 2): ?> <?php echo e("selected"); ?> <?php endif; ?>>Waiting For Payment</option>
                                    <option value="3" <?php if(old('IsActive', $targetRegistration->IsActive) == 3): ?> <?php echo e("selected"); ?> <?php endif; ?>>Postponded</option>
                                    <option value="4" <?php if(old('IsActive', $targetRegistration->IsActive) == 4): ?> <?php echo e("selected"); ?> <?php endif; ?>>Restricted</option>
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
                            <div class="form-group">
                                <label class="control-label" for="regDate">Registration Date (MM-DD-YYYY)<span class="m-l-5 text-danger"> *</span></label>
                                <input class="form-control <?php $__errorArgs = ['regDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="date" name="regDate" id="regDate" value="<?php echo e(old('regDate', $targetRegistration->regDate)); ?>"/>
                                <?php $__errorArgs = ['regDate'];
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
                    <button class="btn btn-primary" type="submit" id="submitform"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Registration</button>
                        &nbsp;&nbsp;&nbsp;
                    <a class="btn btn-secondary" href="<?php echo e(route('admin.registration.index')); ?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?> 

<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/registration/edit.blade.php ENDPATH**/ ?>