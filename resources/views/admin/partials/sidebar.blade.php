<!-- Sidebar -->
@php
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
    
@endphp
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-text mx-3"><img src="{{ asset('public/storage/' . config('settings.site_logo')) }}"
                alt="!" height="50"></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ $currentRoute == 'admin.dashboard' ? 'active' : '' }}">
        <a class="nav-link {{ $currentRoute == 'admin.dashboard' ? 'active' : '' }}"
            href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Admins Management
    </div>
    <li class="nav-item @if (Route::currentRouteName() == 'admin.admins.index' ||
            Route::currentRouteName() == 'admin.roles.index' ||
            Route::currentRouteName() == 'admin.shareholder.index' ||
            Route::currentRouteName() == 'admin.investment.index') active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#admins" aria-expanded="true"
            aria-controls="admins">
            <i class="fas fa-fw fa-users"></i>
            <span>Admins</span>
        </a>
        <div id="admins" class="collapse @if (Route::currentRouteName() == 'admin.admins.index' || Route::currentRouteName() == 'admin.roles.index' || Route::currentRouteName() == 'admin.shareholder.index' || Route::currentRouteName() == 'admin.investment.index') show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.admins.index') active @endif"
                    href="{{ route('admin.admins.index') }}">All Admin</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.roles.index') active @endif"
                    href="{{ route('admin.roles.index') }}">All Role</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.shareholder.index') active @endif"
                    href="{{ route('admin.shareholder.index') }}">All Investor</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.investment.index') active @endif"
                    href="{{ route('admin.investment.index') }}">Investment Logs</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.investment.withdraw.index') active @endif"
                    href="{{ route('admin.investment.withdraw.index') }}">Investment Withdraws</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.dividend.withdraw.index') active @endif"
                    href="{{ route('admin.dividend.withdraw.index') }}">Dividend Withdraws</a>
            </div>
        </div>
    </li>
    <li class="nav-item @if (Route::currentRouteName() == 'admin.users.index' || Route::currentRouteName() == 'admin.users.create') active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#users" aria-expanded="true"
            aria-controls="users">
            <i class="fas fa-fw fa-user"></i>
            <span>Users</span>
        </a>
        <div id="users" class="collapse @if (Route::currentRouteName() == 'admin.users.index' || Route::currentRouteName() == 'admin.users.create') show @endif" aria-labelledby="headingTwoOne" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.users.index') active @endif"
                    href="{{ route('admin.users.index') }}">All Users</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.users.create') active @endif"
                    href="{{ route('admin.users.create') }}">Create Users</a>
            </div>
        </div>
    </li>

    <li class="nav-item @if (in_array(Route::currentRouteName(), ['admin.assets.index', 'admin.assets.create', 'admin.asset-training.courses.index', 'admin.asset-training.students.index'])) active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAssetProject"
            aria-expanded="true" aria-controls="collapseAssetProject">
            <i class="fas fa-fw fa-project-diagram"></i>
            <span>Asset Project</span>
        </a>
        <div id="collapseAssetProject" class="collapse @if (in_array(Route::currentRouteName(), ['admin.assets.index', 'admin.assets.create', 'admin.asset-training.courses.index', 'admin.asset-training.students.index', 'admin.asset-training.students.show'])) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.asset-training.courses.index') active @endif" href="{{ route('admin.asset-training.courses.index') }}">Asset Courses</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.asset-training.students.index') active @endif" href="{{ route('admin.asset-training.students.index') }}">Asset Registrations</a>
                <a class="collapse-item" href="{{ route('asset.index') }}" target="_blank">Frontend Asset Page</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Course
    </div>
    <li class="nav-item @if ($isCourseCatActive) active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCourseCategory"
            aria-expanded="true" aria-controls="collapseCourseCategory">
            <i class="fas fa-fw fa-book-open"></i>
            <span>Course Category</span>
        </a>
        
        <div id="collapseCourseCategory" class="collapse @if ($isCourseCatActive) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.coursecatg.index') active @endif" href="{{ route('admin.coursecatg.index') }}">All Courses Category</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.coursecatg.create') active @endif" href="{{ route('admin.coursecatg.create') }}">Create Course Category</a>
            </div>
        </div>
    </li>
    <li class="nav-item @if ($isCourseActive) active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-book-open"></i>
            <span>Courses</span>
        </a>
        
        <div id="collapseTwo" class="collapse @if ($isCourseActive) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.courses.index') active @endif" href="{{ route('admin.courses.index') }}">All Courses</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.courses.create') active @endif" href="{{ route('admin.courses.create') }}">Create Course</a>
            </div>
        </div>
    </li>
    {{-- <li class="nav-item @if (in_array(Route::currentRouteName(), ['admin.asset-training.courses.index', 'admin.asset-training.courses.create', 'admin.asset-training.courses.edit', 'admin.asset-training.students.index', 'admin.asset-training.students.show'])) active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAssetTraining"
            aria-expanded="true" aria-controls="collapseAssetTraining">
            <i class="fas fa-fw fa-graduation-cap"></i>
            <span>ASSET Training</span>
        </a>
        <div id="collapseAssetTraining" class="collapse @if (in_array(Route::currentRouteName(), ['admin.asset-training.courses.index', 'admin.asset-training.courses.create', 'admin.asset-training.courses.edit', 'admin.asset-training.students.index', 'admin.asset-training.students.show'])) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.asset-training.courses.index') active @endif" href="{{ route('admin.asset-training.courses.index') }}">Asset Courses</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.asset-training.students.index') active @endif" href="{{ route('admin.asset-training.students.index') }}">Registrations</a>
            </div>
        </div>
    </li> --}}
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Batchs
    </div>
    <li class="nav-item @if ($isBatchActive) active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
            aria-expanded="true" aria-controls="collapseThree">
            <i class="fas fa-fw fa-book-open"></i>
            <span>Batchs</span>
        </a>
        <div id="collapseThree" class="collapse @if ($isBatchActive) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.batchs.index') active @endif" href="{{ route('admin.batchs.index') }}">All Batchs</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.batchs.create') active @endif" href="{{ route('admin.batchs.create') }}">Create Batchs</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Admission
    </div>
    <li class="nav-item @if ($isStudentActive) active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour"
            aria-expanded="true" aria-controls="collapseFour">
            <i class="fas fa-fw fa-users"></i>
            <span>Students</span>
        </a>
        <div id="collapseFour" class="collapse @if ($isStudentActive) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.students.index') active @endif" href="{{ route('admin.students.index') }}">All Students</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.students.create') active @endif" href="{{ route('admin.students.create') }}">Add Students</a>
            </div>
        </div>
    </li>
    <li class="nav-item @if ($isAdmissionActive) active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour2"
            aria-expanded="true" aria-controls="collapseFour2">
            <i class="fas fa-ticket-alt"></i>
            <span>Online Admission</span>
        </a>
        <div id="collapseFour2" class="collapse @if ($isAdmissionActive) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.admission.index') active @endif" href="{{ route('admin.admission.index') }}">All Online Admission</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        BTEB Registration
    </div>
    <li class="nav-item @if ($isSessionActive) active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSix"
            aria-expanded="true" aria-controls="collapseSix">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Session</span>
        </a>
        <div id="collapseSix" class="collapse @if ($isSessionActive) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.session.index') active @endif" href="{{ route('admin.session.index') }}">All Session</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.session.create') active @endif" href="{{ route('admin.session.create') }}">Create Session</a>
            </div>
        </div>
    </li>
    <li class="nav-item @if ($isRegistrationActive) active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSeven"
            aria-expanded="true" aria-controls="collapseSeven">
            <i class="fas fa-fw fa-registered"></i>
            <span>Registration</span>
        </a>
        <div id="collapseSeven" class="collapse @if ($isRegistrationActive) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.registration.index') active @endif" href="{{ route('admin.registration.index') }}">All Register Students</a>
            </div>
        </div>
    </li>
    <li class="nav-item @if ($isCertificateActive) active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCertificate"
            aria-expanded="true" aria-controls="collapseCertificate">
            <i class="fas fa-fw fa-certificate"></i>
            <span>BTEB Certificate</span>
        </a>
        <div id="collapseCertificate" class="collapse @if ($isCertificateActive) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.certificate.index') active @endif" href="{{ route('admin.certificate.index') }}">All BTEB Certificate</a>
            </div>
        </div>
    </li>
         <li class="nav-item @if ($isIcbdActive) active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#icbdcertificate"
            aria-expanded="true" aria-controls="icbdcertificate">
            <i class="fas fa-fw fa-certificate"></i>
            <span>ICBD Certificate</span>
        </a>
        <div id="icbdcertificate" class="collapse @if ($isIcbdActive) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.certificate_icbd.index') active @endif" href="{{ route('admin.certificate_icbd.index') }}">All ICBD Certificate</a>
            </div>
        </div>
        
    </li>
    <!-- Divider -->
    <!-- Heading -->
    <div class="sidebar-heading">
        Payments
    </div>
    <li class="nav-item @if ($isFeesActive) active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFive"
            aria-expanded="true" aria-controls="collapseFive">
            <i class="fas fa-money-bill"></i>
            <span>Fees Collection</span>
        </a>
        <div id="collapseFive" class="collapse @if ($isFeesActive) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.fees.index') active @endif" href="{{ route('admin.fees.index') }}">Students List</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.fees.feelog') active @endif" href="{{ route('admin.fees.feelog') }}">Transaction List</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        HRMS
    </div>
    <li class="nav-item @if ($isStuffActive) active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#stuff"
            aria-expanded="true" aria-controls="stuff">
            <i class="fas fa-user-tie"></i>
            <span>Stuff</span>
        </a>
        <div id="stuff" class="collapse @if ($isStuffActive) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.stuff.index') active @endif" href="{{ route('admin.stuff.index') }}">All Stuff</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.stuff.create') active @endif" href="{{ route('admin.stuff.create') }}">Add Stuff</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Income and Expoance
    </div>
    <li class="nav-item @if ($isBranchActive) active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#branch"
            aria-expanded="true" aria-controls="branch">
            <i class="fas fa-store-alt"></i>
            <span>Branch</span>
        </a>
        <div id="branch" class="collapse @if ($isBranchActive) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.branch.index') active @endif" href="{{ route('admin.branch.index') }}">All Branch</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.branch.create') active @endif" href="{{ route('admin.branch.create') }}">Add Branch</a>
            </div>
        </div>
    </li>
    <li class="nav-item @if ($isIncCatActive) active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#inccategoris"
            aria-expanded="true" aria-controls="inccategoris">
            <i class="far fa-money-bill-alt"></i>
            <span>Income Categoris</span>
        </a>
        <div id="inccategoris" class="collapse @if ($isIncCatActive) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.inccategoris.index') active @endif" href="{{ route('admin.inccategoris.index') }}">All Income Categoris</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.inccategoris.create') active @endif" href="{{ route('admin.inccategoris.create') }}">Add Income Categoris</a>
            </div>
        </div>
    </li>
    <li class="nav-item @if ($isExpCatActive) active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#expcategoris"
            aria-expanded="true" aria-controls="expcategoris">
            <i class="far fa-money-bill-alt"></i>
            <span>Expense Categoris</span>
        </a>
        <div id="expcategoris" class="collapse @if ($isExpCatActive) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.expcategoris.index') active @endif" href="{{ route('admin.expcategoris.index') }}">All Expense Categoris</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.expcategoris.create') active @endif" href="{{ route('admin.expcategoris.create') }}">Add Expense Categoris</a>
            </div>
        </div>
    </li>
    <li class="nav-item @if ($isExpActive) active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#expance"
            aria-expanded="true" aria-controls="expance">
            <i class="fas fa-file-invoice-dollar"></i>
            <span>Expance</span>
        </a>
        <div id="expance" class="collapse @if ($isExpActive) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.expance.index') active @endif" href="{{ route('admin.expance.index') }}">All Expance</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.expance.create') active @endif" href="{{ route('admin.expance.create') }}">Add Expance</a>
            </div>
        </div>
    </li>
    <li class="nav-item @if ($isIncomeActive) active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#income"
            aria-expanded="true" aria-controls="income">
            <i class="far fa-credit-card"></i>
            <span>Income</span>
        </a>
        <div id="income" class="collapse @if ($isIncomeActive) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.income.index') active @endif" href="{{ route('admin.income.index') }}">All Income</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.income.create') active @endif" href="{{ route('admin.income.create') }}">Add income</a>
            </div>
        </div>
    </li>
    <li class="nav-item @if ($isReportActive) active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#report"
            aria-expanded="true" aria-controls="report">
 
            <i class="far fa-file-pdf"></i>
            <span>Report</span>
        </a>
        <div id="report" class="collapse @if ($isReportActive) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.income.report.index') active @endif" href="{{ route('admin.income.report.index') }}">Income Report</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.expancere.index') active @endif" href="{{ route('admin.expancere.index') }}">Expanse Report</a>
            </div>
        </div>
    </li>
        
    {{-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#expcategoris"
            aria-expanded="true" aria-controls="expcategoris">
            <i class="far fa-money-bill-alt"></i>
            <span>Expanse Categoris</span>
        </a>
        <div id="expcategoris" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('admin.expcategoris.index') }}">All Categoris</a>
                <a class="collapse-item" href="{{ route('admin.expcategoris.create') }}">Add Categoris</a>
            </div>
        </div>
    </li> --}}
   
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Frontend CMS
    </div>
    <li class="nav-item @if ($isCmsActive) active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#cms" aria-expanded="true"
            aria-controls="cms">
            <i class="fas fa-globe"></i>
            <span>CMS</span>
        </a>
        <div id="cms" class="collapse @if ($isCmsActive) show @endif" aria-labelledby="headingCms" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.slider.index') active @endif" href="{{ route('admin.slider.index') }}">Slider</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.story.index') active @endif" href="{{ route('admin.story.index') }}">Success Story</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.review.index') active @endif" href="{{ route('admin.review.index') }}">Review</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.blogcatg.index') active @endif" href="{{ route('admin.blogcatg.index') }}">Blog Categoris</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.blogs.index') active @endif" href="{{ route('admin.blogs.index') }}">Blog</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.cmsabout.index') active @endif" href="{{ route('admin.cmsabout.index') }}">CMS About</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.seminor.index') active @endif" href="{{ route('admin.seminor.index') }}">Seminor</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.seminorreg.index') active @endif" href="{{ route('admin.seminorreg.index') }}">Seminor Registration</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.gallery.index') active @endif" href="{{ route('admin.gallery.index') }}">Gallery</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.services.index') active @endif" href="{{ route('admin.services.index') }}">Services</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.products.index') active @endif" href="{{ route('admin.products.index') }}">Products</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.concerns.index') active @endif" href="{{ route('admin.concerns.index') }}">Concerns</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.workflows.index') active @endif" href="{{ route('admin.workflows.index') }}">Workflow</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.clients.index') active @endif" href="{{ route('admin.clients.index') }}">Clients</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.technologies.index') active @endif" href="{{ route('admin.technologies.index') }}">Technologies</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.teams.index') active @endif" href="{{ route('admin.teams.index') }}">Team</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Heading -->
    <div class="sidebar-heading">
        Banking & Loans
    </div>
    <li class="nav-item @if ($isBankingActive) active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#banking"
            aria-expanded="true" aria-controls="banking">
            <i class="fas fa-university"></i>
            <span>Bank Loans</span>
        </a>
        <div id="banking" class="collapse @if ($isBankingActive) show @endif" aria-labelledby="headingBanking" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.bank.loan.index') active @endif" href="{{ route('admin.bank.loan.index') }}">All Loans</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.bank.loan.create') active @endif" href="{{ route('admin.bank.loan.create') }}">Add Loan</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.emi.installment.index') active @endif" href="{{ route('admin.emi.installment.index') }}">EMI Payments</a>
                <a class="collapse-item @if (Route::currentRouteName() == 'admin.emi.installment.create') active @endif" href="{{ route('admin.emi.installment.create') }}">Record EMI</a>
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
        <a class="nav-link {{ Route::currentRouteName() == 'admin.settings' ? 'active' : '' }}"
            href="{{ route('admin.settings') }}">
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
