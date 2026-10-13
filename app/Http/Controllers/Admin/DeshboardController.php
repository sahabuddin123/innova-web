<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FeesTransections;
use App\Models\Batchs;
use App\Models\Courses;
use App\Models\Students;
use App\Models\Registration;
class DeshboardController extends Controller
{
    public function index(){
        $allstudent = Students::where('deleted_at', null)->get();
        $totalstudent = $allstudent->count();
        
        $activestuent = Students::where('IsActive', 1)->where('deleted_at', null)->get();
        $activestuent = $activestuent->count();

        $iregularstudent = Students::where('IsActive', 2)->where('deleted_at', null)->get();
        $iregularstudent = $iregularstudent->count();

        $completestudent = Students::where('IsActive', 3)->where('deleted_at', null)->get();
        $completestudent = $completestudent->count();

        $restrictedstudent = Students::where('IsActive', 4)->where('deleted_at', null)->get();
        $restrictedstudent = $restrictedstudent->count();

        $registerStudent =Registration::where('deleted_at', null)->get();
        $registerStudent = $registerStudent->count();

        $postponded = Students::where('IsActive', 5)->where('deleted_at', null)->get();
        $postponded = $postponded->count();

        $totalbatch = Batchs::where('deleted_at', null)->where('deleted_at', null)->get();
        $totalbatch = $totalbatch->count();

        $runningbatch = Batchs::where('IsActive', 1)->where('deleted_at', null)->get();
        $runningbatch = $runningbatch->count();

        $completebatch = Batchs::where('IsActive', 3)->where('deleted_at', null)->get();
        $completebatch = $completebatch->count();

        $pendingbatch = Batchs::where('IsActive', 0)->where('deleted_at', null)->get();
        $pendingbatch = $pendingbatch->count();

        $upcommingbatch = Batchs::where('IsActive', 2)->where('deleted_at', null)->get();
        $upcommingbatch = $upcommingbatch->count();

        $totalcourse = Courses::where('deleted_at', null)->get();
        $totalcourse = $totalcourse->count();

        $totalpayments = FeesTransections::sum('paidamount');

        $payableamount = Students::where('deleted_at', null)->sum('balance');

        $totaldueamount = $payableamount - $totalpayments;

        $currentMonth = date('m');
        $paidcurrentMonth = FeesTransections::whereMonth('paiddate', date('m'))->sum('paidamount');

        // Additional stats for enhanced dashboard
        $totalstuff = \App\Models\Teachers::count() ?? 0;
        $totalcertificate = \App\Models\Certificate_icbd::count() ?? 0;
        $totalbranch = \App\Models\Branch::count() ?? 0;
        $totalsession = \App\Models\Session::count() ?? 0;
        
        // Income & Expense (using createDate field)
        $incomeThisMonth = \App\Models\Income::whereMonth('createDate', date('m'))->whereYear('createDate', date('Y'))->sum('amount') ?? 0;
        $expenseThisMonth = \App\Models\Expanse::whereMonth('createDate', date('m'))->whereYear('createDate', date('Y'))->sum('amount') ?? 0;
        
        // Monthly Income & Expense for Chart (using createDate field)
        $monthlyIncome = [];
        $monthlyExpense = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyIncome[] = \App\Models\Income::whereMonth('createDate', str_pad($i, 2, '0', STR_PAD_LEFT))->whereYear('createDate', date('Y'))->sum('amount') ?? 0;
            $monthlyExpense[] = \App\Models\Expanse::whereMonth('createDate', str_pad($i, 2, '0', STR_PAD_LEFT))->whereYear('createDate', date('Y'))->sum('amount') ?? 0;
        }
        
        // Online Admission
        $onlineAdmission = \App\Models\Admission::where('deleted_at', null)->count() ?? 0;
        
        // Recent Students
        $recentStudents = Students::where('deleted_at', null)->orderBy('id', 'desc')->limit(5)->get();
        
        // Recent Payments
        $recentPayments = FeesTransections::orderBy('id', 'desc')->limit(5)->get();

        // Top Courses
        $topCourses = Courses::withCount('students')->orderBy('students_count', 'desc')->limit(5)->get();

        // Debugging data
        \Log::info('Recent Students:', $recentStudents->toArray());
        \Log::info('Recent Payments:', $recentPayments->toArray());
        \Log::info('Top Courses:', $topCourses->toArray());
        
        // Progress Char Start
        $m01 = FeesTransections::whereMonth('paiddate', '01')->whereYear('paiddate', date('Y'))->sum('paidamount');
        $m02 = FeesTransections::whereMonth('paiddate', '02')->whereYear('paiddate', date('Y'))->sum('paidamount');
        $m03 = FeesTransections::whereMonth('paiddate', '03')->whereYear('paiddate', date('Y'))->sum('paidamount');
        $m04 = FeesTransections::whereMonth('paiddate', '04')->whereYear('paiddate', date('Y'))->sum('paidamount');
        $m05 = FeesTransections::whereMonth('paiddate', '05')->whereYear('paiddate', date('Y'))->sum('paidamount');
        $m06 = FeesTransections::whereMonth('paiddate', '06')->whereYear('paiddate', date('Y'))->sum('paidamount');
        $m07 = FeesTransections::whereMonth('paiddate', '07')->whereYear('paiddate', date('Y'))->sum('paidamount');
        $m08 = FeesTransections::whereMonth('paiddate', '08')->whereYear('paiddate', date('Y'))->sum('paidamount');
        $m09 = FeesTransections::whereMonth('paiddate', '09')->whereYear('paiddate', date('Y'))->sum('paidamount');
        $m10 = FeesTransections::whereMonth('paiddate', '10')->whereYear('paiddate', date('Y'))->sum('paidamount');
        $m11 = FeesTransections::whereMonth('paiddate', '11')->whereYear('paiddate', date('Y'))->sum('paidamount');
        $m12 = FeesTransections::whereMonth('paiddate', '12')->whereYear('paiddate', date('Y'))->sum('paidamount');
        $areacahrt = [$m01,$m02,$m03,$m04,$m05,$m06,$m07,$m08,$m09,$m10,$m11,$m12];
        $piedata = [$totalpayments,$totaldueamount];
        

        return view('admin.dashboard.index',compact(
            'totalstudent',
            'activestuent',
            'iregularstudent',
            'completestudent',
            'restrictedstudent',
            'runningbatch',
            'completebatch',
            'pendingbatch',
            'totalbatch',
            'totalcourse',
            'totalpayments',
            'payableamount',
            'totaldueamount',
            'paidcurrentMonth',
            'areacahrt',
            'piedata',
            'postponded',
            'upcommingbatch',
            'registerStudent',
            'totalstuff',
            'totalcertificate',
            'totalbranch',
            'totalsession',
            'incomeThisMonth',
            'expenseThisMonth',
            'monthlyIncome',
            'monthlyExpense',
            'onlineAdmission',
            'recentStudents',
            'recentPayments',
            'topCourses'
        ));
    }
}
