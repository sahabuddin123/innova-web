
 
<?php $__env->startSection('title'); ?> <?php echo e($pageTitle); ?> <?php $__env->stopSection(); ?>
 
<?php $__env->startSection('content'); ?>
     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-users"></i> <?php echo e($pageTitle); ?></h1>
        </div>
        <div>
        <!-- <a href="<?php echo e(route('admin.students.create')); ?>" class="btn btn-primary pull-right">Add Students</a> -->
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
                                <th> Students name </th>
                                <th> Batch No </th>
                                <th> Course Name </th>
                                <th> Total Pay </th>
                                <th> Total Due </th>
                                <th> Last Payment</th>
                                <th> Admission Date</th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <?php
                                        function time_elapsed_string($datetime, $full = false) {
                                            $now = new DateTime;
                                            $ago = new DateTime($datetime);
                                            $diff = $now->diff($ago);

                                            $diff->w = floor($diff->d / 7);
                                            $diff->d -= $diff->w * 7;

                                            $string = array(
                                                'y' => 'year',
                                                'm' => 'month',
                                                'w' => 'week',
                                                'd' => 'day',
                                                'h' => 'hour',
                                                'i' => 'minute',
                                                's' => 'second',
                                            );
                                            foreach ($string as $k => &$v) {
                                                if ($diff->$k) {
                                                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                                                } else {
                                                    unset($string[$k]);
                                                }
                                            }

                                            if (!$full) $string = array_slice($string, 0, 1);
                                            return $string ? implode(', ', $string) . ' ago' : 'just now';
                                        }
                                        ?>
                        <tbody>
                            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->index+1); ?></td>
                                        <td><img src="<?php echo asset('public/storage/'.$course->image); ?>" alt="!"  height="90"></td>
                                        <td><?php echo e($course->sname); ?> </td>
                                        <td>
                                        <?php
                                        $batchno = DB::table('batchs')->where('id',$course->batch_id)->pluck('batchnum')->first();
                                        ?>
                                        <?php echo e($batchno); ?>

                                        </td>
                                        <td>
                                        <?php
                                        $coursename = DB::table('courses')->where('id',$course->course_id)->pluck('name')->first();
                                        ?>
                                        <?php echo e($coursename); ?>

                                        </td>
                                        <td>
                                            <?php
                                            $pay = DB::table('fees_transections')->where('student_id',$course->id)->sum('paidamount');
                                            ?>
                                            <?php echo e(number_format($pay,2)); ?>

                                        </td>
                                        <td>
                                            <?php
                                            $due = $course->balance - $pay;
                                           ?>
                                           <?php echo e(number_format($due,2)); ?>

                                        </td>
                                        
                                        <td>
                                            <?php
                                            $lastdate = DB::table('fees_transections')->where('student_id',$course->id)->pluck('paiddate')->take(1)->last();
                                           
                                            if(isset($lastdate)){
                                            $data =  time_elapsed_string($lastdate);
                                           }
                                           else{
                                            
                                            $data =  "No payments";
                                           }
                                            
                                            ?>
                                           <?php echo e($data); ?>

                                        </td>
                                        
                                        <td>
                                        <?php
                                            $date = strtotime($course->admission_date);
                                            $createDate = date('d-M-y', $date);
                                        ?>
                                            <?php echo e($createDate); ?>

                                    </td>
                                        
                                       
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                <a href="<?php echo e(route('admin.fees.create', $course->id)); ?>" class="btn btn-sm btn-info"><i class="fas fa-money-bill"></i></a>
                                                <a href="<?php echo e(route('admin.fees.view', $course->id)); ?>" class="btn btn-sm btn-warning"><i class="fas fa-desktop"></i></a>
                                                <!-- <a href="<?php echo e(route('admin.students.view', $course->id)); ?>" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a> -->
                                                <!-- <a href="<?php echo e(route('admin.students.edit', $course->id)); ?>" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a> -->
                                                <!-- <a href="<?php echo e(route('admin.students.delete', $course->id)); ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a> -->
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/payments/index.blade.php ENDPATH**/ ?>