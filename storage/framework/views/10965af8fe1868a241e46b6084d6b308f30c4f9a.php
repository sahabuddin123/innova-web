
<?php $__env->startSection('title'); ?> <?php echo e($pageTitle); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-users"></i> <?php echo e($subTitle); ?></h1>
  <div class="pull-right">
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-create')): ?>
      <a class="btn btn-success" href="<?php echo e(route('admin.admins.create')); ?>"> Create New User</a>
      <?php endif; ?>
  </div>
</div>

<?php if($message = Session::get('success')): ?>
<div class="alert alert-success">
  <p><?php echo e($message); ?></p>
</div>
<?php endif; ?>

<div class="row">
  <div class="col-md-12 mx-auto">
      <div class="tile">
<table class="table table-bordered">
 <tr>
   <th>No</th>
   <th>Name</th>
   <th>Email</th>
   <th>Roles</th>
   <th width="280px">Action</th>
 </tr>
 <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <tr>
    <td><?php echo e(++$i); ?></td>
    <td><?php echo e($user->name); ?></td>
    <td><?php echo e($user->email); ?></td>
    <td>
      <?php if(!empty($user->getRoleNames())): ?>
        <?php $__currentLoopData = $user->getRoleNames(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
           <label class="badge badge-success"><?php echo e($v); ?></label>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php endif; ?>
    </td>
    <td>
       <a class="btn btn-info" href="<?php echo e(route('admin.admins.show',$user->id)); ?>">Show</a>
       <a class="btn btn-primary" href="<?php echo e(route('admin.admins.edit',$user->id)); ?>">Edit</a>
        <?php echo Form::open(['method' => 'DELETE','route' => ['admin.admins.destroy', $user->id],'style'=>'display:inline']); ?>

            <?php echo Form::submit('Delete', ['class' => 'btn btn-danger']); ?>

        <?php echo Form::close(); ?>

    </td>
  </tr>
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>


<?php echo $data->render(); ?>

      </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/admins/index.blade.php ENDPATH**/ ?>