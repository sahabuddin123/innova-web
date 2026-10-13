
<?php $__env->startSection('title'); ?>
    <?php echo e($pageTitle); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-user"></i> <?php echo e($pageTitle); ?></h1>
    </div>
    <?php echo $__env->make('admin.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <style type="text/css">
        #results {
            padding: 10px;
            border: 1px solid;
            background: #ccc;
        }
    </style>
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="tile">
                <h3 class="tile-title"><?php echo e($subTitle); ?></h3>
                <form action="<?php echo e(route('admin.students.store')); ?>" method="POST" role="form"
                    enctype="multipart/form-data">
                    <div class="tile-body">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="course_id">Courses <span class="m-l-5 text-danger">
                                            *</span></label>
                                    <select class="form-control <?php $__errorArgs = ['course_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="course_id"
                                        id="course_id">
                                        <option value="">--Select--</option>
                                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($course->id); ?>"
                                                <?php if(old('course_id') == $course->id): ?> <?php echo e('selected'); ?> <?php endif; ?>>
                                                <?php echo e($course->name); ?> - <?php echo e($course->courseduration); ?> Months</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['course_id'];
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
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="branch_id">Branch <span class="m-l-5 text-danger">
                                            *</span></label>
                                    <select class="form-control <?php $__errorArgs = ['branch_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="branch_id"
                                        id="branch_id">
                                        <option value="">--Select--</option>
                                        <option value="1" <?php if(old('branch_id') == 1): ?> <?php echo e('selected'); ?> <?php endif; ?>>
                                            Mian Branch</option>
                                        <option value="2"
                                            <?php if(old('branch_id') == 2): ?> <?php echo e('selected'); ?> <?php endif; ?>>Khaserhat Branch
                                        </option>
                                    </select>
                                    <?php $__errorArgs = ['branch_id'];
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

                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="batch_id">Batchs <span class="m-l-5 text-danger">
                                            *</span></label>
                                    <select class="form-control <?php $__errorArgs = ['batch_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> "name="batch_id"
                                        id="batch_id">
                                        <option value="">--Select--</option>
                                        <?php $__currentLoopData = $batchs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($batch->id); ?>"
                                                <?php if(old('batch_id') == $batch->id): ?> <?php echo e('selected'); ?> <?php endif; ?>>
                                                <?php echo e($batch->batchnum); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['batch_id'];
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
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="sname">Students Name <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control <?php $__errorArgs = ['sname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="sname"
                                id="sname" value="<?php echo e(old('sname')); ?>" />
                            <?php $__errorArgs = ['sname'];
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
                        <div class="row">
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="gender">Gender <span class="m-l-5 text-danger">
                                            *</span></label>
                                    <select class="form-control <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"name="gender"
                                        id="gender">
                                        <option value="">--Select--</option>
                                        <option value="1"
                                            <?php if(old('gender') == 1): ?> <?php echo e('selected'); ?> <?php endif; ?>>Male</option>
                                        <option value="2"
                                            <?php if(old('gender') == 2): ?> <?php echo e('selected'); ?> <?php endif; ?>>Female</option>
                                        <option value="3"
                                            <?php if(old('gender') == 3): ?> <?php echo e('selected'); ?> <?php endif; ?>>Others</option>
                                    </select>
                                    <?php $__errorArgs = ['gender'];
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
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="dob">Students Date of Birth </label>
                                    <input class="form-control <?php $__errorArgs = ['dob'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="date"
                                        name="dob" id="dob" value="<?php echo e(old('dob')); ?>" />
                                    <?php $__errorArgs = ['dob'];
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
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="bloodgroup">Blood Group </label>
                                    <select class="form-control <?php $__errorArgs = ['bloodgroup'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"name="bloodgroup"
                                        id="bloodgroup">
                                        <option value="">--Select--</option>
                                        <option value="1"
                                            <?php if(old('bloodgroup') == 1): ?> <?php echo e('selected'); ?> <?php endif; ?>>A(+ve)</option>
                                        <option value="2"
                                            <?php if(old('bloodgroup') == 2): ?> <?php echo e('selected'); ?> <?php endif; ?>>O(+ve)</option>
                                        <option value="3"
                                            <?php if(old('bloodgroup') == 3): ?> <?php echo e('selected'); ?> <?php endif; ?>>B(+ve)</option>
                                        <option value="4"
                                            <?php if(old('bloodgroup') == 4): ?> <?php echo e('selected'); ?> <?php endif; ?>>AB(+ve)</option>
                                        <option value="5"
                                            <?php if(old('bloodgroup') == 5): ?> <?php echo e('selected'); ?> <?php endif; ?>>A(-ve)</option>
                                        <option value="6"
                                            <?php if(old('bloodgroup') == 6): ?> <?php echo e('selected'); ?> <?php endif; ?>>O(-ve)</option>
                                        <option value="7"
                                            <?php if(old('bloodgroup') == 7): ?> <?php echo e('selected'); ?> <?php endif; ?>>B(-ve)</option>
                                        <option value="8"
                                            <?php if(old('bloodgroup') == 8): ?> <?php echo e('selected'); ?> <?php endif; ?>>AB(-ve)</option>
                                    </select>
                                    <?php $__errorArgs = ['bloodgroup'];
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
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="religion">Relagion <span class="m-l-5 text-danger">
                                            *</span></label>
                                    <select class="form-control <?php $__errorArgs = ['religion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"name="religion"
                                        id="religion">
                                        <option value="">--Select--</option>
                                        <option value="1"
                                            <?php if(old('religion') == 1): ?> <?php echo e('selected'); ?> <?php endif; ?>>Islam</option>
                                        <option value="2"
                                            <?php if(old('religion') == 2): ?> <?php echo e('selected'); ?> <?php endif; ?>>Hindhu</option>
                                        <option value="3"
                                            <?php if(old('religion') == 3): ?> <?php echo e('selected'); ?> <?php endif; ?>>Bhudist</option>
                                        <option value="4"
                                            <?php if(old('religion') == 4): ?> <?php echo e('selected'); ?> <?php endif; ?>>Christian
                                        </option>
                                    </select>
                                    <?php $__errorArgs = ['religion'];
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
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="height">Students Height </label>
                                    <input class="form-control <?php $__errorArgs = ['height'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text"
                                        name="height" placeholder="Inches" id="height"
                                        value="<?php echo e(old('height')); ?>" />
                                    <?php $__errorArgs = ['height'];
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
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="weight">Students Weight </label>
                                    <input class="form-control <?php $__errorArgs = ['weight'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text"
                                        name="weight" id="weight" placeholder="KiloGram"
                                        value="<?php echo e(old('weight')); ?>" />
                                    <?php $__errorArgs = ['weight'];
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
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="phone">Students Phone Number <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text"
                                        name="phone" id="phone" placeholder="+880" value="<?php echo e(old('phone')); ?>" />
                                    <?php $__errorArgs = ['phone'];
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
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="nid">Students NID or Birth Certificate Number
                                    </label>
                                    <input class="form-control <?php $__errorArgs = ['nid'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text"
                                        name="nid" id="nid" placeholder="123456789"
                                        value="<?php echo e(old('nid')); ?>" />
                                    <?php $__errorArgs = ['nid'];
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
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="last_school">Previous School or Collage </label>
                                    <input class="form-control <?php $__errorArgs = ['last_school'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text"
                                        name="last_school" id="last_school" placeholder="School or Collage Name"
                                        value="<?php echo e(old('last_school')); ?>" />
                                    <?php $__errorArgs = ['last_school'];
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
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="f_name">Father's Name </label>
                                    <input class="form-control <?php $__errorArgs = ['f_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text"
                                        name="f_name" id="f_name" placeholder="Mr." value="<?php echo e(old('f_name')); ?>" />
                                    <?php $__errorArgs = ['f_name'];
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
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="f_phone">Father's Phone Number </label>
                                    <input class="form-control <?php $__errorArgs = ['f_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text"
                                        name="f_phone" id="f_phone" placeholder="+880"
                                        value="<?php echo e(old('f_phone')); ?>" />
                                    <?php $__errorArgs = ['f_phone'];
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
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="m_name">Mother's Name </label>
                                    <input class="form-control <?php $__errorArgs = ['m_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text"
                                        name="m_name" id="m_name" placeholder="Mrs." value="<?php echo e(old('m_name')); ?>" />
                                    <?php $__errorArgs = ['m_name'];
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
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="m_phone">Mothers's Phone Number </label>
                                    <input class="form-control <?php $__errorArgs = ['m_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text"
                                        name="m_phone" id="m_phone" placeholder="+880"
                                        value="<?php echo e(old('m_phone')); ?>" />
                                    <?php $__errorArgs = ['m_phone'];
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
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="g_name">Guardian's Name <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control <?php $__errorArgs = ['g_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text"
                                        name="g_name" id="g_name" placeholder="Mr./Mrs."
                                        value="<?php echo e(old('g_name')); ?>" />
                                    <?php $__errorArgs = ['g_name'];
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
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="g_phone">Guardian's Phone Number <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control <?php $__errorArgs = ['g_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text"
                                        name="g_phone" id="g_phone" placeholder="+880"
                                        value="<?php echo e(old('g_phone')); ?>" />
                                    <?php $__errorArgs = ['g_phone'];
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
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="rel_g">Relation with Guardian <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control <?php $__errorArgs = ['rel_g'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text"
                                        name="rel_g" id="rel_g" placeholder="Relation"
                                        value="<?php echo e(old('rel_g')); ?>" />
                                    <?php $__errorArgs = ['rel_g'];
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
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="discount">Discount </label>
                                    <input class="form-control <?php $__errorArgs = ['discount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text"
                                        name="discount" id="discount" placeholder="Percent"
                                        value="<?php echo e(old('discount')); ?>" />
                                    <?php $__errorArgs = ['discount'];
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
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="course_fee">Course Fee <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control <?php $__errorArgs = ['course_fee'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" disabled
                                        type="text" name="course_fee" id="course_fee" placeholder="Fees"
                                        value="<?php echo e(old('course_fee')); ?>" />
                                    <?php $__errorArgs = ['course_fee'];
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
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="ref">Referance <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control <?php $__errorArgs = ['ref'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text"
                                        name="ref" id="ref" placeholder="Referance"
                                        value="<?php echo e(old('ref')); ?>" />
                                    <?php $__errorArgs = ['ref'];
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


                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="admission_date">Admission Date <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control <?php $__errorArgs = ['admission_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        type="date" name="admission_date" id="admission_date" placeholder="Relation"
                                        value="<?php echo e(old('admission_date')); ?>" />
                                    <?php $__errorArgs = ['admission_date'];
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

                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="IsActive">Student Status <span
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
                                        <option value="">--Select--</option>
                                        <option value="1"
                                            <?php if(old('IsActive') == 1): ?> <?php echo e('selected'); ?> <?php endif; ?>>Regular</option>
                                        <option value="2"
                                            <?php if(old('IsActive') == 2): ?> <?php echo e('selected'); ?> <?php endif; ?>>Iregular
                                        </option>
                                        <option value="3"
                                            <?php if(old('IsActive') == 3): ?> <?php echo e('selected'); ?> <?php endif; ?>>Complete
                                        </option>
                                        <option value="4"
                                            <?php if(old('IsActive') == 4): ?> <?php echo e('selected'); ?> <?php endif; ?>>Restricted
                                        </option>
                                        <option value="5"
                                            <?php if(old('IsActive') == 5): ?> <?php echo e('selected'); ?> <?php endif; ?>>Postponded
                                        </option>
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
                            <div class="col-sm-12 col-md-5">
                                <div class="form-group" id="image-area">
                                    <label class="control-label" for="image-tag">Student Image <span
                                            class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> image-tag"
                                        type="file" name="image" id="image-tag" value="<?php echo e(old('image')); ?>" />
                                    <?php $__errorArgs = ['image'];
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
                            <div class="col-md-3 ">
                                <button type="button" id="take-photo" class="btn btn-warning mt-4">Take your Webcam <i
                                        class="fa fa-camera" aria-hidden="true"></i></button>
                            </div>

                        </div>
                        <div class="row" id="photo-area">
                            <div class="col-md-6">
                                <div id="my_camera"></div>
                                <br />
                                <input type="button" class="btn btn-success" value="Take Picture"
                                    onClick="take_snapshot()">
                                <input type="hidden" name="image2" id="image_tag_student">
                                <!-- <div id="apndimg"></div> -->
                            </div>
                            <div class="col-md-6">
                                <div id="results">Your captured image will appear here...</div>
                            </div>
                        </div>

                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit" id="submitform"><i
                                class="fa fa-fw fa-lg fa-check-circle"></i>Add Students</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="<?php echo e(route('admin.students.index')); ?>"><i
                                class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function() {
            $('select[name="course_id"]').on('change', function() {
                var course_id = $(this).val();
                if (course_id) {
                    $.ajax({
                        url: '/admin/students/getCoursesInfo/' + course_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#course_fee').empty();
                            $.each(data, function(key, value) {
                                $('#course_fee').val(value);
                            });
                        }
                    });
                } else {
                    $('#course_fee').empty();
                }
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <script language="JavaScript">
        $('#image-area').show();
        $('#photo-area').hide();
        $('#take-photo').on('click', function() {
            $('#image-area').hide();
            $('#photo-area').show();
            Webcam.set({
                // live preview size
                width: 640,
                height: 480,

                // device capture size
                dest_width: 640,
                dest_height: 480,

                // final cropped size
                crop_width: 300,
                crop_height: 300,

                // format and quality
                image_format: 'jpeg',
                jpeg_quality: 100,

                // flip horizontal (mirror mode)
                flip_horiz: true
            });
            Webcam.attach('#my_camera');
        });
        // preload shutter audio clip
        var shutter = new Audio();
        shutter.autoplay = false;
        shutter.src = navigator.userAgent.match(/Firefox/) ? 'shutter.ogg' :
            "<?php echo e(asset('public/storage/students/shutter.mp3')); ?>";

        function take_snapshot() {
            Webcam.snap(function(data_uri) {
                // play sound effect
                try {
                    shutter.currentTime = 0;
                } catch (e) {
                    ;
                } // fails in IE
                shutter.play();
                $("#image_tag_student").val(data_uri);
                document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
            });
        }
        $('#submitform').on('click', function() {
            $('#course_fee').removeAttr('disabled');
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/students/create.blade.php ENDPATH**/ ?>