<!-- Sidebar -->
<?php
    $currentRoute = Route::currentRouteName();
    
    // Route arrays for active state detection
    $studentRoutes = ['admin.students.index', 'admin.students.create', 'admin.students.edit', 'admin.students.view', 'admin.students.delete'];
    $courseRoutes = ['admin.courses.index', 'admin.courses.create', 'admin.courses.edit', 'admin.courses.show'];
    $batchRoutes = ['admin.batchs.index', 'admin.batchs.create', 'admin.batchs.edit', 'admin.batchs.show'];
    $courseCatRoutes = ['admin.coursecatg.index', 'admin.coursecatg.create', 'admin.coursecatg.edit'];
    $admissionRoutes = ['admin.admission.index', 'admin.admission.show'];
    $sessionRoutes = ['admin.session.index', 'admin.session.create', 'admin.session.edit'];
    $incomeRoutes = ['admin.income.index', 'admin.income.create', 'admin.income.edit'];
    $registrationRoutes = ['admin.registration.index', 'admin.registration.create', 'admin.registration.show'];
    $certificateRoutes = ['admin.certificate.index', 'admin.certificate.create', 'admin.certificate.show'];
    $icbdRoutes = ['admin.certificate_icbd.index', 'admin.certificate_icbd.create'];
    $feesRoutes = ['admin.fees.index', 'admin.fees.feelog', 'admin.fees.create'];
    $stuffRoutes = ['admin.stuff.index', 'admin.stuff.create', 'admin.stuff.edit'];
    $branchRoutes = ['admin.branch.index', 'admin.branch.create', 'admin.branch.edit'];
    $incCatRoutes = ['admin.inccategoris.index', 'admin.inccategoris.create', 'admin.inccategoris.edit'];
    $expCatRoutes = ['admin.expcategoris.index', 'admin.expcategoris.create', 'admin.expcategoris.edit'];
    $expRoutes = ['admin.expance.index', 'admin.expance.create', 'admin.expance.edit'];
    $cmsRoutes = ['admin.slider.index', 'admin.story.index', 'admin.review.index', 'admin.blogcatg.index', 'admin.blogs.index', 'admin.cmsabout.index', 'admin.seminor.index', 'admin.seminorreg.index', 'admin.gallery.index', 'admin.services.index', 'admin.products.index', 'admin.concerns.index', 'admin.workflows.index', 'admin.clients.index', 'admin.technologies.index', 'admin.teams.index'];
    $bankingRoutes = ['admin.bank.loan.index', 'admin.bank.loan.create', 'admin.emi.installment.index', 'admin.emi.installment.create'];
    
    // Check active states
    $isStudentActive = in_array($currentRoute, $studentRoutes);
    $isCourseActive = in_array($currentRoute, $courseRoutes);
    $isBatchActive = in_array($currentRoute, $batchRoutes);
    $isCourseCatActive = in_array($currentRoute, $courseCatRoutes);
    $isAdmissionActive = in_array($currentRoute, $admissionRoutes);
    $isSessionActive = in_array($currentRoute, $sessionRoutes);
    $isRegistrationActive = in_array($currentRoute, $registrationRoutes);
    $isCertificateActive = in_array($currentRoute, $certificateRoutes);
    $isIcbdActive = in_array($currentRoute, $icbdRoutes);
    $isFeesActive = in_array($currentRoute, $feesRoutes);
    $isStuffActive = in_array($currentRoute, $stuffRoutes);
    $isBranchActive = in_array($currentRoute, $branchRoutes);
    $isIncCatActive = in_array($currentRoute, $incCatRoutes);
    $isExpCatActive = in_array($currentRoute, $expCatRoutes);
    $isExpActive = in_array($currentRoute, $expRoutes);
    $isCmsActive = in_array($currentRoute, $cmsRoutes);
    $isBankingActive = in_array($currentRoute, $bankingRoutes);
    $isIncomeActive = in_array($currentRoute, $incomeRoutes);
    $isReportActive = in_array($currentRoute, ['admin.income.report.index', 'admin.expancere.index']);
    
