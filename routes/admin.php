<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\BkashController;

Route::group(['prefix'  =>  'admin'], function () {

    Route::get('login', 'Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Admin\LoginController@login')->name('admin.login.post');
    Route::get('logout', 'Admin\LoginController@logout')->name('admin.logout');
    /**
     *Admin Password Reset
     */
    Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset');
    Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::get('/changePassword', 'Admin\ChangePasswordController@showChangePasswordForm')->name('admin.changePassword');
    Route::post('/changePassword', 'Admin\ChangePasswordController@changePassword')->name('changePassword');
    /**
     * Dashboard
     */
    Route::group(['middleware' => ['auth:admin']], function () {


        Route::get('/', 'Admin\DeshboardController@index')->name('admin.dashboard');
        /**
         * Storage link in server
         */
        Route::get('/storagelink', function () {
            Artisan::call('storage:link');
        });
        Route::get('/optimize', function () {
            Artisan::call('optimize:clear');
        });
        Route::get('/configcatche', function () {
            Artisan::call('config:cache');
        });
        Route::get('/configclear', function () {
            Artisan::call('config:clear');
        });
        Route::get('/viewclear', function () {
            Artisan::call('view:clear');
        });
        Route::get('/cacheclear', function () {
            Artisan::call('cache:clear');
        });
        Route::get('/vendorpublish', function () {
            Artisan::call('vendor:publish --provider="Greggilbert\Recaptcha\RecaptchaServiceProvider"');
        });
        // php artisan optimize:clear

        Route::get('settings', 'Admin\SettingController@index')->name('admin.settings');
        Route::post('settings', 'Admin\SettingController@update')->name('admin.settings.update');

        //Admins
        Route::group(['prefix'  =>   'admins'], function () {

            Route::get('/', 'Admin\UserController@index')->name('admin.admins.index');
            Route::get('/create', 'Admin\UserController@create')->name('admin.admins.create');
            Route::post('/store', 'Admin\UserController@store')->name('admin.admins.store');
            Route::get('/{id}/view', 'Admin\UserController@show')->name('admin.admins.show');
            Route::get('/{id}/edit', 'Admin\UserController@edit')->name('admin.admins.edit');
            Route::patch('/update/{id}', 'Admin\UserController@update')->name('admin.admins.update');
            Route::post('/{id}/delete', 'Admin\UserController@destroy')->name('admin.admins.destroy');
            Route::post('/{id}/toggle-active', 'Admin\UserController@toggleActive')->name('admin.admins.toggle-active');
        });
        //Users
        Route::group(['prefix'  =>   'users'], function () {

            Route::get('/', 'Admin\UsersController@index')->name('admin.users.index');
            Route::get('/create', 'Admin\UsersController@create')->name('admin.users.create');
            Route::post('/store', 'Admin\UsersController@store')->name('admin.users.store');
            Route::get('/{id}/view', 'Admin\UsersController@show')->name('admin.users.show');
            Route::get('/{id}/edit', 'Admin\UsersController@edit')->name('admin.users.edit');
            Route::patch('/update/{id}', 'Admin\UsersController@update')->name('admin.users.update');
            Route::post('/{id}/delete', 'Admin\UsersController@destroy')->name('admin.users.destroy');
        });
        // Role
        // Route::resource('roles','Admin\RoleController');
        Route::group(['prefix'  =>   'roles'], function () {

            Route::get('/', 'Admin\RoleController@index')->name('admin.roles.index');
            Route::get('/create', 'Admin\RoleController@create')->name('admin.roles.create');
            Route::post('/store', 'Admin\RoleController@store')->name('admin.roles.store');
            Route::get('/{id}/view', 'Admin\RoleController@show')->name('admin.roles.show');
            Route::get('/{id}/edit', 'Admin\RoleController@edit')->name('admin.roles.edit');
            Route::patch('/update/{id}', 'Admin\RoleController@update')->name('admin.roles.update');
            Route::post('/{id}/delete', 'Admin\RoleController@destroy')->name('admin.roles.destroy');
        });
        //Expance Categoris
        Route::group(['prefix'  =>   'coursecatg'], function () {

            Route::get('/', 'Admin\CourseCategoryController@index')->name('admin.coursecatg.index');
            Route::get('/create', 'Admin\CourseCategoryController@create')->name('admin.coursecatg.create');
            Route::post('/store', 'Admin\CourseCategoryController@store')->name('admin.coursecatg.store');
            Route::get('/{id}/view', 'Admin\CourseCategoryController@show')->name('admin.coursecatg.view');
            Route::get('/{id}/edit', 'Admin\CourseCategoryController@edit')->name('admin.coursecatg.edit');
            Route::post('/update', 'Admin\CourseCategoryController@update')->name('admin.coursecatg.update');
            Route::post('/{id}/delete', 'Admin\CourseCategoryController@delete')->name('admin.coursecatg.delete');
        });
        
         //Blog Categoris
         Route::group(['prefix'  =>   'blogcatg'], function () {

            Route::get('/', 'Admin\BlogCategorisController@index')->name('admin.blogcatg.index');
            Route::get('/create', 'Admin\BlogCategorisController@create')->name('admin.blogcatg.create');
            Route::post('/store', 'Admin\BlogCategorisController@store')->name('admin.blogcatg.store');
            Route::get('/{id}/view', 'Admin\BlogCategorisController@show')->name('admin.blogcatg.view');
            Route::get('/{id}/edit', 'Admin\BlogCategorisController@edit')->name('admin.blogcatg.edit');
            Route::post('/update', 'Admin\BlogCategorisController@update')->name('admin.blogcatg.update');
            Route::post('/{id}/delete', 'Admin\BlogCategorisController@delete')->name('admin.blogcatg.delete');
        });

         // Blogs
         Route::group(['prefix'  =>   'blogs'], function () {

            Route::get('/', 'Admin\BlogController@index')->name('admin.blogs.index');
            Route::get('/create', 'Admin\BlogController@create')->name('admin.blogs.create');
            Route::post('/store', 'Admin\BlogController@store')->name('admin.blogs.store');
            Route::get('/{id}/view', 'Admin\BlogController@show')->name('admin.blogs.view');
            Route::get('/{id}/edit', 'Admin\BlogController@edit')->name('admin.blogs.edit');
            Route::post('/update', 'Admin\BlogController@update')->name('admin.blogs.update');
            Route::post('/{id}/delete', 'Admin\BlogController@delete')->name('admin.blogs.delete');
        });

        Route::group(['prefix'  =>   'assets'], function () {
            Route::get('/', 'Admin\AssetController@index')->name('admin.assets.index');
            Route::get('/create', 'Admin\AssetController@create')->name('admin.assets.create');
            Route::post('/store', 'Admin\AssetController@store')->name('admin.assets.store');
            Route::get('/{id}/edit', 'Admin\AssetController@edit')->name('admin.assets.edit');
            Route::post('/update', 'Admin\AssetController@update')->name('admin.assets.update');
            Route::post('/{id}/delete', 'Admin\AssetController@delete')->name('admin.assets.delete');
        });
        
        Route::group(['prefix'  =>   'courses'], function () {

            Route::get('/', 'Admin\CoursesController@index')->name('admin.courses.index');
            Route::get('/create', 'Admin\CoursesController@create')->name('admin.courses.create');
            Route::post('/store', 'Admin\CoursesController@store')->name('admin.courses.store');
            Route::get('/{id}/view', 'Admin\CoursesController@show')->name('admin.courses.view');
            Route::get('/{id}/edit', 'Admin\CoursesController@edit')->name('admin.courses.edit');
            Route::post('/update', 'Admin\CoursesController@update')->name('admin.courses.update');
            Route::post('/{id}/delete', 'Admin\CoursesController@delete')->name('admin.courses.delete');
        });

        Route::group(['prefix' => 'asset-training'], function () {
            Route::get('/courses', 'Admin\CourseController@index')->name('admin.asset-training.courses.index');
            Route::get('/courses/create', 'Admin\CourseController@create')->name('admin.asset-training.courses.create');
            Route::post('/courses/store', 'Admin\CourseController@store')->name('admin.asset-training.courses.store');
            Route::get('/courses/{id}/edit', 'Admin\CourseController@edit')->name('admin.asset-training.courses.edit');
            Route::post('/courses/update/{id}', 'Admin\CourseController@update')->name('admin.asset-training.courses.update');
            Route::post('/courses/{id}/delete', 'Admin\CourseController@delete')->name('admin.asset-training.courses.delete');
            Route::get('/students', 'Admin\StudentManagementController@index')->name('admin.asset-training.students.index');
            Route::get('/students/{id}/view', 'Admin\StudentManagementController@show')->name('admin.asset-training.students.show');
            Route::post('/students/{id}/delete', 'Admin\StudentManagementController@delete')->name('admin.asset-training.students.delete');
            Route::post('/students/{id}/status', 'Admin\StudentManagementController@updateStatus')->name('admin.asset-training.students.status');
            Route::post('/students/{id}/feedback', 'Admin\StudentManagementController@storeFeedback')->name('admin.asset-training.students.feedback.store');
            Route::post('/students/{id}/call-type', 'Admin\StudentManagementController@updateCallType')->name('admin.asset-training.students.call-type');
        });

       

        Route::group(['prefix'  =>   'batchs'], function () {

            Route::get('/', 'Admin\BatchsController@index')->name('admin.batchs.index');
            Route::get('/complete', 'Admin\BatchsController@complete')->name('admin.batchs.complete');
            Route::get('/running', 'Admin\BatchsController@running')->name('admin.batchs.running');
            Route::get('/upcomming', 'Admin\BatchsController@upcomming')->name('admin.batchs.upcomming');
            Route::get('/postponded', 'Admin\BatchsController@postponded')->name('admin.batchs.postponded');
            Route::get('/create', 'Admin\BatchsController@create')->name('admin.batchs.create');
            Route::post('/store', 'Admin\BatchsController@store')->name('admin.batchs.store');
            Route::get('/{id}/view', 'Admin\BatchsController@show')->name('admin.batchs.view');
            Route::get('/{id}/edit', 'Admin\BatchsController@edit')->name('admin.batchs.edit');
            Route::post('/update', 'Admin\BatchsController@update')->name('admin.batchs.update');
            Route::post('/{id}/delete', 'Admin\BatchsController@delete')->name('admin.batchs.delete');
            Route::get('/{id}/groupduesms', 'Admin\SMSController@groupDueSMS')->name('admin.students.groupDueSMS');
            Route::get('/{id}/grouptodaypostpond', 'Admin\SMSController@groupTdyPSMS')->name('admin.students.groupTdyPSMS');
            Route::get('/{id}/grouptomorrowpostpond', 'Admin\SMSController@groupTomPSMS')->name('admin.students.groupTomPSMS');
            Route::get('/{id}/grouptodayremainder', 'Admin\SMSController@groupTCR')->name('admin.students.groupTCR');
            Route::get('/{id}/groupnewschedule', 'Admin\SMSController@groupNCS')->name('admin.students.groupNCS');
        });

        Route::group(['prefix'  =>   'students'], function () {

            Route::get('/', 'Admin\StudentsController@index')->name('admin.students.index');
            Route::get('/complete', 'Admin\StudentsController@complete')->name('admin.students.complete');
            Route::get('/active', 'Admin\StudentsController@active')->name('admin.students.active');
            Route::get('/iregular', 'Admin\StudentsController@iregular')->name('admin.students.iregular');
            Route::get('/resticted', 'Admin\StudentsController@resticted')->name('admin.students.resticted');
            Route::get('/postpond', 'Admin\StudentsController@postpond')->name('admin.students.postpond');
            Route::get('/create', 'Admin\StudentsController@create')->name('admin.students.create');
            Route::get('/getCoursesInfo/{id}', 'Admin\StudentsController@getCoursesInfo');
            Route::post('/store', 'Admin\StudentsController@store')->name('admin.students.store');
            Route::get('/{id}/duesms', 'Admin\SMSController@dueSMS')->name('admin.students.sms-due');
            Route::get('/{id}/schedulesms', 'Admin\SMSController@scheduleSMS')->name('admin.students.sms-schedule');
            Route::get('/{id}/remaindersms', 'Admin\SMSController@remainderSMS')->name('admin.students.sms-remainder');
            Route::get('/{id}/todaypostpond', 'Admin\SMSController@todayPostpond')->name('admin.students.sms-todaypostpond');
            Route::get('/{id}/tomorrowpostpond', 'Admin\SMSController@tomorrowPostpond')->name('admin.students.sms-tomorrowpostpond');
            Route::get('/{id}/view', 'Admin\StudentsController@show')->name('admin.students.view');
            Route::post('/search', 'Admin\StudentsController@search')->name('admin.students.search');
            Route::get('/{id}/edit', 'Admin\StudentsController@edit')->name('admin.students.edit');
            Route::post('/update', 'Admin\StudentsController@update')->name('admin.students.update');
            Route::post('/{id}/delete', 'Admin\StudentsController@delete')->name('admin.students.delete');
        });

        Route::group(['prefix'  =>   'card'], function () {
            Route::get('/{id}/view', 'Admin\IdCardController@show')->name('admin.idcard.view');
            Route::get('/{id}/iddownload', 'Admin\IdCardController@iddownload')->name('admin.idcard.iddownload');
        });

        Route::group(['prefix'  =>   'fees'], function () {

            Route::get('/', 'Admin\StudentsController@payments')->name('admin.fees.index');
            Route::get('/feelog', 'Admin\FeesTransectionsController@index')->name('admin.fees.feelog');
            Route::get('/{id}/create', 'Admin\FeesTransectionsController@create')->name('admin.fees.create');
            Route::post('/store', 'Admin\FeesTransectionsController@store')->name('admin.fees.store');
            Route::get('/{id}/view', 'Admin\FeesTransectionsController@show')->name('admin.fees.view');
            Route::get('/{id}/edit', 'Admin\FeesTransectionsController@edit')->name('admin.fees.edit');
            Route::post('/update', 'Admin\FeesTransectionsController@update')->name('admin.fees.update');
            Route::post('/status/{id}', 'Admin\FeesTransectionsController@FessStatus')->name('FessStatus');
            Route::get('/{id}/payslip', 'Admin\FeesTransectionsController@payslip')->name('admin.fees.payslip');
            Route::get('/{id}/payslip/download', 'Admin\FeesTransectionsController@downloadPayslip')->name('admin.fees.payslip.download');
        });

        Route::group(['prefix'  =>   'session'], function () {

            Route::get('/', 'Admin\SessionController@index')->name('admin.session.index');
            Route::get('/create', 'Admin\SessionController@create')->name('admin.session.create');
            Route::post('/store', 'Admin\SessionController@store')->name('admin.session.store');
            Route::get('/{id}/view', 'Admin\SessionController@show')->name('admin.session.view');
            Route::get('/{id}/edit', 'Admin\SessionController@edit')->name('admin.session.edit');
            Route::post('/update', 'Admin\SessionController@update')->name('admin.session.update');
            Route::post('/{id}/delete', 'Admin\SessionController@delete')->name('admin.session.delete');
        });

        Route::group(['prefix'  =>   'shareholder'], function () {

            Route::get('/', 'Admin\ShareholderController@index')->name('admin.shareholder.index');
            Route::get('/create', 'Admin\ShareholderController@create')->name('admin.shareholder.create');
            Route::post('/store', 'Admin\ShareholderController@store')->name('admin.shareholder.store');
            Route::get('/{id}/view', 'Admin\ShareholderController@show')->name('admin.shareholder.view');
            Route::get('/{id}/edit', 'Admin\ShareholderController@edit')->name('admin.shareholder.edit');
            Route::post('/update', 'Admin\ShareholderController@update')->name('admin.shareholder.update');
            Route::post('/{id}/delete', 'Admin\ShareholderController@delete')->name('admin.shareholder.delete');
        });

        Route::group(['prefix'  =>   'investment'], function () {

            Route::get('/', 'Admin\InvesmentsController@index')->name('admin.investment.index');
            Route::get('/{id}/create', 'Admin\InvesmentsController@create')->name('admin.investment.create');
            Route::post('/store', 'Admin\InvesmentsController@store')->name('admin.investment.store');
            Route::get('/{id}/view', 'Admin\InvesmentsController@show')->name('admin.investment.view');
            Route::get('/{id}/detail', 'Admin\InvesmentsController@detail')->name('admin.investment.detail');
            Route::get('/{id}/edit', 'Admin\InvesmentsController@edit')->name('admin.investment.edit');
            Route::post('/update', 'Admin\InvesmentsController@update')->name('admin.investment.update');
            Route::post('/{id}/delete', 'Admin\InvesmentsController@delete')->name('admin.investment.delete');
            Route::get('/{id}/statement', 'Admin\InvesmentsController@statement')->name('admin.investment.statement');
        });

        // Bank Loans
        Route::group(['prefix'  =>   'bank-loan'], function () {
            Route::get('/', 'Admin\BankLoanController@index')->name('admin.bank.loan.index');
            Route::get('/create', 'Admin\BankLoanController@create')->name('admin.bank.loan.create');
            Route::post('/store', 'Admin\BankLoanController@store')->name('admin.bank.loan.store');
            Route::get('/{id}/view', 'Admin\BankLoanController@show')->name('admin.bank.loan.view');
            Route::get('/{id}/edit', 'Admin\BankLoanController@edit')->name('admin.bank.loan.edit');
            Route::put('/{id}', 'Admin\BankLoanController@update')->name('admin.bank.loan.update');
            Route::delete('/{id}', 'Admin\BankLoanController@destroy')->name('admin.bank.loan.delete');
            Route::get('/{id}/statement', 'Admin\BankLoanController@statement')->name('admin.bank.loan.statement');
            Route::get('/{id}/emi-statement', 'Admin\BankLoanController@emiStatement')->name('admin.bank.loan.emi.statement');
            Route::get('/{id}/savings-statement', 'Admin\BankLoanController@savingsStatement')->name('admin.bank.loan.savings.statement');
        });

        // EMI Installments
        Route::group(['prefix'  =>   'emi-installment'], function () {
            Route::get('/data', 'Admin\EmiInstallmentController@data')->name('admin.emi.installment.data');
            Route::get('/', 'Admin\EmiInstallmentController@index')->name('admin.emi.installment.index');
            Route::get('/create', 'Admin\EmiInstallmentController@create')->name('admin.emi.installment.create');
            Route::post('/store', 'Admin\EmiInstallmentController@store')->name('admin.emi.installment.store');
            Route::get('/{id}/view', 'Admin\EmiInstallmentController@show')->name('admin.emi.installment.view');
            Route::get('/{id}/edit', 'Admin\EmiInstallmentController@edit')->name('admin.emi.installment.edit');
            Route::put('/{id}', 'Admin\EmiInstallmentController@update')->name('admin.emi.installment.update');
            Route::delete('/{id}', 'Admin\EmiInstallmentController@destroy')->name('admin.emi.installment.delete');
            Route::post('/{id}/mark-paid', 'Admin\EmiInstallmentController@markPaid')->name('admin.emi.installment.mark.paid');
            Route::get('/{loan_id}/statement', 'Admin\EmiInstallmentController@statement')->name('admin.emi.installment.statement');
        });

        // Investment Withdraws
        Route::group(['prefix'  =>   'investment-withdraw'], function () {
            Route::get('/data', 'Admin\InvestmentWithdrawController@data')->name('admin.investment.withdraw.data');
            Route::get('/{id}/json', 'Admin\InvestmentWithdrawController@showJson')->name('admin.investment.withdraw.json');

            Route::get('/', 'Admin\InvestmentWithdrawController@index')->name('admin.investment.withdraw.index');
            Route::get('/{id}/create', 'Admin\InvestmentWithdrawController@create')->name('admin.investment.withdraw.create');
            Route::post('/store', 'Admin\InvestmentWithdrawController@store')->name('admin.investment.withdraw.store');
            Route::get('/{id}/view', 'Admin\InvestmentWithdrawController@show')->name('admin.investment.withdraw.view');
            Route::get('/{id}/edit', 'Admin\InvestmentWithdrawController@edit')->name('admin.investment.withdraw.edit');
            Route::post('/update', 'Admin\InvestmentWithdrawController@update')->name('admin.investment.withdraw.update');
            Route::delete('/{id}', 'Admin\InvestmentWithdrawController@destroy')->name('admin.investment.withdraw.delete');
            Route::post('/{id}/delete', 'Admin\InvestmentWithdrawController@destroy')->name('admin.investment.withdraw.destroy');
            Route::post('/{id}/approve', 'Admin\InvestmentWithdrawController@approve')->name('admin.investment.withdraw.approve');
            Route::post('/{id}/reject', 'Admin\InvestmentWithdrawController@reject')->name('admin.investment.withdraw.reject');
        });

        // Dividend Withdraws
        Route::group(['prefix'  =>   'dividend-withdraw'], function () {
            Route::get('/data', 'Admin\DividendWithdrawController@data')->name('admin.dividend.withdraw.data');
            Route::get('/{id}/json', 'Admin\DividendWithdrawController@showJson')->name('admin.dividend.withdraw.json');

            Route::get('/', 'Admin\DividendWithdrawController@index')->name('admin.dividend.withdraw.index');
            Route::get('/{id}/create', 'Admin\DividendWithdrawController@create')->name('admin.dividend.withdraw.create');
            Route::post('/store', 'Admin\DividendWithdrawController@store')->name('admin.dividend.withdraw.store');
            Route::get('/{id}/view', 'Admin\DividendWithdrawController@show')->name('admin.dividend.withdraw.view');
            Route::get('/{id}/edit', 'Admin\DividendWithdrawController@edit')->name('admin.dividend.withdraw.edit');
            Route::post('/update', 'Admin\DividendWithdrawController@update')->name('admin.dividend.withdraw.update');
            Route::delete('/{id}', 'Admin\DividendWithdrawController@destroy')->name('admin.dividend.withdraw.delete');
            Route::post('/{id}/delete', 'Admin\DividendWithdrawController@destroy')->name('admin.dividend.withdraw.destroy');
            Route::post('/{id}/approve', 'Admin\DividendWithdrawController@approve')->name('admin.dividend.withdraw.approve');
            Route::post('/{id}/reject', 'Admin\DividendWithdrawController@reject')->name('admin.dividend.withdraw.reject');
        });

        Route::group(['prefix'  =>   'admission'], function () {

            Route::get('/', 'Admin\AdmissionController@index')->name('admin.admission.index');
            Route::get('/create', 'Admin\AdmissionController@create')->name('admin.admission.create');
            Route::post('/store', 'Admin\AdmissionController@store')->name('admin.admission.store');
            Route::get('/{id}/view', 'Admin\AdmissionController@show')->name('admin.admission.view');
            Route::get('/{id}/edit', 'Admin\AdmissionController@edit')->name('admin.admission.edit');
            Route::post('/update', 'Admin\AdmissionController@update')->name('admin.admission.update');
            Route::post('/{id}/delete', 'Admin\AdmissionController@delete')->name('admin.admission.delete');
        });

        Route::group(['prefix'  =>   'registration'], function () {

            Route::get('/', 'Admin\RegistrationController@index')->name('admin.registration.index');
            Route::get('/{id}/create', 'Admin\RegistrationController@create')->name('admin.registration.create');
            Route::post('/store', 'Admin\RegistrationController@store')->name('admin.registration.store');
            Route::get('/{id}/view', 'Admin\RegistrationController@show')->name('admin.registration.view');
            Route::get('/{id}/edit', 'Admin\RegistrationController@edit')->name('admin.registration.edit');
            Route::post('/update', 'Admin\RegistrationController@update')->name('admin.registration.update');
            Route::post('/{id}/delete', 'Admin\RegistrationController@delete')->name('admin.registration.delete');
        });

        Route::group(['prefix'  =>   'certificate'], function () {

            Route::get('/', 'Admin\CertificateController@index')->name('admin.certificate.index');
            Route::get('/{id}/create', 'Admin\CertificateController@create')->name('admin.certificate.create');
            Route::post('/store', 'Admin\CertificateController@store')->name('admin.certificate.store');
            Route::get('/{id}/view', 'Admin\CertificateController@show')->name('admin.certificate.view');
            Route::get('/{id}/edit', 'Admin\CertificateController@edit')->name('admin.certificate.edit');
            Route::post('/update', 'Admin\CertificateController@update')->name('admin.certificate.update');
            Route::post('/{id}/delete', 'Admin\CertificateController@delete')->name('admin.certificate.delete');
        });

        Route::group(['prefix' => 'certificate-icbd'], function () {

            Route::get('/', 'Admin\CertificateICBDController@index')->name('admin.certificate_icbd.index');
            Route::get('/{id}/create', 'Admin\CertificateICBDController@create')->name('admin.certificate_icbd.create');
            Route::post('/store', 'Admin\CertificateICBDController@store')->name('admin.certificate_icbd.store');
            Route::get('/{id}/view', 'Admin\CertificateICBDController@show')->name('admin.certificate_icbd.view');
            Route::get('/{id}/edit', 'Admin\CertificateICBDController@edit')->name('admin.certificate_icbd.edit');
            Route::post('/update', 'Admin\CertificateICBDController@update')->name('admin.certificate_icbd.update');
            Route::post('/{id}/delete', 'Admin\CertificateICBDController@delete')->name('admin.certificate_icbd.delete');
            Route::get('/{id}/print', 'Admin\CertificateICBDController@print')->name('admin.certificate_icbd.print');

        });


        Route::group(['prefix'  =>   'stuff'], function () {
            Route::get('/', 'Admin\TeachersController@index')->name('admin.stuff.index');
            Route::get('/create', 'Admin\TeachersController@create')->name('admin.stuff.create');
            Route::post('/store', 'Admin\TeachersController@store')->name('admin.stuff.store');
            Route::get('/{id}/view', 'Admin\TeachersController@show')->name('admin.stuff.view');
            Route::get('/{id}/edit', 'Admin\TeachersController@edit')->name('admin.stuff.edit');
            Route::post('/update', 'Admin\TeachersController@update')->name('admin.stuff.update');
            Route::post('/{id}/delete', 'Admin\TeachersController@delete')->name('admin.stuff.delete');
        });
        Route::group(['prefix'  =>   'stuffcard'], function () {
            Route::get('/{id}/view', 'Admin\StuffIdCardController@show')->name('admin.stuffcard.view');
            Route::get('/{id}/iddownload', 'Admin\StuffIdCardController@iddownload')->name('admin.stuffcard.iddownload');
        });
        Route::group(['prefix'  =>   'branch'], function () {

            Route::get('/', 'Admin\BranchController@index')->name('admin.branch.index');
            Route::get('/create', 'Admin\BranchController@create')->name('admin.branch.create');
            Route::post('/store', 'Admin\BranchController@store')->name('admin.branch.store');
            Route::get('/{id}/view', 'Admin\BranchController@show')->name('admin.branch.view');
            Route::get('/{id}/edit', 'Admin\BranchController@edit')->name('admin.branch.edit');
            Route::post('/update', 'Admin\BranchController@update')->name('admin.branch.update');
            Route::post('/{id}/delete', 'Admin\BranchController@delete')->name('admin.branch.delete');
        });

        //Income Categoris
        Route::group(['prefix'  =>   'inccategoris'], function () {

            Route::get('/', 'Admin\IncomeCategorisController@index')->name('admin.inccategoris.index');
            Route::get('/create', 'Admin\IncomeCategorisController@create')->name('admin.inccategoris.create');
            Route::post('/store', 'Admin\IncomeCategorisController@store')->name('admin.inccategoris.store');
            Route::get('/{id}/view', 'Admin\IncomeCategorisController@show')->name('admin.inccategoris.view');
            Route::get('/{id}/edit', 'Admin\IncomeCategorisController@edit')->name('admin.inccategoris.edit');
            Route::post('/update', 'Admin\IncomeCategorisController@update')->name('admin.inccategoris.update');
            Route::post('/{id}/delete', 'Admin\IncomeCategorisController@delete')->name('admin.inccategoris.delete');
        });

        //Income
        Route::group(['prefix'  =>   'income'], function () {

            Route::get('/', 'Admin\IncomeController@index')->name('admin.income.index');
            Route::get('/create', 'Admin\IncomeController@create')->name('admin.income.create');
            Route::post('/store', 'Admin\IncomeController@store')->name('admin.income.store');
            Route::get('/short', 'Admin\IncomeController@shortShow')->name('short.income.show');
            Route::get('/{id}/view', 'Admin\IncomeController@show')->name('admin.income.view');
            Route::get('/{id}/edit', 'Admin\IncomeController@edit')->name('admin.income.edit');
            Route::post('/update', 'Admin\IncomeController@update')->name('admin.income.update');
            Route::post('/{id}/delete', 'Admin\IncomeController@delete')->name('admin.income.delete');
            Route::get('/getIncomeCategoris/{id}', 'Admin\IncomeController@getIncomeCategoris');
        });

        //Expance Categoris
        Route::group(['prefix'  =>   'expcategoris'], function () {

            Route::get('/', 'Admin\ExpanseCategorisController@index')->name('admin.expcategoris.index');
            Route::get('/create', 'Admin\ExpanseCategorisController@create')->name('admin.expcategoris.create');
            Route::post('/store', 'Admin\ExpanseCategorisController@store')->name('admin.expcategoris.store');
            Route::get('/{id}/view', 'Admin\ExpanseCategorisController@show')->name('admin.expcategoris.view');
            Route::get('/{id}/edit', 'Admin\ExpanseCategorisController@edit')->name('admin.expcategoris.edit');
            Route::post('/update', 'Admin\ExpanseCategorisController@update')->name('admin.expcategoris.update');
            Route::post('/{id}/delete', 'Admin\ExpanseCategorisController@delete')->name('admin.expcategoris.delete');
        });

        //Expance
        Route::group(['prefix'  =>   'expance'], function () {

            Route::get('/', 'Admin\ExpanseController@index')->name('admin.expance.index');
            Route::get('/create', 'Admin\ExpanseController@create')->name('admin.expance.create');
            Route::post('/store', 'Admin\ExpanseController@store')->name('admin.expance.store');
            Route::get('/short', 'Admin\ExpanseController@shortShow')->name('short.expanse.show');
            Route::get('/{id}/view', 'Admin\ExpanseController@show')->name('admin.expance.view');
            Route::get('/{id}/edit', 'Admin\ExpanseController@edit')->name('admin.expance.edit');
            Route::post('/update', 'Admin\ExpanseController@update')->name('admin.expance.update');
            Route::post('/{id}/delete', 'Admin\ExpanseController@delete')->name('admin.expance.delete');
            Route::get('/getExpanseCategoris/{id}', 'Admin\ExpanseController@getExpanceCategoris');
        });

        // Report
        Route::group(['prefix'  =>   'report'], function () {

            //Route::get('/incomereport', 'Admin\ReportController@incindex')->name('admin.incomere.index');
            Route::get('/expancereport', 'Admin\ReportController@expindex')->name('admin.expancere.index');
            Route::post('/getReport', 'Admin\ReportController@getReport')->name('admin.getReport');
          	Route::get('income/report', 'Admin\ReportController@incindex')->name('admin.income.report.index');
			Route::post('income/report', 'Admin\ReportController@getIncomeReport')->name('admin.income.report.get');
            Route::post('/reports/expenses', 'Admin\ReportController@generateReportMonthly')->name('admin.report.monthly');
            Route::get('/category-details/{categoryId}', 'Admin\ReportController@getCategoryDetails')->name('expense.category-details');
            Route::get('/category-details/{categoryId}/{branchId}', 'Admin\ReportController@getCategoryDetails')->name('expense.category-details.branch');
            Route::get('/income-category-details/{categoryId}', 'Admin\ReportController@getIncomeCategoryDetails')->name('income.category-details');
            Route::get('/income-category-details/{categoryId}/{branchId}', 'Admin\ReportController@getIncomeCategoryDetails')->name('income.category-details.branch');
        });

        //Frontend CMS
        Route::group(['prefix'  =>   'slider'], function () {

            Route::get('/', 'Admin\SliderController@index')->name('admin.slider.index');
            Route::get('/create', 'Admin\SliderController@create')->name('admin.slider.create');
            Route::post('/store', 'Admin\SliderController@store')->name('admin.slider.store');
            Route::get('/{id}/edit', 'Admin\SliderController@edit')->name('admin.slider.edit');
            Route::post('/update', 'Admin\SliderController@update')->name('admin.slider.update');
            Route::post('/{id}/delete', 'Admin\SliderController@delete')->name('admin.slider.delete');
        });
        //Frontend CMS
        Route::group(['prefix'  =>   'cmsabout'], function () {

            Route::get('/', 'Admin\CmsAboutController@index')->name('admin.cmsabout.index');
            Route::get('/create', 'Admin\CmsAboutController@create')->name('admin.cmsabout.create');
            Route::post('/store', 'Admin\CmsAboutController@store')->name('admin.cmsabout.store');
            Route::get('/{id}/edit', 'Admin\CmsAboutController@edit')->name('admin.cmsabout.edit');
            Route::post('/update', 'Admin\CmsAboutController@update')->name('admin.cmsabout.update');
            Route::post('/{id}/delete', 'Admin\CmsAboutController@delete')->name('admin.cmsabout.delete');
        });
        // success story
        Route::group(['prefix'  =>   'story'], function () {

            Route::get('/', 'Admin\SuccessStoryController@index')->name('admin.story.index');
            Route::get('/create', 'Admin\SuccessStoryController@create')->name('admin.story.create');
            Route::post('/store', 'Admin\SuccessStoryController@store')->name('admin.story.store');
            Route::get('/{id}/edit', 'Admin\SuccessStoryController@edit')->name('admin.story.edit');
            Route::post('/update', 'Admin\SuccessStoryController@update')->name('admin.story.update');
            Route::post('/{id}/delete', 'Admin\SuccessStoryController@delete')->name('admin.story.delete');
        });
        // seminor
        Route::group(['prefix'  =>   'seminor'], function () {

            Route::get('/', 'Admin\SeminorController@index')->name('admin.seminor.index');
            Route::get('/create', 'Admin\SeminorController@create')->name('admin.seminor.create');
            Route::post('/store', 'Admin\SeminorController@store')->name('admin.seminor.store');
            Route::get('/{id}/edit', 'Admin\SeminorController@edit')->name('admin.seminor.edit');
            Route::post('/update', 'Admin\SeminorController@update')->name('admin.seminor.update');
            Route::post('/{id}/delete', 'Admin\SeminorController@delete')->name('admin.seminor.delete');
        });
         // seminor Registration
         Route::group(['prefix'  =>   'seminorreg'], function () {

            Route::get('/', 'Admin\SeminorRegistrationController@index')->name('admin.seminorreg.index');
            Route::get('/create', 'Admin\SeminorRegistrationController@create')->name('admin.seminorreg.create');
            Route::post('/store', 'Admin\SeminorRegistrationController@store')->name('admin.seminorreg.store');
            Route::get('/{id}/edit', 'Admin\SeminorRegistrationController@edit')->name('admin.seminorreg.edit');
            Route::get('/{id}/view', 'Admin\SeminorRegistrationController@show')->name('admin.seminorreg.view');
            Route::post('/update', 'Admin\SeminorRegistrationController@update')->name('admin.seminorreg.update');
            Route::post('/{id}/delete', 'Admin\SeminorRegistrationController@delete')->name('admin.seminorreg.delete');
        });
        // reviews 
        Route::group(['prefix'  =>   'review'], function () {

            Route::get('/', 'Admin\ReviewController@index')->name('admin.review.index');
            Route::get('/create', 'Admin\ReviewController@create')->name('admin.review.create');
            Route::post('/store', 'Admin\ReviewController@store')->name('admin.review.store');
            Route::get('/{id}/edit', 'Admin\ReviewController@edit')->name('admin.review.edit');
            Route::post('/update', 'Admin\ReviewController@update')->name('admin.review.update');
            Route::post('/{id}/delete', 'Admin\ReviewController@delete')->name('admin.review.delete');
        });

         // Gallery 
         Route::group(['prefix'  =>   'gallery'], function () {

            Route::get('/', 'Admin\GalleryController@index')->name('admin.gallery.index');
            Route::get('/create', 'Admin\GalleryController@create')->name('admin.gallery.create');
            Route::post('/store', 'Admin\GalleryController@store')->name('admin.gallery.store');
            Route::get('/{id}/edit', 'Admin\GalleryController@edit')->name('admin.gallery.edit');
            Route::post('/update', 'Admin\GalleryController@update')->name('admin.gallery.update');
            Route::post('/{id}/delete', 'Admin\GalleryController@delete')->name('admin.gallery.delete');
        });

        // Refund Route Should be protected  

        Route::get('/user/bkash/refund', [BkashController::class, 'getRefund'])->name('get-refund');
        Route::post('/bkash/refund', [BkashController::class, 'refund'])->name('refund');

        Route::get('/user/bkash/refund-status', [BkashController::class, 'getRefundStatus'])->name('get-refund-status');
        Route::post('/bkash/refund-status', [BkashController::class, 'refundStatus'])->name('refund-status');

        // Services
        Route::group(['prefix'  =>  'services'], function () {
            Route::get('/', 'ServiceController@index')->name('admin.services.index');
            Route::get('/create', 'ServiceController@create')->name('admin.services.create');
            Route::post('/store', 'ServiceController@store')->name('admin.services.store');
            Route::get('/{id}/view', 'ServiceController@show')->name('admin.services.show');
            Route::get('/{id}/edit', 'ServiceController@edit')->name('admin.services.edit');
            Route::patch('/update/{id}', 'ServiceController@update')->name('admin.services.update');
            Route::post('/{id}/delete', 'ServiceController@destroy')->name('admin.services.destroy');
        });

        // Products
        Route::group(['prefix'  =>  'products'], function () {
            Route::get('/', 'ProductController@index')->name('admin.products.index');
            Route::get('/create', 'ProductController@create')->name('admin.products.create');
            Route::post('/store', 'ProductController@store')->name('admin.products.store');
            Route::get('/{id}/view', 'ProductController@show')->name('admin.products.show');
            Route::get('/{id}/edit', 'ProductController@edit')->name('admin.products.edit');
            Route::patch('/update/{id}', 'ProductController@update')->name('admin.products.update');
            Route::post('/{id}/delete', 'ProductController@destroy')->name('admin.products.destroy');
        });

        // Concerns
        Route::group(['prefix'  =>  'concerns'], function () {
            Route::get('/', 'ConcernController@index')->name('admin.concerns.index');
            Route::get('/create', 'ConcernController@create')->name('admin.concerns.create');
            Route::post('/store', 'ConcernController@store')->name('admin.concerns.store');
            Route::get('/{id}/view', 'ConcernController@show')->name('admin.concerns.show');
            Route::get('/{id}/edit', 'ConcernController@edit')->name('admin.concerns.edit');
            Route::patch('/update/{id}', 'ConcernController@update')->name('admin.concerns.update');
            Route::post('/{id}/delete', 'ConcernController@destroy')->name('admin.concerns.destroy');
        });

        // Workflows
        Route::group(['prefix'  =>  'workflows'], function () {
            Route::get('/', 'WorkflowController@index')->name('admin.workflows.index');
            Route::get('/create', 'WorkflowController@create')->name('admin.workflows.create');
            Route::post('/store', 'WorkflowController@store')->name('admin.workflows.store');
            Route::get('/{id}/view', 'WorkflowController@show')->name('admin.workflows.show');
            Route::get('/{id}/edit', 'WorkflowController@edit')->name('admin.workflows.edit');
            Route::patch('/update/{id}', 'WorkflowController@update')->name('admin.workflows.update');
            Route::post('/{id}/delete', 'WorkflowController@destroy')->name('admin.workflows.destroy');
        });
    });
});
