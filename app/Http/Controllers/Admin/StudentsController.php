<?php

namespace App\Http\Controllers\Admin;

use App\Models\Students;
use App\Models\Courses;
use App\Models\Batchs;
use App\Models\FeesTransections;
use App\Contracts\StudentsContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\SMSController;

class StudentsController extends BaseController 
{
    // use SMSController;
    /**
     * @var StudentsContract 
     */
    protected $studentsRepository;
    /**
     * CategoryController constructor.
     * @param StudentsContract $studentsRepository
     */
    public function __construct(StudentsContract $studentsRepository)
    {
        $this->studentsRepository = $studentsRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search =  $request->input('q');
        
        $students = Students::with(['batch', 'course', 'latestPayment'])
            ->where('deleted_at', null)
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('sname', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%');
                });
            })
            ->select('id', 'sname', 'phone', 'image', 'batch_id', 'course_id', 'balance', 'IsActive', 'IsRegister', 'admission_date', 'updated_at', 'deleted_at')
            ->orderBy('id', 'desc')
            ->paginate(100);
        
        $students->appends(['q' => $search]);
        
        $this->setPageTitle('Students', 'List of all Students');
        return view('admin.students.index', compact('students'));
    }
    public function complete(Request $request)
    {
        $search =  $request->input('q');
        
        $students = Students::with(['batch', 'course', 'latestPayment'])
            ->where('deleted_at', null)
            ->where('IsActive', 3)
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('sname', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%');
                });
            })
            ->select('id', 'sname', 'phone', 'image', 'batch_id', 'course_id', 'balance', 'IsActive', 'IsRegister', 'admission_date', 'updated_at', 'deleted_at')
            ->orderBy('id', 'desc')
            ->paginate(100);
        
        $students->appends(['q' => $search]);
        
        $this->setPageTitle('Students', 'List of all Complete Students');
        return view('admin.students.index', compact('students'));
    }
    public function active(Request $request)
    {
        $search =  $request->input('q');
        
        $students = Students::with(['batch', 'course', 'latestPayment'])
            ->where('deleted_at', null)
            ->where('IsActive', 1)
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('sname', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%');
                });
            })
            ->select('id', 'sname', 'phone', 'image', 'batch_id', 'course_id', 'balance', 'IsActive', 'IsRegister', 'admission_date', 'updated_at', 'deleted_at')
            ->orderBy('id', 'desc')
            ->paginate(100);
        
        $students->appends(['q' => $search]);
        
        $this->setPageTitle('Students', 'List of all Active Students');
        return view('admin.students.index', compact('students'));
    }
    public function iregular(Request $request)
    {
        $search =  $request->input('q');
        
        $students = Students::with(['batch', 'course', 'latestPayment'])
            ->where('deleted_at', null)
            ->where('IsActive', 2)
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('sname', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%');
                });
            })
            ->select('id', 'sname', 'phone', 'image', 'batch_id', 'course_id', 'balance', 'IsActive', 'IsRegister', 'admission_date', 'updated_at', 'deleted_at')
            ->orderBy('id', 'desc')
            ->paginate(100);
        
        $students->appends(['q' => $search]);
        
        $this->setPageTitle('Students', 'List of all Iregular Students');
        return view('admin.students.index', compact('students'));
    }
    public function resticted(Request $request)
    {
        $search =  $request->input('q');
        
        $students = Students::with(['batch', 'course', 'latestPayment'])
            ->where('deleted_at', null)
            ->where('IsActive', 4)
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('sname', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%');
                });
            })
            ->select('id', 'sname', 'phone', 'image', 'batch_id', 'course_id', 'balance', 'IsActive', 'IsRegister', 'admission_date', 'updated_at', 'deleted_at')
            ->orderBy('id', 'desc')
            ->paginate(100);
        
        $students->appends(['q' => $search]);
        
        $this->setPageTitle('Students', 'List of all Resticted Students');
        return view('admin.students.index', compact('students'));
    }
    public function postpond(Request $request)
    {
        $search =  $request->input('q');
        
        $students = Students::with(['batch', 'course', 'latestPayment'])
            ->where('deleted_at', null)
            ->where('IsActive', 5)
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('sname', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%');
                });
            })
            ->select('id', 'sname', 'phone', 'image', 'batch_id', 'course_id', 'balance', 'IsActive', 'IsRegister', 'admission_date', 'updated_at', 'deleted_at')
            ->orderBy('id', 'desc')
            ->paginate(100);
        
        $students->appends(['q' => $search]);
        
        $this->setPageTitle('Students', 'List of all Postpond Students');
        return view('admin.students.index', compact('students'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function payments()
    {
        $students = Students::where('deleted_at', null)->orderBy('id', 'desc')->get();

        $this->setPageTitle('Payments', 'List of all Students');
        return view('admin.payments.index', compact('students'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $students = $this->studentsRepository->listStudents('id', 'asc');
        $batchs = DB::table('batchs')->where('deleted_at', null)->where('IsActive','!=', 3)->where('IsActive','!=', 0)->get();
        $courses = DB::table('courses')->where('deleted_at', null)->get();

        $this->setPageTitle('Create New Students', 'Create Students');
        return view('admin.students.create', compact('students', 'batchs', 'courses'));
    }

    /**
     * Show the form for getCourseinfo resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCoursesInfo($id)
    {
        $coursefee = Courses::where("id", $id)->pluck("coursefee", "id");
        // dd($coursefee);
        return json_encode($coursefee);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'course_id'  =>  'required',
            'branch_id' => 'required',
            'batch_id' =>  'required',
            'sname' =>  'required',
            'gender' =>  'required',
            'religion' =>  'required',
            'g_phone' =>  'required',
            'course_fee' =>  'required',
            'rel_g' =>  'required',
            'admission_date' =>  'required',
            'image' => 'mimes:jpeg,jpg,png,gif|max:1024'
        ]);

        $batchs = Batchs::where('id', $request->batch_id)->first();
        $courses = Courses::where('id', $request->course_id)->first();
        $sid = Students::orderBy('id', 'desc')->first();
        $sid = $sid->id + 1;

        $params = $request->except('_token');
        $students = $this->studentsRepository->createStudents($params);

        $phone = $request->phone;
        $name = $request->sname;
        $course = $courses->name;
        $modules = $courses->totalmoduls;
        $batchno = $batchs->batchnum;
        // $schedule = $batchs->schedule;

        if ($batchs->day1 == 1) {
            $schedule1 = $batchs->schedule1;
            $day1 = "Friday : $schedule1, ";
        } else {
            $day1 = "";
        }
        if ($batchs->day2 == 1) {
            $schedule2 = $batchs->schedule2;
            $day2 = "Saturday : $schedule2, ";
        } else {
            $day2 = "";
        }
        if ($batchs->day3 == 1) {
            $schedule3 = $batchs->schedule3;
            $day3 = "Sunday : $schedule3, ";
        } else {
            $day3 = "";
        }
        if ($batchs->day4 == 1) {
            $schedule4 = $batchs->schedule4;
            $day4 = "Monday : $schedule4, ";
        } else {
            $day4 = "";
        }
        if ($batchs->day5 == 1) {
            $schedule5 = $batchs->schedule5;
            $day5 = "Tuesday : $schedule5, ";
        } else {
            $day5 = "";
        }
        if ($batchs->day6 == 1) {
            $schedule6 = $batchs->schedule6;
            $day6 = "Wednesday : $schedule6, ";
        } else {
            $day6 = "";
        }
        if ($batchs->day7 == 1) {
            $schedule7 = $batchs->schedule7;
            $day7 = "Thursday : $schedule7, ";
        } else {
            $day7 = "";
        }
        $scheduleClass = "your class schedule is - $day1 $day2 $day3 $day4 $day5 $day6 $day7";
        $msg = "Congratulations! $name, you have admitted $modules modules in $course course. Your SID. $sid, Batch No. $batchno, and $scheduleClass. Thanks, INNOVA Computers BD";
        if (!$students) {
            return $this->responseRedirectBack('Error occurred while creating Students.', 'error', true, true);
        } else {
            $smsCon = new SMSController;
            $smsCon->send_sms($phone, $msg);
            // $smsCon->send_sms($phone, $scheduleClass);
            return $this->responseRedirect('admin.students.index', 'Students added successfully', 'success', false, false);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $targetStudents = $this->studentsRepository->findStudentsById($id);
        $students = $this->studentsRepository->listStudents();
        $batchs = DB::table('batchs')->where('deleted_at', null)->get();
        $courses = DB::table('courses')->where('deleted_at', null)->get();

        $this->setPageTitle('Students', 'View Students : ' . $targetStudents->sname);
        return view('admin.students.show', compact('students', 'targetStudents', 'batchs', 'courses'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // $targetStudents = $this->studentsRepository->findStudentsById($request->id);
        $targetStudents = Students::where('deleted_at', null)->where('id', $request->id)->orWhere('sname', 'LIKE', '%' . $request->id . '%')->first();
        $students = $this->studentsRepository->listStudents();
        $batchs = DB::table('batchs')->where('deleted_at', null)->get();
        $courses = DB::table('courses')->where('deleted_at', null)->get();
        // dd($targetStudents);
        if ($targetStudents != null) {
            $this->setPageTitle('Students', 'View Students : ' . $targetStudents->sname);
            return view('admin.students.show', compact('students', 'targetStudents', 'batchs', 'courses'));
        } else {
            return view('admin.students.404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $targetStudents = $this->studentsRepository->findStudentsById($id);
        $students = $this->studentsRepository->listStudents();
        $batchs = DB::table('batchs')->where('deleted_at', null)->get();
        $courses = DB::table('courses')->where('deleted_at', null)->get();

        $this->setPageTitle('Students', 'Edit Students : ' . $targetStudents->sname);
        return view('admin.students.edit', compact('students', 'targetStudents', 'batchs', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $this->validate($request, [
            'course_id'  =>  'required',
            'branch_id' => 'required',
            'batch_id' =>  'required',
            'sname' =>  'required',
            'gender' =>  'required',
            'religion' =>  'required',
            'g_phone' =>  'required',
            'rel_g' =>  'required',
            'course_fee' =>  'required',
            'admission_date' =>  'required',
            'image' => 'mimes:jpeg,jpg,png,gif|max:1024'
        ]);
        $params = $request->except('_token');
        // dd($params);
        $students = $this->studentsRepository->updateStudents($params);

        if (!$students) {
            return $this->responseRedirectBack('Error occurred while updating Students.', 'error', true, true);
        }
        return $this->responseRedirect('admin.students.index', 'Students updated successfully', 'success', false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        date_default_timezone_set('Asia/Dhaka');
        $date = date('y-m-d h:i:s');
        $students = DB::table('students')->where('id', $id)->update(['deleted_at' => $date]);

        if (!$students) {
            return $this->responseRedirectBack('Error occurred while deleting Students.', 'error', true, true);
        }
        return $this->responseRedirect('admin.students.index', 'Students deleted successfully', 'success', false, false);
    }
}
