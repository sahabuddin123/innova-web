

<?php $__env->startSection('title'); ?>
    <?php echo e($pageTitle); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('backend/css/lightbox-popup.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('backend/css/mignify.css')); ?>">
    <style>
        @import  url('https://fonts.maateen.me/solaiman-lipi/font.css');

        table {
            font-family: 'SolaimanLipi', Arial, sans-serif !important;
        }

        th,
        td {
            white-space: nowrap;
        }

        div.dataTables_wrapper {
            /* width: 800px; */
            /* margin: 0 auto; */
        }

        th input {
            width: 90%;
        }
    </style>
    <?php
    use App\Models\BanglaDateNumber;
    use lemonpatwari\BanglaNumber\NumberToBangla;
    use Carbon\Carbon;
    $numberToBangla = new NumberToBangla();
    ?>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="far fa-credit-card"></i> <?php echo e($pageTitle); ?></h1>
        </div>
        <div>
            <a href="<?php echo e(route('admin.expance.create')); ?>" class="btn btn-primary pull-right">Add Expanse</a>
        </div>
    </div>
    <?php echo $__env->make('admin.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body overflow-auto">
                    <table class="table table-bordered" id="sampleTable">
                        <thead align="center">
                            <tr>
                                <th> # </th>
                                <th> মেমো তারিখ</th>
                                <th> শিরোনাম </th>
                                <th> খাতের নাম </th>
                                <th> শাখার নাম </th>
                                
                                <th> টাকার পরিমাণ</th>
                                <th> স্ট্যটাস</th>
                                
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i
                                        class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody align="center">
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->index + 1); ?></td>

                                    <td>
                                        <?php
                                            $buyDate = strtotime($item->invoiceDate);
                                            $buyDate = date('d-M-y', $buyDate);
                                        ?>
                                        <?php echo e($buyDate); ?>

                                    </td>
                                    <td>
                                        <?php echo e($item->title); ?>

                                    </td>
                                    <td>
                                        <span class="badge badge-danger">
                                            
                                            <?php if(isset($item->exCategoris)): ?>
                                                <?php echo e($item->exCategoris->categoris); ?>

                                            <?php else: ?>
                                                N/A (or any default value)
                                            <?php endif; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">
                                            <?php if(isset($item->branches)): ?>
                                                <?php echo e($item->branches->bname); ?>

                                            <?php else: ?>
                                                Branch Not Defined
                                            <?php endif; ?>
                                        </span>
                                    </td>

                                    
                                    <td>
                                       <b><?php echo e(BanglaDateNumber::bn_number(number_format($item->amount, 2, '.', ','))); ?><?php echo e('/-'); ?></b> 
                                    </td>
                                    <td>
                                        <?php
                                            if ($item->IsActive == 1) {
                                                $status = "<span class='text-warning'>Pending</span>";
                                            } elseif ($item->IsActive == 2) {
                                                $status = "<span class='text-success'>Accept</span>";
                                            } elseif ($item->IsActive == 3) {
                                                $status = "<span class='text-danger'>Restricted</span>";
                                            }
                                        ?>
                                        <b><?php echo $status; ?></b>
                                    </td>
                                    

                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Second group">
                                            <button type="button" class="btn btn-success btn-sm view_data"
                                                id="<?php echo e($item->id); ?>" title="Short View Expanse"><i
                                                    class="fas fa-desktop"></i></button>
                                            <a href="<?php echo e(route('admin.expance.view', $item->id)); ?>"
                                                class="btn btn-sm btn-info" title="View Expanse"><i
                                                    class="fa fa-eye"></i></a>
                                            <a href="<?php echo e(route('admin.expance.edit', $item->id)); ?>"
                                                class="btn btn-sm btn-primary" title="Edit Expanse"><i
                                                    class="fa fa-edit"></i></a>
                                            <a href="<?php echo e(route('admin.expance.delete', $item->id)); ?>"
                                                class="btn btn-sm btn-danger" title="Delete Expanse"><i
                                                    class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th> # </th>
                                <th> মেমো তারিখ</th>
                                <th> শিরোনাম </th>
                                <th> খাতের নাম </th>
                                <th> শাখার নাম </th>
                                
                                <th> টাকার পরিমাণ</th>
                                <th> স্ট্যটাস</th>
                                
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i
                                        class="fa fa-bolt"> </i></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- view Modal -->
    <div class="modal fade" id="phoneModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"
        style="margin-top: 100px;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <!-- Place to print the fetched phone -->
                    <div id="phone_result"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript" src="<?php echo e(asset('backend/vendor/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')); ?>"></script>
    <script type="text/javascript">
        // $(document).ready(function() {
        //     // Setup - add a text input to each footer cell
        //     $('#sampleTable tfoot th').each(function(i) {
        //         var title = $('#sampleTable thead th')
        //             .eq($(this).index())
        //             .text();
        //         $(this).html(
        //             '<input type="text" placeholder="' + title + '" data-index="' + i + '" />'
        //         );
        //     });

        //     // DataTable
        //     var table = $('#sampleTable').DataTable({
        //         pageLength: 100,
        //         scrollY: '550px',
        //         scrollCollapse: true,
        //         paging: false,
        //         fixedColumns: true,
        //         order: [
        //             [1, 'desc']
        //         ],

        //     });

        //     // Filter event handler
        //     $(table.table().container()).on('keyup', 'tfoot input', function() {
        //         table
        //             .column($(this).data('index'))
        //             .search(this.value)
        //             .draw();
        //     });
        // });
        $('#sampleTable').DataTable({order: [[1, 'desc']],});
    </script>
    <script type="text/javascript" src="<?php echo e(asset('backend/js/lightbox-popup.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('backend/js/mignify.js')); ?>"></script>
    <!-- jQuery JS CDN -->
    <script type="text/javascript">
        // Start jQuery function after page is loaded
        $(document).ready(function() {
            // Start jQuery click function to view Bootstrap modal when view info button is clicked
            $('.view_data').click(function() {
                // Get the id of selected phone and assign it in a variable called phoneData
                var phoneData = $(this).attr('id');
                // Start AJAX function
                $.ajax({
                    // Path for controller function which fetches selected phone data
                    url: "<?php echo e(route('short.expanse.show')); ?>",
                    // Method of getting data
                    method: "GET",
                    // Data is sent to the server
                    data: {
                        phoneData: phoneData
                    },
                    // Callback function that is executed after data is successfully sent and recieved
                    success: function(data) {
                        // Print the fetched data of the selected phone in the section called #phone_result 
                        // within the Bootstrap modal
                        //console.log(data);
                        $('#phone_result').html(data);
                        // Display the Bootstrap modal
                        $('#phoneModal').modal('show');
                    }
                });
                // End AJAX function
            });
        });
    </script>
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
                    preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
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

<?php echo $__env->make('admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/expance/index.blade.php ENDPATH**/ ?>