?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo e(route('admin.dashboard')); ?>">
        <div class="sidebar-brand-text mx-3"><img src="<?php echo e(asset('public/storage/' . config('settings.site_logo'))); ?>"
                alt="!" height="50"></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?php echo e($currentRoute == 'admin.dashboard' ? 'active' : ''); ?>">
        <a class="nav-link <?php echo e($currentRoute == 'admin.dashboard' ? 'active' : ''); ?>"
            href="<?php echo e(route('admin.dashboard')); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Admins Management
    </div>
    <li class="nav-item <?php if(Route::currentRouteName() == 'admin.admins.index' ||
            Route::currentRouteName() == 'admin.roles.index' ||
            Route::currentRouteName() == 'admin.shareholder.index' ||
            Route::currentRouteName() == 'admin.investment.index'): ?> active <?php endif; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#admins" aria-expanded="true"
            aria-controls="admins">
            <i class="fas fa-fw fa-users"></i>
            <span>Admins</span>
        </a>
        <div id="admins" class="collapse <?php if(Route::currentRouteName() == 'admin.admins.index' || Route::currentRouteName() == 'admin.roles.index' || Route::currentRouteName() == 'admin.shareholder.index' || Route::currentRouteName() == 'admin.investment.index'): ?> show <?php endif; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.admins.index'): ?> active <?php endif; ?>"
                    href="<?php echo e(route('admin.admins.index')); ?>">All Admin</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.roles.index'): ?> active <?php endif; ?>"
                    href="<?php echo e(route('admin.roles.index')); ?>">All Role</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.shareholder.index'): ?> active <?php endif; ?>"
                    href="<?php echo e(route('admin.shareholder.index')); ?>">All Investor</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.investment.index'): ?> active <?php endif; ?>"
                    href="<?php echo e(route('admin.investment.index')); ?>">Investment Logs</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.investment.withdraw.index'): ?> active <?php endif; ?>"
                    href="<?php echo e(route('admin.investment.withdraw.index')); ?>">Investment Withdraws</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.dividend.withdraw.index'): ?> active <?php endif; ?>"
                    href="<?php echo e(route('admin.dividend.withdraw.index')); ?>">Dividend Withdraws</a>
            </div>
        </div>
    </li>
    <li class="nav-item <?php if(Route::currentRouteName() == 'admin.users.index' || Route::currentRouteName() == 'admin.users.create'): ?> active <?php endif; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#users" aria-expanded="true"
            aria-controls="users">
            <i class="fas fa-fw fa-user"></i>
            <span>Users</span>
        </a>
        <div id="users" class="collapse <?php if(Route::currentRouteName() == 'admin.users.index' || Route::currentRouteName() == 'admin.users.create'): ?> show <?php endif; ?>" aria-labelledby="headingTwoOne" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.users.index'): ?> active <?php endif; ?>"
                    href="<?php echo e(route('admin.users.index')); ?>">All Users</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.users.create'): ?> active <?php endif; ?>"
                    href="<?php echo e(route('admin.users.create')); ?>">Create Users</a>
            </div>
        </div>
    </li>

    <li class="nav-item <?php if(in_array(Route::currentRouteName(), ['admin.assets.index', 'admin.assets.create', 'admin.asset-training.courses.index', 'admin.asset-training.students.index'])): ?> active <?php endif; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAssetProject"
            aria-expanded="true" aria-controls="collapseAssetProject">
            <i class="fas fa-fw fa-project-diagram"></i>
            <span>Asset Project</span>
        </a>
        <div id="collapseAssetProject" class="collapse <?php if(in_array(Route::currentRouteName(), ['admin.assets.index', 'admin.assets.create', 'admin.asset-training.courses.index', 'admin.asset-training.students.index', 'admin.asset-training.students.show'])): ?> show <?php endif; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.asset-training.courses.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.asset-training.courses.index')); ?>">Asset Courses</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.asset-training.students.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.asset-training.students.index')); ?>">Asset Registrations</a>
                <a class="collapse-item" href="<?php echo e(route('asset.index')); ?>" target="_blank">Frontend Asset Page</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Course
    </div>
    <li class="nav-item <?php if($isCourseCatActive): ?> active <?php endif; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCourseCategory"
            aria-expanded="true" aria-controls="collapseCourseCategory">
            <i class="fas fa-fw fa-book-open"></i>
            <span>Course Category</span>
        </a>
        
        <div id="collapseCourseCategory" class="collapse <?php if($isCourseCatActive): ?> show <?php endif; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.coursecatg.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.coursecatg.index')); ?>">All Courses Category</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.coursecatg.create'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.coursecatg.create')); ?>">Create Course Category</a>
            </div>
        </div>
    </li>
    <li class="nav-item <?php if($isCourseActive): ?> active <?php endif; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-book-open"></i>
            <span>Courses</span>
        </a>
        
        <div id="collapseTwo" class="collapse <?php if($isCourseActive): ?> show <?php endif; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.courses.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.courses.index')); ?>">All Courses</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.courses.create'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.courses.create')); ?>">Create Course</a>
            </div>
        </div>
    </li>
    
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Batchs
    </div>
    <li class="nav-item <?php if($isBatchActive): ?> active <?php endif; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
            aria-expanded="true" aria-controls="collapseThree">
            <i class="fas fa-fw fa-book-open"></i>
            <span>Batchs</span>
        </a>
        <div id="collapseThree" class="collapse <?php if($isBatchActive): ?> show <?php endif; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.batchs.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.batchs.index')); ?>">All Batchs</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.batchs.create'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.batchs.create')); ?>">Create Batchs</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Admission
    </div>
    <li class="nav-item <?php if($isStudentActive): ?> active <?php endif; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour"
            aria-expanded="true" aria-controls="collapseFour">
            <i class="fas fa-fw fa-users"></i>
            <span>Students</span>
        </a>
        <div id="collapseFour" class="collapse <?php if($isStudentActive): ?> show <?php endif; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.students.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.students.index')); ?>">All Students</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.students.create'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.students.create')); ?>">Add Students</a>
            </div>
        </div>
    </li>
    <li class="nav-item <?php if($isAdmissionActive): ?> active <?php endif; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour2"
            aria-expanded="true" aria-controls="collapseFour2">
            <i class="fas fa-ticket-alt"></i>
            <span>Online Admission</span>
        </a>
        <div id="collapseFour2" class="collapse <?php if($isAdmissionActive): ?> show <?php endif; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.admission.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.admission.index')); ?>">All Online Admission</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        BTEB Registration
    </div>
    <li class="nav-item <?php if($isSessionActive): ?> active <?php endif; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSix"
            aria-expanded="true" aria-controls="collapseSix">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Session</span>
        </a>
        <div id="collapseSix" class="collapse <?php if($isSessionActive): ?> show <?php endif; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.session.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.session.index')); ?>">All Session</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.session.create'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.session.create')); ?>">Create Session</a>
            </div>
        </div>
    </li>
    <li class="nav-item <?php if($isRegistrationActive): ?> active <?php endif; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSeven"
            aria-expanded="true" aria-controls="collapseSeven">
            <i class="fas fa-fw fa-registered"></i>
            <span>Registration</span>
        </a>
        <div id="collapseSeven" class="collapse <?php if($isRegistrationActive): ?> show <?php endif; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.registration.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.registration.index')); ?>">All Register Students</a>
            </div>
        </div>
    </li>
    <li class="nav-item <?php if($isCertificateActive): ?> active <?php endif; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCertificate"
            aria-expanded="true" aria-controls="collapseCertificate">
            <i class="fas fa-fw fa-certificate"></i>
            <span>BTEB Certificate</span>
        </a>
        <div id="collapseCertificate" class="collapse <?php if($isCertificateActive): ?> show <?php endif; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.certificate.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.certificate.index')); ?>">All BTEB Certificate</a>
            </div>
        </div>
    </li>
         <li class="nav-item <?php if($isIcbdActive): ?> active <?php endif; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#icbdcertificate"
            aria-expanded="true" aria-controls="icbdcertificate">
            <i class="fas fa-fw fa-certificate"></i>
            <span>ICBD Certificate</span>
        </a>
        <div id="icbdcertificate" class="collapse <?php if($isIcbdActive): ?> show <?php endif; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.certificate_icbd.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.certificate_icbd.index')); ?>">All ICBD Certificate</a>
            </div>
        </div>
        
    </li>
    <!-- Divider -->
    <!-- Heading -->
    <div class="sidebar-heading">
        Payments
    </div>
    <li class="nav-item <?php if($isFeesActive): ?> active <?php endif; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFive"
            aria-expanded="true" aria-controls="collapseFive">
            <i class="fas fa-money-bill"></i>
            <span>Fees Collection</span>
        </a>
        <div id="collapseFive" class="collapse <?php if($isFeesActive): ?> show <?php endif; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.fees.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.fees.index')); ?>">Students List</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.fees.feelog'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.fees.feelog')); ?>">Transaction List</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        HRMS
    </div>
    <li class="nav-item <?php if($isStuffActive): ?> active <?php endif; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#stuff"
            aria-expanded="true" aria-controls="stuff">
            <i class="fas fa-user-tie"></i>
            <span>Stuff</span>
        </a>
        <div id="stuff" class="collapse <?php if($isStuffActive): ?> show <?php endif; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.stuff.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.stuff.index')); ?>">All Stuff</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.stuff.create'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.stuff.create')); ?>">Add Stuff</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Income and Expoance
    </div>
    <li class="nav-item <?php if($isBranchActive): ?> active <?php endif; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#branch"
            aria-expanded="true" aria-controls="branch">
            <i class="fas fa-store-alt"></i>
            <span>Branch</span>
        </a>
        <div id="branch" class="collapse <?php if($isBranchActive): ?> show <?php endif; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.branch.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.branch.index')); ?>">All Branch</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.branch.create'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.branch.create')); ?>">Add Branch</a>
            </div>
        </div>
    </li>
    <li class="nav-item <?php if($isIncCatActive): ?> active <?php endif; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#inccategoris"
            aria-expanded="true" aria-controls="inccategoris">
            <i class="far fa-money-bill-alt"></i>
            <span>Income Categoris</span>
        </a>
        <div id="inccategoris" class="collapse <?php if($isIncCatActive): ?> show <?php endif; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.inccategoris.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.inccategoris.index')); ?>">All Income Categoris</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.inccategoris.create'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.inccategoris.create')); ?>">Add Income Categoris</a>
            </div>
        </div>
    </li>
    <li class="nav-item <?php if($isExpCatActive): ?> active <?php endif; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#expcategoris"
            aria-expanded="true" aria-controls="expcategoris">
            <i class="far fa-money-bill-alt"></i>
            <span>Expense Categoris</span>
        </a>
        <div id="expcategoris" class="collapse <?php if($isExpCatActive): ?> show <?php endif; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.expcategoris.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.expcategoris.index')); ?>">All Expense Categoris</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.expcategoris.create'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.expcategoris.create')); ?>">Add Expense Categoris</a>
            </div>
        </div>
    </li>
    <li class="nav-item <?php if($isExpActive): ?> active <?php endif; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#expance"
            aria-expanded="true" aria-controls="expance">
            <i class="fas fa-file-invoice-dollar"></i>
            <span>Expance</span>
        </a>
        <div id="expance" class="collapse <?php if($isExpActive): ?> show <?php endif; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.expance.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.expance.index')); ?>">All Expance</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.expance.create'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.expance.create')); ?>">Add Expance</a>
            </div>
        </div>
    </li>
    <li class="nav-item <?php if($isIncomeActive): ?> active <?php endif; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#income"
            aria-expanded="true" aria-controls="income">
            <i class="far fa-credit-card"></i>
            <span>Income</span>
        </a>
        <div id="income" class="collapse <?php if($isIncomeActive): ?> show <?php endif; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.income.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.income.index')); ?>">All Income</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.income.create'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.income.create')); ?>">Add income</a>
            </div>
        </div>
    </li>
    <li class="nav-item <?php if($isReportActive): ?> active <?php endif; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#report"
            aria-expanded="true" aria-controls="report">
 
            <i class="far fa-file-pdf"></i>
            <span>Report</span>
        </a>
        <div id="report" class="collapse <?php if($isReportActive): ?> show <?php endif; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.income.report.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.income.report.index')); ?>">Income Report</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.expancere.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.expancere.index')); ?>">Expanse Report</a>
            </div>
        </div>
    </li>
        
    
   
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Frontend CMS
    </div>
    <li class="nav-item <?php if($isCmsActive): ?> active <?php endif; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#cms" aria-expanded="true"
            aria-controls="cms">
            <i class="fas fa-globe"></i>
            <span>CMS</span>
        </a>
        <div id="cms" class="collapse <?php if($isCmsActive): ?> show <?php endif; ?>" aria-labelledby="headingCms" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.slider.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.slider.index')); ?>">Slider</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.story.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.story.index')); ?>">Success Story</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.review.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.review.index')); ?>">Review</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.blogcatg.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.blogcatg.index')); ?>">Blog Categoris</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.blogs.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.blogs.index')); ?>">Blog</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.cmsabout.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.cmsabout.index')); ?>">CMS About</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.seminor.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.seminor.index')); ?>">Seminor</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.seminorreg.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.seminorreg.index')); ?>">Seminor Registration</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.gallery.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.gallery.index')); ?>">Gallery</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.services.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.services.index')); ?>">Services</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.products.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.products.index')); ?>">Products</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.concerns.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.concerns.index')); ?>">Concerns</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.workflows.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.workflows.index')); ?>">Workflow</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.clients.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.clients.index')); ?>">Clients</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.technologies.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.technologies.index')); ?>">Technologies</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.teams.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.teams.index')); ?>">Team</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Heading -->
    <div class="sidebar-heading">
        Banking & Loans
    </div>
    <li class="nav-item <?php if($isBankingActive): ?> active <?php endif; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#banking"
            aria-expanded="true" aria-controls="banking">
            <i class="fas fa-university"></i>
            <span>Bank Loans</span>
        </a>
        <div id="banking" class="collapse <?php if($isBankingActive): ?> show <?php endif; ?>" aria-labelledby="headingBanking" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.bank.loan.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.bank.loan.index')); ?>">All Loans</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.bank.loan.create'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.bank.loan.create')); ?>">Add Loan</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.emi.installment.index'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.emi.installment.index')); ?>">EMI Payments</a>
                <a class="collapse-item <?php if(Route::currentRouteName() == 'admin.emi.installment.create'): ?> active <?php endif; ?>" href="<?php echo e(route('admin.emi.installment.create')); ?>">Record EMI</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Heading -->
    <div class="sidebar-heading">
        Setting
    </div>


    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link <?php echo e(Route::currentRouteName() == 'admin.settings' ? 'active' : ''); ?>"
            href="<?php echo e(route('admin.settings')); ?>">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Settings</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
<?php /**PATH /www/wwwroot/innovacomputersbd.com/resources/views/admin/partials/sidebar.blade.php ENDPATH**/ ?>